<?php
declare(strict_types=1);

require_once(__DIR__ . '/../classes/session.class.php');
require_once(__DIR__ . '/../utils/validation.php');
$session = new Session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fileName = "../files/ticket" . intval($_POST['id']) . "_" . $_FILES['fileToUpload']['name'];
  $uploadedFilePath = $_FILES['fileToUpload']['tmp_name'];
  if (move_uploaded_file($uploadedFilePath, $fileName)) {
    $message = ['file' => $_FILES['fileToUpload']['name']];
  } else {
    $message = ['file' => 'error'];
  }
  echo json_encode($message);
}
?>