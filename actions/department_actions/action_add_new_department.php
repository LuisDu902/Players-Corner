<?php
declare(strict_types=1);

require_once(__DIR__ . '/../../classes/session.class.php');
$session = new Session();

require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../classes/department.class.php');
require_once(__DIR__ . '/../../utils/validation.php');


if (!valid_token($_POST['csrf'])){
  die(header('Location: ../pages/departments.php'));
}

$db = getDatabaseConnection();
if ($_FILES['departmentImage']['tmp_name'][0] == "") {
    Department::addDepartment($db, $_POST['new_category']);
    die(header("Location: ../../pages/departments.php"));
} else {
    $department_name = strtolower(str_replace(" ", "_", $_POST['new_category']));
    $fileName = "../../images/departments/" . $department_name . ".png";
    move_uploaded_file($_FILES['departmentImage']['tmp_name'], $fileName);
    Department::addDepartment($db, $_POST['new_category']);
}
header('Location: ../../pages/departments.php');
?>