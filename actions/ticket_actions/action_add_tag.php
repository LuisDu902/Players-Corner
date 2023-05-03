<?php
declare(strict_types=1);

require_once(__DIR__ . '/../../classes/session.class.php');
$session = new Session();

require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../classes/department.class.php');
require_once(__DIR__ . '/../../classes/user.class.php');
require_once(__DIR__ . '/../../utils/validation.php');

if (!valid_token($_POST['csrf'])){
  die(header('Location: ../../pages/ticket.php'));
}

$db = getDatabaseConnection();
$ticket = Ticket::getTicket($db, $_POST['id']);
$ticket->addTag($db, $_POST['tag']);

$session->addMessage('success', 'Ticket tag removed!');
header("Location: ../../pages/tickets.php");

?>