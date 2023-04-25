<?php
class Message
{
    public int $messageId;
    public string $text;
    public string $date;
    public int $userId;
    public int $ticketId;

    public function __construct( int $messageId, string $text, string $date, int $userId, int $ticketId)
    {
        $this->$messageId = $messageId;
        $this->date = $date;
        $this->text = $text;
        $this->userId = $userId;
        $this->ticketId = $ticketId;
    }

    
}