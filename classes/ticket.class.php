#List all changes done to a ticket (e.g., status changes, assignments, edits).
#Manage the FAQ and use an answer from the FAQ to answer a ticket.

<?php
  class Ticket {
    public int $ticketId;
    public string $tag;
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

    public function __construct(string $ticketId,string $title,string $text,string $date,string $visibility,string $priority,string $status,string $category,string $tag,string $creator)
    {
      $this->ticketId = $ticketId;
      $this->tag = $tag;
      $this->title = $title;
      $this->text = $text;
      $this->priority = $priority;
      $this->status = $status;
      $this->date= $date;
      $this->visibility=$visibility;
      $this->creator=$creator;
      $this->replier='';
      $this->frequentItem=0;
      $this->category=$category;
    }
    public function _construct(string $ticketId,string $title,string $text,string $date,string $visibility,string $priority,string $status,string $category,string $tag,string $frequentItem,string $creator,string $replier)
    {
      $this->ticketId = $ticketId;
      $this->tag = $tag;
      $this->title = $title;
      $this->text = $text;
      $this->priority = $priority;
      $this->status = $status;
      $this->date= $date;
      $this->visibility=$visibility;
      $this->creator=$creator;
      $this->replier=$replier;
      $this->frequentItem=$frequentItem;
      $this->category=$category;
    }


    function getTicketId() {
      return $this->ticketId;
    }

    function updateTicketStatus(PDO $db, string $ticketId, string $status) {
      $stmt = $db->prepare('
        UPDATE Ticket SET status = ?
        WHERE id = ?
      ');

      $stmt->execute(array($ticketId, $status));
    }
    
    static function updateReplier(PDO $db, string $ticketId, string $replier) : ?User {
      $stmt = $db->prepare('
        UPDATE TIcket SET replier=? , status =?
        WHERE id=?
      ');

      $stmt->execute(array($replier,'assigned',$ticketId));
  
    }

  
    static function registerTicket(int $ticketId, string $tag, string $title, string $text, string $priority,string $category, string $status, string $date, string $visibility, string $creator){
        $stmt = $db->prepare('INSERT INTO Ticket (id, title, text, createDate, visibility, priority, status, category, tag, frequentItem,creator,replier) VALUES (?,?,?,?,?, ?, ?, ?, ?,0,?,"")');
        $stmt->execute(array($ticketId,$title,$text,$date,$visibility,$priority,$status,$category,$tag,$creator));
      }


    static function getTicket(PDO $db, int $ticketId) : Ticket {
      $stmt = $db->prepare('
        SELECT id, title, text, createDate, visibility, priority, status, category, tag, frequentItem,creator,replier
        FROM Ticket 
        WHERE id = ?
      ');

      $stmt->execute(array($id));
      $ticket = $stmt->fetch();
      
      return new Ticket(
          $ticket['id'],
          $ticket['title'],
          $ticket['createDate'],
          $ticket['visibility'],
          $ticket['priority'],
          $ticket['status'],
          $ticket['category'],
          $ticket['tag'],
          $ticket['frequentItem'],
          $ticket['creator'],
          $ticket['replier'],
        );
    }

    function assignTicket(PDO $db, int $ticketId,string $replier) {
       $stmt = $db->prepare('
       UPDATE Ticket SET replier = ?
       WHERE id = ?
      ');

      $stmt->execute(array($replier,$ticketId));
    
    }

    function updateFrequentItem(PDO $db, int $ticketId,string $frequentItem) {
        $stmt = $db->prepare('
        UPDATE Ticket SET frequentItem = ?
        WHERE id = ?
       ');
 
       $stmt->execute(array($frequentItem+1, $ticketId));
     
     }
    function updateDepartement(PDO $db,int $ticketId, string $category){
      $stmt = $db->prepare('
        UPDATE Ticket SET category=?
        WHERE id=?
      ');
      $stmt->execute(array($category,$ticketId));
    }

  }
?>