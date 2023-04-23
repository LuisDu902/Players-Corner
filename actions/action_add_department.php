<?php
declare(strict_types=1);

require_once(__DIR__ . '/../classes/session.class.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../classes/department.class.php');

$db = getDatabaseConnection();

Department::addDepartment($db, $_POST['new_category']);

header('Location: ../pages/departments.php');
?>