<?php
declare(strict_type=1);

require_once(__DIR__ . '/../classes/session.class.php');
$session = new Session();

require_once(__DIR__ . '/../classes/ticket.class.php');
require_once(__DIR__ . '/../classes/department.class.php');
require_once(__DIR__ . '/../classes/user.class.php');
require_once(__DIR__ . '/../database/connection.db.php');

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/department.tpl.php');
require_once(__DIR__ . '/../templates/user.tpl.php');
require_once(__DIR__ . '/../templates/ticket.tpl.php');

$db = getDatabaseConnection();

$department = Department::getDepartment($db, $_GET['category']);


$hasAccess = false;

    foreach ($department->members as $member) {
        if ($session->getId() == $member->userId || $session->getRole() === 'admin') {
            $hasAccess = true;
            break;
        }
    }


drawHeader($session);
drawDepartment($hasAccess, $department);
drawFooter();
?>