<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/faq.class.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/faq.tpl.php');

  $db = getDatabaseConnection();

  $faqs = FAQ::getFAQs($db);

  drawHeader($session);
  drawFAQList($faqs, $session);
  drawFooter();
?>