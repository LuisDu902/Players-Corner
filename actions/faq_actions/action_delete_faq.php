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

  if (!valid_token($_POST['csrf'])) {
    die(header('Location: ../../pages/index.php'));
  }

  $faqId = intval($_POST['id']);

  try {
    FAQ::removeFAQItem($db, $faqId);
  } 
  catch (PDOException $e) {
    $session->addMessage('error', 'Failed to remove faq');
  }

  header('Location: ../../pages/faq.php');
?>