<?php
  declare(strict_types = 1);
  
  require_once(__DIR__ . '/../../classes/session.class.php');

  $session = new Session();

  if (!$session->isLoggedIn()) {
    die(header('Location: ../../pages/index.php'));
  }

  require_once(__DIR__ . '/../../database/connection.db.php');
  require_once(__DIR__ . '/../../classes/faq.class.php');
  require_once(__DIR__ . '/../../utils/validation.php');

  $db = getDatabaseConnection();

  if (!valid_token($_POST['csrf']) || !valid_new_faq($db, $_POST['problem'])) {
    die(header('Location: ../../pages/index.php'));
  }

  $problem = htmlentities($_POST['problem']);
  $answer = htmlentities($_POST['answer']);

  try {
    FAQ::addFAQ($db, $problem, $answer);
  } 
  catch (PDOException $e) {
    $session->addMessage('error', 'Failed to create faq');
  }

  header('Location: ../../pages/faq.php');
?>