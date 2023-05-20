<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/department.class.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/reports.tpl.php');

  $db = getDatabaseConnection();

  $stats = Ticket::getStats($db);

  drawHeader($session);
  drawStats($stats);
  drawFooter();
?>