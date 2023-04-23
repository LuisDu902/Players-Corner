<?php

  function getDepartments($db) {
    $stmt = $db->prepare('SELECT * FROM Department');
    $stmt->execute();
    return $stmt->fetchAll();
  }
  function getTags($db){
    $stmt = $db->prepare('SELECT * FROM Hashtag');
    $stmt->execute();
    return $stmt->fetchAll();
  }
?>