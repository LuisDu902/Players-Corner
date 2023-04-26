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


  function getTicketId()
  {
    return $this->ticketId;
  }

  function updateTicketStatus(PDO $db, int $ticketId, string $status)
  {
    $stmt = $db->prepare('
        UPDATE Ticket SET status = ?
        WHERE id = ?
      ');

    $stmt->execute(array($ticketId, $status));
  }

  static function updateReplier(PDO $db, int $ticketId, string $replier)
  {
    $stmt = $db->prepare('
        UPDATE Ticket SET replier=? , status="assigned"
        WHERE id=?
      ');

    $stmt->execute(array($replier, $ticketId));

  }

  static function registerTicket(PDO $db, int $ticketId, array $tags, string $title, string $text, string $priority, string $category, string $status, string $date, string $visibility, string $creator)
  {
    $stmt = $db->prepare('INSERT INTO Ticket (id, title, text, createDate, visibility, priority, status, category, frequentItem,creator,replier) VALUES (?,?,?,?,?, ?, ?, ?,NULL,?,NULL)');
    $stmt->execute(array($ticketId, $title, $text, $date, $visibility, $priority, $status, $category, $creator));
  }


  static function getTicket(PDO $db, int $ticketId): Ticket
  {
    $stmt = $db->prepare('
        SELECT id, title, text, createDate, visibility, priority, status, category, frequentItem,creator,replier
        FROM Ticket 
        WHERE id = ?
      ');

    $stmt->execute(array($ticketId));
    $ticket = $stmt->fetch();

    return new Ticket(
      $ticket['id'],
      $ticket['title'],
      $ticket['text'],
      $ticket['createDate'],
      $ticket['visibility'],
      $ticket['priority'],
      $ticket['status'],
      $ticket['category'],
      Ticket::getTicketTags($db, $ticket['id']),
      User::getUser($db, $ticket['creator']),
      User::getUser($db, $ticket['replier'])
    );
  }

  function assignTicket(PDO $db, int $ticketId, string $replier)
  {
    $stmt = $db->prepare('
       UPDATE Ticket SET replier = ?
       WHERE id = ?
      ');

    $stmt->execute(array($replier, $ticketId));

  }

  static function getTicketTags(PDO $db, int $ticketId): array
  {
    $stmt = $db->prepare('
    SELECT tag
    FROM TicketTag 
    WHERE ticket = ?
  ');

    $stmt->execute(array($ticketId));
    $tags = array();

    while ($tag = $stmt->fetchColumn()){
      $tags[] = $tag;
    }
    return $tags;
  }
  function updateFrequentItem(PDO $db, int $ticketId, string $frequentItem)
  {
    $stmt = $db->prepare('
        UPDATE Ticket SET frequentItem = ?
        WHERE id = ?
       ');

    $stmt->execute(array($frequentItem + 1, $ticketId));

  }
  function updateDepartement(PDO $db, int $ticketId, string $category)
  {
    $stmt = $db->prepare('
        UPDATE Ticket SET category=?
        WHERE id=?
      ');
    $stmt->execute(array($category, $ticketId));
  }

  static function getUserTickets(PDO $db, int $userId): array
  {

    $stmt = $db->prepare(
      'SELECT id, title, text, createDate, visibility, priority, status, category, frequentItem, creator, replier
             FROM Ticket 
             WHERE creator = ?'
    );
    $stmt->execute(array($userId));

    $tickets = array();
    while ($ticket = $stmt->fetch()) {
      $tickets[] = new Ticket(
        intval($ticket['id']),
        $ticket['title'],
        $ticket['text'],
        $ticket['createDate'],
        $ticket['visibility'],
        $ticket['priority'],
        $ticket['status'],
        $ticket['category'],
        Ticket::getTicketTags($db, $ticket['id']),
        User::getUser($db, $ticket['creator']),
        User::getUser($db, $ticket['replier'])
      );
    }
    return $tickets;
  }

  function getMessages($db): array
  {
    $stmt = $db->prepare(
      'SELECT id, text, sent, user, ticket
         FROM Message 
         WHERE ticket = ?'
    );

    $stmt->execute(array($this->ticketId));

    $messages = array();
    while ($message = $stmt->fetch()) {
      $messages[] = new Message(
        intval($message['id']),
        $message['text'],
        $message['sent'],
        User::getUser($db, intval($message['user'])),
        intval($message['ticket']),
      );
    }
    return $messages;
  }

  static function searchTickets(PDO $db, string $search = '', string $filter = 'title', string $order = 'title'): array
  {

    if ($filter == "creator" && $search != '') {
      $query = 'SELECT id, title, text, createDate, visibility, priority, status, category, frequentItem, creator, replier
      FROM Ticket JOIN User ON User.userId = Ticket.creator
      WHERE User.name LIKE ?
      ORDER BY ' . $order;

    } else if ($filter == "replier" && $search != '') {
      $query = 'SELECT id, title, text, createDate, visibility, priority, status, category, frequentItem, creator, replier
      FROM Ticket JOIN User ON User.userId = Ticket.replier
      WHERE User.name LIKE ?
      ORDER BY ' . $order;
    }
    else if ($filter == 'tag'){
      $query = 'SELECT id, title, text, createDate, visibility, priority, status, category, frequentItem, creator, replier
      FROM Ticket 
      WHERE id IN 
        (SELECT ticket
        FROM TicketTag
        WHERE tag LIKE ?)
      ORDER BY ' . $order;
    }
    else {
      $query = 'SELECT id, title, text, createDate, visibility, priority, status, category, frequentItem, creator, replier
              FROM Ticket 
              WHERE ' . $filter . ' LIKE ? 
              ORDER BY ' . $order;
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
        $ticket['priority'],
        $ticket['status'],
        $ticket['category'],
        Ticket::getTicketTags($db, $ticket['id']),
        User::getUser($db, $ticket['creator']),
        User::getUser($db, $ticket['replier'])
      );
    }

    return $tickets;
  }
}
?>