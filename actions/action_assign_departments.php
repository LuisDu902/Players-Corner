<?php
declare(strict_types=1);

require_once(__DIR__ . '/../classes/session.class.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../classes/department.class.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../classes/admin.class.php');

$db = getDatabaseConnection();

$selected_departments = explode(',', $_POST["selected_departments"]);
$selected_departments = array_map('trim', $selected_departments);
foreach ($selected_departments as $department){
    Admin::assignToDepartment($db, intval($_POST["userId"]), $department);
}

header('Location: ../pages/departments.php');
?>