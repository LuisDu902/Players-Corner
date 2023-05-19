<?php
declare(strict_types=1);

require_once(__DIR__ . '/../../classes/session.class.php');
$session = new Session();

require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../classes/user.class.php');
require_once(__DIR__ . '/../../utils/validation.php');

$db = getDatabaseConnection();

if (!valid_token($_POST['csrf'])) {
    die(header("Location: ../../pages/users.php"));
}
try {
    User::upgradeUser($db, htmlentities($_POST['role']), intval($_POST['userId']));
} catch (PDOException $e) {
    $session->addMessage('error', 'Failed to upgrade user');
}
$session->addMessage('success', 'User role updated');
header("Location: ../../pages/users.php");
?>