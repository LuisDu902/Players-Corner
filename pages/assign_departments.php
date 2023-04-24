<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../classes/session.class.php');
    require_once(__DIR__ . '/../classes/user.class.php');
    require_once(__DIR__ . '/../classes/department.class.php');
    require_once(__DIR__ . '/../classes/admin.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
 
    $session = new Session();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/department.php');
  
    require_once(__DIR__ . '/../templates/user.tpl.php');
    
    $db = getDatabaseConnection();

    $departments = Admin::getAssignableDepartments($db, intval($_POST['userId']));

    drawHeader($session);
    drawAssignableDepartments($departments, $_POST['userId']);
    drawFooter();
?>
