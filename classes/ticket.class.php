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

  function changeStatus(PDO $db, string $status)
  {
    $stmt = $db->prepare('UPDATE Ticket SET status = ? WHERE id = ?');
    $stmt->execute(array($this->ticketId, $status));
  }

  function changePriority(PDO $db, string $priority)
  {
    $stmt = $db->prepare('UPDATE Ticket SET priority = ? WHERE id = ?');
    $stmt->execute(array($this->ticketId, $priority));
  }

  function assignTicket(PDO $db, string $replier)
  {
    $stmt = $db->prepare("UPDATE Ticket SET replier = ? , status='assigned' WHERE id = ?");
    $stmt->execute(array($replier, $this->ticketId));
  }

  static function registerTicket(PDO $db, array $tags, string $title, string $text, string $priority, string $category, string $date, string $visibility, string $creator)
  {
    $stmt = $db->prepare("INSERT INTO Ticket (id, title, text, createDate, visibility, priority, status, category, frequentItem,creator,replier) VALUES (NULL,?,?,?,?, ?, 'new', ?,NULL,?,NULL)");
    $stmt->execute(array($title, $text, $date, $visibility, $priority, $category, $creator));
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
  function answerWithFrequentItem(PDO $db, string $frequentItem)
  {
    $stmt = $db->prepare('UPDATE Ticket SET frequentItem = ? WHERE id = ?');
    $stmt->execute(array($frequentItem, $this->ticketId));
  }
  function changeDepartment(PDO $db, string $category)
  {
    $stmt = $db->prepare('UPDATE Ticket SET category=? WHERE id=?');
    $stmt->execute(array($category, $this->ticketId));
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

  function removeTag(PDO $db, string $tag)
  {
    $stmt = $db->prepare('DELETE FROM TicketTag WHERE ticket=? AND tag=?');
    $stmt->execute(array($this->ticketId, $tag));
  }

  function addTag(PDO $db, string $tag)
  {
    $stmt = $db->prepare('INSERT INTO TicketTag (ticket, tag) VALUES (?,?)');
    $stmt->execute(array($this->ticketId, $tag));
  }

  function addMessage(PDO $db, int $userId, string $text)
  {
    $stmt = $db->prepare('INSERT INTO Message (id, user, ticket, text, date) VALUES (NULL, ?,?, ?, "2023-04-05")');
    $stmt->execute(array($userId, $this->ticketId));
  }

}
?>