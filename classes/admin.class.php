<?php

class Admin extends User
{

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

  static function upgradeUser(PDO $db, string $role, int $userId)
  {
    $stmt = $db->prepare('
         UPDATE User SET type = ?
         WHERE userId = ?
        ');

    $stmt->execute(array($role, $userId));

  }

  static function getAssignableDepartments(PDO $db, int $userId): array
  {
    $stmt = $db->prepare('
      SELECT DISTINCT category 
      FROM Department
      WHERE category NOT IN( 
        SELECT department
        FROM AgentDepartment
        WHERE agent = ?)
     ');

    $stmt->execute(array($userId));

    $departments = array();
    while ($department = $stmt->fetch()) {
      $departments[] = new Department(
        $department['category'],
      );
    }
    return $departments;
  }

  static function assignToDepartment(PDO $db, int $agent, string $department)
  {
    $stmt = $db->prepare('INSERT INTO AgentDepartment VALUES (?, ?)');

    $stmt->execute(array($agent, $department));
  }

}

?>