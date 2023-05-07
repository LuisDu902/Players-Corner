<?php

require_once(__DIR__ . "/../classes/user.class.php");
class Ticket
{
  public int $ticketId;
  public array $tags;
  public string $title;
  public string $text;
  public string $priority;
  public string $status;
  public string $date;
  public string $category;
  public string $visibility;
  public User $creator;
  public User $replier;
  public int $frequentItem;

  public function __construct(int $ticketId, string $title, string $text, string $date, string $visibility, string $priority, string $status, string $category, array $tags, User $creator, User $replier)
  {
    $this->ticketId = $ticketId;
    $this->tags = $tags;
    $this->title = $title;
    $this->text = $text;
    $this->priority = $priority;
    $this->status = $status;
    $this->date = $date;
    $this->visibility = $visibility;
    $this->creator = $creator;
    $this->replier = $replier;
    $this->frequentItem = 0;
    $this->category = $category;
  }

  function getTicketHistory(PDO $db) : array{
    $stmt = $db->prepare(
      'SELECT TicketHistory.id, ticketId, user, date, changes, old_field, new_field 
      FROM TicketHistory JOIN FieldChange ON TicketHistory.field = FieldChange.id
      WHERE ticketId = ?'
    );
    $stmt->execute(array($this->ticketId));

    $history = array();
    while ($change = $stmt->fetch()) {
      $history[] = new Change(
        intval($change['id']),
        User::getUser($db, intval($change['user'])),
        $this,
        $change['date'],
        $change['changes'],
        $change['old_field'],
        $change['new_field'],
      );
    }
    return $history;
  }

  static function getUserTickets(PDO $db, int $userId): array
  {

    $stmt = $db->prepare('SELECT * FROM Ticket WHERE creator = ?');
    $stmt->execute(array($userId));
    $tickets = array();

    while ($ticket = $stmt->fetch()) {
      $tickets[] = new Ticket(
        intval($ticket['id']),
        $ticket['title'],
        $ticket['text'],
        $ticket['createDate'],
        $ticket['visibility'],
        substr($ticket['priority'], 2),
        $ticket['status'],
        $ticket['category'],
        Ticket::getTicketTags($db, $ticket['id']),
        User::getUser($db, $ticket['creator']),
        User::getUser($db, $ticket['replier'])
      );
    }
    return $tickets;
  }

  function getMessages(PDO $db): array
  {
    $stmt = $db->prepare(
      'SELECT id, user, ticket, text, date
       FROM Message 
       WHERE ticket = ?'
    );

    $stmt->execute(array($this->ticketId));

    $messages = array();
    while ($message = $stmt->fetch()) {
      $messages[] = new Message(
        intval($message['id']),
        User::getUser($db, intval($message['user'])),
        $this,
        $message['text'],
        $message['date'],
      );
    }
    return $messages;
  }
  
  static function getTicket(PDO $db, int $ticketId): Ticket
  {
    $stmt = $db->prepare('SELECT * FROM Ticket WHERE id = ?');
    $stmt->execute(array($ticketId));
    $ticket = $stmt->fetch();

    return new Ticket(
      $ticket['id'],
      $ticket['title'],
      $ticket['text'],
      $ticket['createDate'],
      $ticket['visibility'],
      substr($ticket['priority'], 2),
      $ticket['status'],
      $ticket['category'],
      Ticket::getTicketTags($db, $ticket['id']),
      User::getUser($db, $ticket['creator']),
      User::getUser($db, $ticket['replier'])
    );
  }

  static function getTicketTags(PDO $db, $ticketId): array
  {
    $stmt = $db->prepare('SELECT tag FROM TicketTag WHERE ticket = ?');

    $stmt->execute(array($ticketId));
    $tags = array();

    while ($tag = $stmt->fetchColumn()) {
      $tags[] = $tag;
    }
    return $tags;
  }

  static function searchTickets(PDO $db, string $search = '', string $filter = 'title', string $order = 'title'): array
  {
    //prevent SQL injection attacks
    if ($order!='createDate' && $order!='visibility' && $order!='priority' && $order!='status' && $order!='category') $order = 'title';
  
    if ($filter == "creator" && $search != '') {
      $query = 'SELECT * FROM Ticket JOIN User ON User.userId = Ticket.creator WHERE User.name LIKE ? ORDER BY ' . $order;
    } 
    else if ($filter == "replier" && $search != '') {
      $query = 'SELECT * FROM Ticket JOIN User ON User.userId = Ticket.replier WHERE User.name LIKE ? ORDER BY ' . $order;
    } 
    else if ($filter == 'tag') {
      $query = 'SELECT * FROM Ticket WHERE id IN (SELECT ticket FROM TicketTag WHERE tag LIKE ?) ORDER BY ' . $order;
    } 
    else {
      if ($filter != 'category' && $filter != 'visibility' && $filter != 'status' && $filter != 'priority') $filter = 'title';
      $query = 'SELECT * FROM Ticket WHERE ' . $filter . ' LIKE ? ORDER BY ' . $order;
    }
    $stmt = $db->prepare($query);
    $stmt->execute(array($search . '%'));
    $tickets = array();

    while ($ticket = $stmt->fetch()) {
      $tickets[] = new Ticket(
        intval($ticket['id']),
        $ticket['title'],
        $ticket['text'],
        $ticket['createDate'],
        $ticket['visibility'],
        substr($ticket['priority'], 2),
        $ticket['status'],
        $ticket['category'],
        Ticket::getTicketTags($db, $ticket['id']),
        User::getUser($db, $ticket['creator']),
        User::getUser($db, $ticket['replier'])
      );
    }

    return $tickets;
  }

