<?php
  declare(strict_types=1);

  require_once(__DIR__ . '/../../classes/session.class.php');
  require_once(__DIR__ . '/../../utils/validation.php');
  $session = new Session();

  if (!valid_token($_POST['csrf'])){
    die(header("Location: ../../pages/index.php"));
  }

  if ($_FILES['fileToUpload']['tmp_name'][0] == "") {
    $session->addMessage('warning', 'Choose a valid file first!');
    die(header("Location: ../../pages/ticket.php?id=" . $_POST['id']));
  }

  $fileName = "../../files/ticket" . $_POST['id'] . "_" . $_FILES['fileToUpload']['name']; 
  move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $fileName);

  header("Location: ../../pages/ticket.php?id=" . $_POST['id']);
?>