<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../classes/session.class.php');
    $session = new Session();

    //require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/authentication.php');
    //require_once(__DIR__ . '/../templates/initial.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../actions/departments.php');
    require_once(__DIR__ . '/../templates/forum.tpl.php');
    $db = getDatabaseConnection();
    //drawHeader($session);
    $departments=getDepartments($db);
    drawDepartments($departments);
    //drawFooter();
?>