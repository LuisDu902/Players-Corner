<?php
declare(strict_types=1);

require_once(__DIR__ . '/../../classes/session.class.php');
$session = new Session();

require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../classes/department.class.php');
require_once(__DIR__ . '/../../utils/validation.php');


$db = getDatabaseConnection();

if (!valid_token($_POST['csrf'])) {
  die(header('Location: ../../pages/index.php'));
}

try {
  Department::removeDepartment($db, htmlentities($_POST['category']));
} catch (PDOException $e) {
  $session->addMessage('error', 'Failed to remove department');
}

header('Location: ../../pages/index.php');
?>