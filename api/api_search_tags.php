<?php 
 

 require_once(__DIR__ . '/../classes/session.class.php');
 $session = new Session();

 require_once(__DIR__ . '/../database/connection.db.php');
 require_once(__DIR__ . '/../templates/createticket.tpl.php');

 $db = getDatabaseConnection();
 $query = $db->query("SELECT * FROM Hashtag");

 $query = array(); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_assoc()){ 
        $query[] = $row; 
    } 
} 
 echo json_encode($tags_get); 

?>