<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/ticket.class.php');
  require_once(__DIR__ . '/../utils/validation.php');

  $db = getDatabaseConnection();

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $ticket = Ticket::getTicket($db, intval($_GET['ticketId']));
    $ticket->answerWithFAQ($db, $session->getId(), intval($_GET['faqId']));
    
    $response = $ticket->getLastMessage($db);
  }

  else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $fileName = "../files/ticket" . intval($_POST['id']) . "_" . $_FILES['fileToUpload']['name'];
    $uploadedFilePath = $_FILES['fileToUpload']['tmp_name'];
    
    if (move_uploaded_file($uploadedFilePath, $fileName))
      $response = ['file' => $_FILES['fileToUpload']['name']];
    else
      $response = ['file' => 'error'];
  }

  else if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

    $requestBody = file_get_contents('php://input');
    parse_str($requestBody, $requestData);

    $ticketId = intval($requestData['ticketId']);
    $agentId = intval($requestData['agentId']);
    $value = intval($requestData['value']);

    $ticket = Ticket::getTicket($db, $ticketId);
    $agent = User::getUser($db, $agentId);

    if ($agent) {
      $agent->updateReputation($db, $agent->reputation + $value);
      $ticket->updateFeedback($db, $value);
      $response = ['status' => 'success'];
    } 
    else {
      $response = ['status' => 'error'];
    }
  }

  else if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    
    $requestBody = file_get_contents('php://input');
    parse_str($requestBody, $requestData);
  
    $ticketId = intval($requestData['id']);
    $message = $requestData['text'];

    $ticket = Ticket::getTicket($db, $ticketId);
    $ticket->addMessage($db, $session->getId(), $message);

    $response = $ticket->getLastMessage($db);
  }

  echo json_encode($response);

?>