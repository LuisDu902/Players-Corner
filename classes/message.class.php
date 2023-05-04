<?php
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

}

?>