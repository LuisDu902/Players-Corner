<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/user.class.php');

  $db = getDatabaseConnection();
  
  if (User::validEmail($db, $_POST['email'])) {
    User::registerUser($db, $_POST['name'], $_POST['username'], $_POST['email'],$_POST['password']);
    $user = User::getUser($db, 9999);
    $session->setId($user->userId);
    $session->setName($user->username);
    $session->addMessage('sucess', 'Registration sucessful!');
    header('Location: ../pages/index.php');
   
  } else {
    $session->addMessage('error', 'email already taken!');
    die(header('Location: ../pages/register.php'));
  }

?>