  function assignTicket(PDO $db, int $userId, string $replier)
  {
    $stmt = $db->prepare("UPDATE Ticket SET replier = ? , status='assigned' WHERE id = ?");
    $stmt->execute(array($replier, $this->ticketId));

    $this->addHistory($db, $userId, "Status changed", 1);
  }

  static function registerTicket(PDO $db, array $tags, string $title, string $text, string $priority, string $category, string $visibility, int $creator)
  {
    $stmt = $db->prepare("INSERT INTO Ticket (id, title, text, createDate, visibility, priority, status, category, frequentItem, creator, replier) VALUES (NULL, ?, ?, CURRENT_TIMESTAMP, ?, ?, 'new', ?, NULL, ?, 0)");
    $stmt->execute(array($title, $text, $visibility, $priority, $category, $creator));   
    $ticketId = $db->lastInsertId();
    foreach ($tags as $tag){
      $stmt = $db->prepare("INSERT INTO TicketTag (ticket, tag) VALUES (?, ?)");
      $stmt->execute(array($ticketId, $tag));   
    }
  }


  function answerWithFrequentItem(PDO $db, string $frequentItem)
  {
    $stmt = $db->prepare('UPDATE Ticket SET frequentItem = ? WHERE id = ?');
    $stmt->execute(array($frequentItem, $this->ticketId));
  }
  function changeDepartment(PDO $db, int $userId, string $category)
  {
    $stmt = $db->prepare('UPDATE Ticket SET category=? WHERE id=?');
    $stmt->execute(array($category, $this->ticketId));
   
    if (!Change::fieldChangeExists($db, $this->category, $category)){
      Change::addFieldChange($db, $this->category, $category);      
    } 
    
    $field = Change::getChangeId($db, $this->category, $category);
    
    $this->addHistory($db, $userId, "Department changed", $field);
  }
  function changeStatus(PDO $db, int $userId, string $status)
  {
    $stmt = $db->prepare('UPDATE Ticket SET status = ? WHERE id = ?');
    $stmt->execute(array($status, $this->ticketId));

    if (!Change::fieldChangeExists($db, $this->status, $status)){
      Change::addFieldChange($db, $this->status, $status);      
    } 
    
    $field = Change::getChangeId($db, $this->status, $status);
    
    $this->addHistory($db, $userId, "Status changed", $field);
  }

  function changePriority(PDO $db, int $userId, string $priority)
  {
    $stmt = $db->prepare('UPDATE Ticket SET priority = ? WHERE id = ?');
    $stmt->execute(array($priority, $this->ticketId));
    
    if (!Change::fieldChangeExists($db, $this->priority, $priority)){
      Change::addFieldChange($db, $this->priority, $priority);      
    } 
    
    $field = Change::getChangeId($db, $this->priority, $priority);
    
    $this->addHistory($db, $userId, "Priority changed", $field);
  }
 
  function addTag(PDO $db, string $tag)
  {
    $stmt = $db->prepare('INSERT INTO TicketTag (ticket, tag) VALUES (?,?)');
    $stmt->execute(array($this->ticketId, $tag));
  }

  function removeTag(PDO $db, string $tag)
  {
    $stmt = $db->prepare('DELETE FROM TicketTag WHERE ticket=? AND tag=?');
    $stmt->execute(array($this->ticketId, $tag));
  }

  function addMessage(PDO $db, int $userId, string $text)
  {
    $stmt = $db->prepare('INSERT INTO Message (id, user, ticket, text, date) VALUES (NULL, ?,?, ?, CURRENT_TIMESTAMP)');
    $stmt->execute(array($userId, $this->ticketId, $text));
  }

  function addHistory(PDO $db, int $userId, String $changes, int $field){
    $stmt = $db->prepare('INSERT INTO TicketHistory(id, ticketId, user, date, changes, field) VALUES (NULL, ?, ?, CURRENT_TIMESTAMP, ?, ?)');
    $stmt->execute(array($this->ticketId, $userId, $changes, $field));
  }


}
?>