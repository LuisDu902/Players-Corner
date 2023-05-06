<?php
    declare(strict_type = 1);

    require_once(__DIR__ . '/../classes/session.class.php');
    $session = new Session();

    require_once(__DIR__ . '/../classes/ticket.class.php');
    require_once(__DIR__ . '/../classes/department.class.php');
    require_once(__DIR__ . '/../classes/user.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/department.tpl.php');
    require_once(__DIR__ . '/../templates/user.tpl.php');

    $db = getDatabaseConnection();

    $department = Department::getDepartment($db, $_GET['category']);
    $members = $department->getMembers($db);
    $tickets = $department->getTickets($db);
    drawHeader($session);
    drawDepartment($department, $tickets, $members);
    drawFooter();
?>