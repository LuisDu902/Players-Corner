<?php
class Message
{
    public int $messageId;
    public string $text;
    public string $date;
    public User $user;
    public int $ticketId;

    public function __construct( int $messageId, string $text, string $date, User $user, int $ticketId)
    {
        $this->$messageId = $messageId;
        $this->date = $date;
        $this->text = $text;
        $this->user = $user;
        $this->ticketId = $ticketId;
    }

    
}