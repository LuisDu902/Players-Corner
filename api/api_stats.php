<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/department.class.php');
  $db = getDatabaseConnection();

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    /* Department stats */
    if (isset($_GET['department'])) {
      $department = Department::getDepartment($db, $_GET['department']);
      $stats = $department->getStats($db, $_GET['field']);
    }
    /* User stats */
    else if (isset($_GET['userId'])){
      $user = User::getUser($db, intval($_GET['userId']));
      $stats = $user->getTicketStats($db);
    }

    /* All ticket stats */
    else {
      if ($_GET['field'] === 'date')
        $stats = Ticket::getTicketCounts($db);
      else
        $stats = Ticket::getFieldStats($db, $_GET['field']);
    }
    echo json_encode($stats);
  }
?>