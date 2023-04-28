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