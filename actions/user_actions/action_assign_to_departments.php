<?php
declare(strict_types=1);

require_once(__DIR__ . '/../../classes/session.class.php');
$session = new Session();

require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../classes/department.class.php');
require_once(__DIR__ . '/../../classes/user.class.php');
require_once(__DIR__ . '/../../utils/validation.php');

if (!valid_token($_POST['csrf'])){
  die(header('Location: ../../pages/users.php'));
}

$db = getDatabaseConnection();

$user = User::getUser($db, intval($_POST["userId"]));

$selected_departments = explode(',', $_POST["selected_departments"]);
$selected_departments = array_map('trim', $selected_departments);
foreach ($selected_departments as $department){
    $user->assignToDepartment($db, $department);
}

header('Location: ../../pages/users.php');
?>