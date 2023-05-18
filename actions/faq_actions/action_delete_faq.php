<?php
declare(strict_types=1);

require_once(__DIR__ . '/../../classes/session.class.php');

$session = new Session();

require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../classes/faq.class.php');
require_once(__DIR__ . '/../../utils/validation.php');

$db = getDatabaseConnection();

if (!valid_token($_POST['csrf'])){
    die(header('Location: ../../pages/index.php'));
}

$faqId = (int)$_POST['id'];

FAQ::removeFAQItem($db, $faqId);

header('Location: ../../pages/faq.php');
?>
