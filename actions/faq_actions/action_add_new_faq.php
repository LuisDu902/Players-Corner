<?php
declare(strict_types=1);

require_once(__DIR__ . '/../../classes/session.class.php');

$session = new Session();

require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../classes/faq.class.php');
require_once(__DIR__ . '/../../utils/validation.php');

$db = getDatabaseConnection();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    if (!valid_token($_POST['csrf']) || !valid_new_faq($db, $_POST['problem'])) {
        die(header('Location: ../../pages/index.php'));
    }

    // Retrieve form data
    $problem = htmlentities($_POST['problem']);
    $answer = htmlentities($_POST['answer']);

    // Add the FAQ to the database
    try {
        FAQ::addFAQ($db, $problem, $answer);
    } catch (PDOException $e) {
        $session->addMessage('error', 'Failed to create faq');
    }
    // Redirect to the desired page
    header('Location: ../../pages/faq.php');
}
?>