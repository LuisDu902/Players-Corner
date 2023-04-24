<?php

class Admin extends User {
   
    static function searchUsers(PDO $db, string $search = '', string $filter = 'users', string $order = 'name'): array
    {
      
      if ($filter === "users") {
        $query = 'SELECT userId, name, username, email, password, reputation, type FROM User WHERE name LIKE ? ORDER BY ' . $order;
        $stmt = $db->prepare($query);
        $stmt->execute(array($search . '%'));
  
      } else {
        $query = 'SELECT userId, name, username, email, password, reputation, type FROM User WHERE name LIKE ? and type = ? ORDER BY ' . $order;
        $stmt = $db->prepare($query);
        $stmt->execute(array($search . '%', $filter));
      }
     
      $users = array();
      while ($user = $stmt->fetch()) {
        $users[] = new User(
          intval($user['userId']),
          $user['name'],
          $user['username'],
          $user['email'],
          $user['password'],
          intval($user['reputation']),
          $user['type'],
        );
      }
  
      return $users;
    }

    static function upgradeUser(PDO $db, string $role, int $id)
    {
      $stmt = $db->prepare('
         UPDATE User SET type = ?
         WHERE userId = ?
        ');
  
      $stmt->execute(array($role, $id));
  
    }

}

?>