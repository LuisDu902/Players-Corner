<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../../classes/session.class.php');
    $session = new Session();

    require_once(__DIR__ . '/../../database/connection.db.php');
    require_once(__DIR__ . '/../../classes/user.class.php');
    require_once(__DIR__ . '/../../utils/validation.php');

    $db = getDatabaseConnection();

    if (!valid_token($_POST['csrf']) || !valid_name($_POST['name']) || !valid_email($_POST['email']) || !valid_username($_POST['username']) || !valid_new_email($db, $_POST['email']) || !valid_new_username($db, $_POST['username']) || !valid_password($_POST["password"])){
        die(header("Location: ../../pages/register.php"));
    }

    User::registerUser($db, $_POST['name'], $_POST['username'], $_POST['email'], $_POST['password']);
    $user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);
    $session->setId($user->userId);
    $session->setName($user->username);
    $session->setRole($user->type);
    $session->setPhoto($user->getPhoto());
    
    $session->addMessage('success', 'Registration successful!');
    header('Location: ../../pages/index.php');

?>  