<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../classes/session.class.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/authentication.tpl.php');
    require_once(__DIR__ . '/../templates/initial.php');
    drawHeader($session);
    drawInitial($session);
    drawFooter();
?>