<?php
  declare(strict_type = 1);

  require_once(__DIR__ . '/../classes/session.class.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../classes/user.class.php');
  require_once(__DIR__ . '/../classes/ticket.class.php');
  require_once(__DIR__ . '/../classes/department.class.php');
  $db = getDatabaseConnection();

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    switch ($_GET['type']){
      case 'users':
        $response = User::searchUsers($db, $_GET['search'], $_GET['role'], $_GET['order']);
        break;
      case 'tickets':
        $response = Ticket::searchTickets($db, $session->getId(), $_GET['search'], $_GET['filter'], $_GET['order']);
        break;
      case 'departments': 
        $response = User::getAssignableDepartments($db, $_GET['userId']);
        break;
      case 'faqs': 
        $response = FAQ::searchFAQs($db, $_GET['search']);
        break;
      case 'tags':
        $stmt = $db->prepare('SELECT tag FROM TicketTag GROUP BY tag');
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_COLUMN);
        break;
      case 'members':
        $department = Department::getDepartment($db, $_GET['category']);
        $response = $department->members;
        break;
    }
    echo json_encode($response);    
  }
?>