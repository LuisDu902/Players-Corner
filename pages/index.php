<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/department.class.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/department.tpl.php');
  require_once(__DIR__ . '/../templates/initial.php');

  $db = getDatabaseConnection();

  $departments = Department::getDepartments($db);

  drawHeader($session);
  drawInitial($session, $departments);
  drawFooter();
?>