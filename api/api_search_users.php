<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/user.class.php');
  require_once(__DIR__ . '/../classes/admin.class.php');

  $db = getDatabaseConnection();

  $users = Admin::searchUsers($db, $_GET['search'], $_GET['role'], $_GET['order']);

  echo json_encode($users);

?>