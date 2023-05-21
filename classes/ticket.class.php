<?php

require_once(__DIR__ . "/user.class.php");
require_once(__DIR__ . "/change.class.php");
require_once(__DIR__ . "/faq.class.php");
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
  public int $feedback;

  public function __construct(int $ticketId, string $title, string $text, string $date, string $visibility, string $priority, string $status, string $category, array $tags, User $creator, User $replier, int $feedback)
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
    $this->category = $category;
    $this->feedback = $feedback;
  }

  function getAttachedFiles(): array
  {
    $ticketFiles = array();
    $files = scandir('../files');
    foreach ($files as $file) {
      if (strpos($file, 'ticket' . $this->ticketId . '_') === 0) {
        $filename = explode('_', $file, 2)[1];
        $ticketFiles[] = $filename;
      }
    }
    return $ticketFiles;
  }


  function getTicketHistory(PDO $db): array
  {
    $stmt = $db->prepare(
      'SELECT TicketHistory.id, ticketId, user, date, changes, old_field, new_field 
      FROM TicketHistory JOIN FieldChange ON TicketHistory.field = FieldChange.id
      WHERE ticketId = ? ORDER BY date'
    );
    $stmt->execute(array($this->ticketId));

    $history = array();
    while ($change = $stmt->fetch()) {
      $date = $change['date'];
      if (!isset($history[$date])) {
        $history[$date] = array();
      }
      $history[$date][] = new Change(
        intval($change['id']),
        User::getUser($db, intval($change['user'])),
        $this,
        $change['date'],
        $change['changes'],
        $change['old_field'],
        $change['new_field']
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
      $replier = ($ticket['replier']) ? $ticket['replier'] : 0;
      $tickets[] = new Ticket(
        intval($ticket['id']),
        htmlentities($ticket['title']),
        htmlentities($ticket['text']),
        $ticket['createDate'],
        $ticket['visibility'],
        substr($ticket['priority'], 2),
        $ticket['status'],
        $ticket['category'],
        Ticket::getTicketTags($db, $ticket['id']),
        User::getUser($db, $ticket['creator']),
        User::getUser($db, $replier),
        intval($ticket['feedback'])
      );
    }
    return $tickets;
  }

  function getMessages(PDO $db): array
  {
    $stmt = $db->prepare('SELECT * FROM Message WHERE ticket = ?');

    $stmt->execute(array($this->ticketId));

    $messages = array();
    while ($message = $stmt->fetch()) {
      $messages[] = array(
        'user' => User::getUser($db, intval($message['user'])),
        'text' => htmlentities($message['text']),
        'date' => $message['date'],
      );
    }
    return $messages;
  }

  static function getTicket(PDO $db, int $ticketId): Ticket
  {
    $stmt = $db->prepare('SELECT * FROM Ticket WHERE id = ?');
    $stmt->execute(array($ticketId));
    $ticket = $stmt->fetch();
    $replier = ($ticket['replier']) ? $ticket['replier'] : 0;
    return new Ticket(
      $ticket['id'],
      htmlentities($ticket['title']),
      htmlentities($ticket['text']),
      $ticket['createDate'],
      $ticket['visibility'],
      substr($ticket['priority'], 2),
      $ticket['status'],
      $ticket['category'],
      Ticket::getTicketTags($db, $ticket['id']),
      User::getUser($db, $ticket['creator']),
      User::getUser($db, $replier),
      intval($ticket['feedback'])
    );
  }

  static function getTicketTags(PDO $db, $ticketId): array
  {
    $stmt = $db->prepare('SELECT tag FROM TicketTag WHERE ticket = ?');

    $stmt->execute(array($ticketId));
    $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);
    return $tags;
  }

  static function searchTickets(PDO $db, int $userId, string $search = '', string $filter = 'title', string $order = 'title'): array
  {
    $search = strtolower($search);
    //prevent SQL injection attacks
    if ($order != 'createDate' && $order != 'visibility' && $order != 'priority' && $order != 'status' && $order != 'category')
      $order = 'title';

    if ($filter == "creator" && $search != '') {
      $query = 'SELECT * FROM Ticket JOIN User ON User.userId = Ticket.creator WHERE User.name LIKE ? ORDER BY ' . $order;
    } else if ($filter == "replier" && $search != '') {
      $query = 'SELECT * FROM Ticket JOIN User ON User.userId = Ticket.replier WHERE User.name LIKE ? ORDER BY ' . $order;
    } else if ($filter == 'tag') {
      $query = 'SELECT * FROM Ticket WHERE id IN (SELECT ticket FROM TicketTag WHERE tag LIKE ?) ORDER BY ' . $order;
    } else if ($filter == 'priority') {
      switch ($search[0]) {
        case 'c':
          $search = '1-' . $search;
          break;
        case 'h':
          $search = '2-' . $search;
          break;
        case 'm':
          $search = '3-' . $search;
          break;
        case 'l':
          $search = '4-' . $search;
          break;
      }
      $query = 'SELECT * FROM Ticket WHERE id IN (SELECT ticket FROM TicketTag WHERE priority LIKE ?) ORDER BY ' . $order;
    } else {
      if ($filter != 'category' && $filter != 'visibility' && $filter != 'status' && $filter != 'priority')
        $filter = 'title';
      $query = 'SELECT * FROM Ticket WHERE ' . $filter . ' LIKE ? ORDER BY ' . $order;
    }
    $stmt = $db->prepare($query);
    $stmt->execute(array($search . '%'));
    $tickets = array();

    $user = User::getUser($db, $userId);
    if ($user->type === 'agent')
      $agentDepartments = $user->getAgentDepartments($db);

    while ($ticket = $stmt->fetch()) {
      $replier = ($ticket['replier']) ? $ticket['replier'] : 0;
      if ($ticket['visibility'] === 'public' || $user->type === 'admin' || ($user->type === 'agent' && in_array($ticket['category'], $agentDepartments)) || ($ticket['creator'] === $userId)) {
        $tickets[] = new Ticket(
          intval($ticket['id']),
          htmlentities($ticket['title']),
          htmlentities($ticket['text']),
          $ticket['createDate'],
          $ticket['visibility'],
          substr($ticket['priority'], 2),
          $ticket['status'],
          $ticket['category'],
          Ticket::getTicketTags($db, $ticket['id']),
          User::getUser($db, $ticket['creator']),
          User::getUser($db, $replier),
          intval($ticket['feedback'])
        );
      }
    }

    return $tickets;
  }

  function assignTicket(PDO $db, int $userId, int $replier)
  {
    $stmt = $db->prepare("UPDATE Ticket SET replier = ? , status='assigned' WHERE id = ?");
    $stmt->execute(array($replier, $this->ticketId));

    $this->addHistory($db, $userId, "Status changed", 1);
  }

  static function registerTicket(PDO $db, array $tags, string $title, string $text, string $priority, string $category, string $visibility, int $creator)
  {
    $stmt = $db->prepare("INSERT INTO Ticket (title, text, createDate, visibility, priority, status, category, creator) VALUES (?, ?, CURRENT_TIMESTAMP, ?, ?, 'new', ?, ?)");
    $stmt->execute(array($title, $text, $visibility, $priority, $category, $creator));
    $ticketId = $db->lastInsertId();
    foreach ($tags as $tag) {
      if ($tag !== '') {
        $stmt = $db->prepare("INSERT INTO TicketTag (ticket, tag) VALUES (?, ?)");
        $stmt->execute(array($ticketId, $tag));
      }
    }
    $stmt = $db->prepare("INSERT INTO TicketHistory(ticketId, user, date, changes, field) VALUES (?, ?, CURRENT_TIMESTAMP, 'ticket created', 0)");
    $stmt->execute(array($ticketId, $creator));
  }

  function changeAgent(PDO $db, int $userId, int $replier)
  {
    $stmt = $db->prepare("UPDATE Ticket SET replier = ? WHERE id = ?");
    $stmt->execute(array($replier, $this->ticketId));

    $newAgent = User::getUser($db, $replier);

    if (!Change::fieldChangeExists($db, $this->replier->name, $newAgent->name)) {
      Change::addFieldChange($db, $this->replier->name, $newAgent->name);
    }

    $change = Change::getChangeId($db, $this->replier->name, $newAgent->name);
    if ($this->replier->userId !== 0) {
      $this->addHistory($db, $userId, 'replier changed', $change);
    } else {
      $this->addHistory($db, $userId, 'ticket assigned to ' . $newAgent->name, $change);
    }

  }

  function changeProperties(PDO $db, int $userId, int $replier, string $new_tags, string $new_category, string $new_priority, string $new_status, string $new_visibility)
  {

    $this->changeTags($db, $userId, $new_tags);

    if ($replier !== $this->replier->userId) {
      if ($this->status === 'new') {
        $this->updateField($db, $userId, 'status', 'assigned');
      }
      $this->changeAgent($db, $userId, $replier);
    }

    if ($new_category !== $this->category) {
      $this->updateField($db, $userId, 'category', $new_category);
    }

    if ($new_status !== $this->status && ($this->status !== 'new')) {
      $this->updateField($db, $userId, 'status', $new_status);
    }

    if ($new_priority !== $this->priority) {
      $this->updateField($db, $userId, 'priority', $new_priority);
    }

    if ($new_visibility !== $this->visibility) {
      $this->updateField($db, $userId, 'visibility', $new_visibility);
    }
  }

  function updateField(PDO $db, int $userId, string $field, string $value)
  {
    if ($field === 'priority') {
      switch ($value) {
        case 'critical':
          $value = '1-' . $value;
          break;
        case 'high':
          $value = '2-' . $value;
          break;
        case 'medium':
          $value = '3-' . $value;
          break;
        case 'low':
          $value = '4-' . $value;
          break;
      }
    }

    $stmt = $db->prepare("UPDATE Ticket SET $field = ? WHERE id = ?");
    $stmt->execute(array($value, $this->ticketId));

    if ($field === 'priority') {
      $value = substr($value, 2);
    }

    if (!Change::fieldChangeExists($db, $this->{$field}, $value)) {
      Change::addFieldChange($db, $this->{$field}, $value);
    }

    $change = Change::getChangeId($db, $this->{$field}, $value);

    $this->addHistory($db, $userId, $field . " changed", $change);
  }

  function addMessage(PDO $db, int $userId, string $text)
  {
    $stmt = $db->prepare('INSERT INTO Message (user, ticket, text, date) VALUES (?,?, ?, CURRENT_TIMESTAMP)');
    $stmt->execute(array($userId, $this->ticketId, $text));
  }

  function getLastMessage(PDO $db)
  {
    $lastInsertedId = $db->lastInsertId();
    $stmt = $db->prepare('SELECT * FROM Message WHERE id = ?');
    $stmt->execute(array($lastInsertedId));
    $lastMessage = $stmt->fetch();
    $message = array(
      'user' => User::getUser($db, intval($lastMessage['user'])),
      'text' => htmlentities($lastMessage['text']),
      'date' => $lastMessage['date'],
    );
    return $message;
  }

  function addHistory(PDO $db, int $userId, string $changes, int $field)
  {
    $stmt = $db->prepare('INSERT INTO TicketHistory(ticketId, user, date, changes, field) VALUES (?, ?, CURRENT_TIMESTAMP, ?, ?)');
    $stmt->execute(array($this->ticketId, $userId, $changes, $field));
  }

  static function getStats(PDO $db): array
  {
    $stats = array();
    $total_tickets_query = $db->query("SELECT COUNT(*) AS total_tickets FROM Ticket");
    $total_tickets = $total_tickets_query->fetch()['total_tickets'];

    $stats['total_tickets'] = $total_tickets;
    $tickets_created_today_query = $db->query("SELECT COUNT(*) AS tickets_created_today FROM Ticket WHERE date(createDate) = date('now')");
    $tickets_created_today = $tickets_created_today_query->fetch()['tickets_created_today'];

    $stats['tickets_created_today'] = $tickets_created_today;
    $tickets_created_this_week_query = $db->query("SELECT COUNT(*) AS tickets_created_this_week FROM Ticket WHERE strftime('%Y-%W', createDate) = strftime('%Y-%W', 'now')");
    $tickets_created_this_week = $tickets_created_this_week_query->fetch()['tickets_created_this_week'];

    $stats['tickets_created_this_week'] = $tickets_created_this_week;
    $tickets_created_this_month_query = $db->query("SELECT COUNT(*) AS tickets_created_this_month FROM Ticket WHERE strftime('%Y-%m', createDate) = strftime('%Y-%m', 'now')");
    $tickets_created_this_month = $tickets_created_this_month_query->fetch()['tickets_created_this_month'];

    $stats['tickets_created_this_month'] = $tickets_created_this_month;

    return $stats;
  }

  static function getTicketCounts($db): array
  {

    $stmt = $db->prepare('SELECT DATE(createDate) AS creation_date, COUNT(*) AS ticket_count FROM Ticket GROUP BY creation_date');
    $stmt->execute();

    $ticketCounts = array();

    while ($ticketCount = $stmt->fetch()) {
      $ticketCounts[] = array($ticketCount['creation_date'], $ticketCount['ticket_count']);
    }
    return $ticketCounts;

  }

  static function getFieldStats($db, $field): array
  {
    $stmt = $db->prepare("SELECT $field, COUNT(*) as count FROM Ticket GROUP BY $field");
    $stmt->execute();

    $stats = array();
    while ($row = $stmt->fetch()) {
      $stats[] = array($row[$field], $row['count']);
    }
    return $stats;
  }

  function updateFeedback(PDO $db, int $value)
  {
    $stmt = $db->prepare('UPDATE Ticket SET feedback = ? WHERE id = ?');
    $stmt->execute(array($value, $this->ticketId));
  }

  function answerWithFAQ(PDO $db, int $userId, int $faqId)
  {
    $faq = FAQ::getFAQ($db, $faqId);
    $this->addMessage($db, $userId, $faq->answer);
  }

  function changeTags(PDO $db, int $userId, string $new_tags)
  {
    $tags = explode(',', $new_tags);

    /* Remove tags that are no longer present */
    $tagsToRemove = array_diff($this->tags, $tags);
    foreach ($tagsToRemove as $tagToRemove) {
      $stmt = $db->prepare('DELETE FROM TicketTag WHERE ticket = ? AND tag = ?');
      $stmt->execute(array($this->ticketId, $tagToRemove));

    }
    $removedTags = implode(", ", $tagsToRemove);

    if (!empty($removedTags)) {
      $this->addHistory($db, $userId, "Removed tags: " . $removedTags, 0);
    }

    /* Add new tags that are not already present */
    $newTags = array_diff($tags, $this->tags);
    foreach ($newTags as $newTag) {
      if ($newTag !== '') {
        $stmt = $db->prepare("INSERT INTO TicketTag (ticket, tag) VALUES (?, ?)");
        $stmt->execute(array($this->ticketId, $newTag));
      }
    }
    $addedTags = implode(", ", $newTags);
    if (!empty($newTags)) {
      $this->addHistory($db, $userId, "Added tags: " . $addedTags, 0);
    }

  }
}
?>