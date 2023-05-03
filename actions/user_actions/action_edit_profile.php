<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../../database/connection.db.php');
  require_once(__DIR__ . '/../../classes/user.class.php');
  require_once(__DIR__ . '/../../utils/validation.php'); 

  if (!valid_token($_POST['csrf']) || !valid_name($_POST['name']) || !valid_email($_POST['email']) || !valid_username($_POST['username']) || !valid_password($_POST["old-password"]) || !valid_password($_POST["new-password"])){
    die(header("Location: ../../pages/edit_profile.php"));
  }

  $db = getDatabaseConnection();

  $user = User::getUser($db, $session->getId());

  if (!password_verify($_POST["old-password"], $user->password)){
    $session->addMessage('error', 'Current password doesn\'t match!');
    die(header("Location: ../../pages/edit_profile.php"));
  }

  else if ($user) {
    $user->editProfile($db, $_POST['name'], $_POST['username'], $_POST['email'], $_POST['new-password']);
    $session->setName($user->username);
  }

  header('Location: ../../pages/edit_profile.php');
?>