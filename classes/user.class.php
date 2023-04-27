<?php

class User
{
  public int $userId;
  public string $name;
  public string $username;
  public string $email;
  public string $password;
  public int $reputation;
  public string $type;

  public bool $hasPhoto;

  public function __construct(int $userId, string $name, string $username, string $email, string $password, int $reputation, string $type)
  {
    $this->userId = $userId;
    $this->name = $name;
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
    $this->reputation = $reputation;
    $this->type = $type;
    $this->hasPhoto = $this->getPhoto() != '../images/users/default.png';
  }

  function editProfile(PDO $db)
  {
    $stmt = $db->prepare('
        UPDATE User SET name = ?, username = ?, email = ?, password = ?
        WHERE userId = ?
      ');

    $stmt->execute(array($this->name, $this->username, $this->email, $this->password, $this->userId));
  }

  static function getUserWithPassword(PDO $db, string $email, string $password): ?User
  {
    $stmt = $db->prepare('
        SELECT userId, name, username, email, password, reputation, type
        FROM user 
        WHERE lower(email) = ? AND password = ?
      ');

    $stmt->execute(array(strtolower($email), ($password)));

    if ($user = $stmt->fetch()) {
      return new User(
        intval($user['userId']),
        $user['name'],
        $user['username'],
        $user['email'],
        $user['password'],
        intval($user['reputation']),
        $user['type'],
        
      );
    } else
      return null;
  }

  static function registerUser(PDO $db, string $name, string $username, string $email, string $password)
  {
    $stmt = $db->prepare('INSERT INTO User (userId, name, username, email, password, reputation, type) VALUES (NULL, ?, ?, ?, ?,0,"client")');
    $stmt->execute(array($name, $username, $email, $password));
  }

  static function validEmail(PDO $db, string $email)
  {
    $stmt = $db->prepare('
        SELECT userId, name, username, email, password, reputation, type
        FROM User 
        WHERE email = ?
      ');

    $stmt->execute(array($email));
    if ($stmt->fetch())
      return false;
    return true;
  }
  static function getUser(PDO $db, int $id): User
  {
    $stmt = $db->prepare('
        SELECT userId, name, username, email, password, reputation, type
        FROM User 
        WHERE userId = ?
      ');

    $stmt->execute(array($id));
    $user = $stmt->fetch();

    return new User(
      intval($user['userId']),
      $user['name'],
      $user['username'],
      $user['email'],
      $user['password'],
      $user['reputation'],
      $user['type'],
    );
  }

  function updateReputation(PDO $db, int $reputation)
  {
    $stmt = $db->prepare('
        UPDATE User SET reputation = ?
        WHERE userId = ?
       ');

    $stmt->execute(array($reputation, $this->userId));
  }

 
  function getPhoto(): string
  {
    $default = "../images/users/default.png";
    $attemp = "../images/users/user" . $this->userId . ".png";
    if (file_exists($attemp)) {
      return $attemp;
    } else
      return $default;
  }

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