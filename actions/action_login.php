<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/user.class.php');
  require_once(__DIR__ . '/../utils/validation.php');

  $db = getDatabaseConnection();

  if (!valid_token($_POST['csrf']) || !valid_email($_POST['email']) || !valid_password($_POST["password"])){
    die(header("Location: ../pages/login.php"));
}

  $user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);
  
  if ($user) {
    $session->setId($user->userId);
    $session->setName($user->username);
    $session->setRole($user->type);
    $session->setPhoto($user->getPhoto());
    $session->addMessage('success', 'Login successful!');
    header('Location: ../pages/index.php');
  } 
  else {
    $session->addMessage('error', 'Please try again!');
    die(header('Location: ../pages/login.php'));  
  }

?>