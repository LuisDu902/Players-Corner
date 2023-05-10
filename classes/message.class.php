<?php
  declare(strict_types = 1);
  require_once( __DIR__ . '/user.class.php');
  require_once( __DIR__ . '/ticket.class.php');

class Message
{
    public int $messageId;
    public User $user;
    public Ticket $ticket;
    public string $text;
    public string $date;
   

    public function __construct(int $messageId, User $user, Ticket $ticket, string $text, string $date)
    {
        $this->messageId = $messageId;
        $this->user = $user;
        $this->ticket = $ticket;
        $this->date = $date;
        $this->text = $text;
    }

}

class Change
{
    public int $id;
    public Ticket $ticket;
    public User $user;
    public string $date;
    public string $changes;
    public string $old_field;
    public string $new_field;
 
    public function __construct(int $id, User $user, Ticket $ticket, string $date, string $changes, string $old_field, string $new_field)
    {
        $this->id = $id;
        $this->user = $user;
        $this->ticket = $ticket;
        $this->date = $date;
        $this->changes = $changes;
        $this->old_field = $old_field;
        $this->new_field = $new_field;
    }

    static function addFieldChange(PDO $db, String $old_field, String $new_field){
        $stmt = $db->prepare('INSERT INTO FieldChange(id, old_field, new_field) VALUES (NULL, ?, ?)');
        $stmt->execute(array($old_field, $new_field));
      }

    static function fieldChangeExists(PDO $db, String $old_field, String $new_field) : bool{
        $stmt = $db->prepare('SELECT * FROM FieldChange WHERE old_field = ? AND new_field = ?');
        $stmt->execute(array($old_field, $new_field));
        return (bool) $stmt->fetch();
    }

    static function getChangeId(PDO $db, String $old_field, String $new_field) : int{
        $stmt = $db->prepare('SELECT id FROM FieldChange WHERE old_field = ? AND new_field = ?');
        $stmt->execute(array($old_field, $new_field));
        $change =  $stmt->fetchColumn();
        return $change;
      }

}

?>