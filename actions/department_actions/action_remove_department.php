<?php
  declare(strict_types=1);

  require_once(__DIR__ . '/../../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../../database/connection.db.php');
  require_once(__DIR__ . '/../../classes/department.class.php');
  require_once(__DIR__ . '/../../utils/validation.php');


  $db = getDatabaseConnection();

  if (!valid_token($_POST['csrf'])){
    die(header('Location: ../../pages/index.php'));
  }

  Department::removeDepartment($db, $_POST['category']);

  header('Location: ../../pages/index.php');
?>