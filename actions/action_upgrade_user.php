<?php
declare(strict_types=1);

require_once(__DIR__ . '/../classes/session.class.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../classes/user.class.php');

$db = getDatabaseConnection();

User::upgradeUser($db,$_POST['role'],intval($_POST['userId']));

$session->addMessage('success', 'User role updated');
header("Location: ../pages/users.php");
?>