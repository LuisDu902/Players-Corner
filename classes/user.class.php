<?php

class User
{
  public int $userId;
  public string $name;
  public string $username;
  public string $email;
  public string $password;
  public string $reputation;
  public string $type;

  public function __construct(int $userId, string $name, string $username, string $email, string $password, string $reputation, string $type)
  {
    $this->userId = $userId;
    $this->name = $name;
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
    $this->reputation = $reputation;
    $this->type = $type;
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
        $user['userId'],
        $user['name'],
        $user['username'],
        $user['email'],
        $user['password'],
        $user['reputation'],
        $user['type'],
      );
    } else
      return null;
  }


  static function searchUsers(PDO $db, string $search, string $filter, string $order): array
  {
    
    if ($filter == "users") {
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
        $user['reputation'],
        $user['type'],
      );
    }

    return $users;
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

  function upgradeUser(PDO $db, string $type, int $id)
  {
    $stmt = $db->prepare('
       UPDATE User SET type = ?
       WHERE userId = ?
      ');

    $stmt->execute(array($type, $id));

  }

  function updateReputation(PDO $db, string $reputation, int $id)
  {
    $stmt = $db->prepare('
        UPDATE User SET reputation = ?
        WHERE userId = ?
       ');

    $stmt->execute(array($reputation, $id));

  }

  function getPhoto(): string
  {

    $default = "../images/profile/default.png";
    $attemp = "../images/profile/profile" . $this->userId . ".png";
    if (file_exists($attemp)) {
      return $attemp;
    } else
      return $default;
  }

  
}
?>