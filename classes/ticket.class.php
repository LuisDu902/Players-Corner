<?php
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
    public string $creator;
    public string $replier;
    public int $frequentItem;

    public function __construct(int $ticketId, string $title, string $text, string $date, string $visibility, string $priority, string $status, string $category, array $tags, int $frequentItem, string $creator, string $replier)
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
        $this->frequentItem = $frequentItem;
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
        UPDATE TIcket SET replier=? , status="assigned"
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
        SELECT id, title, text, createDate, visibility, priority, status, category, tag, frequentItem,creator,replier
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
            $ticket['tags'],
            $ticket['frequentItem'],
            $ticket['creator'],
            $ticket['replier'],
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

    static function getUserTickets(PDO $db, int $userId) : array{

        $stmt = $db->prepare(
            'SELECT id, title, text, createDate, visibility, priority, status, category, frequentItem, creator, replier
             FROM Ticket 
             WHERE creator = ?');
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
          array(),
          $ticket['frequentItem'],
          $ticket['creator'],
          $ticket['replier'],
        );
      }
      return $tickets;
    }

}
?>