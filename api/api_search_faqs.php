<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/faq.class.php');

  $db = getDatabaseConnection();

  $faqs = FAQ::searchFAQs($db, $_GET['search']);

  echo json_encode($faqs);

?>