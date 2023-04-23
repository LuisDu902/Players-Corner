<?php

class Department
{
  public string $category;
 
  public function __construct(string $category)
  {
    $this->category = $category;
  }

  function getMembers(PDO $db): array
  {
    $stmt = $db->prepare('
        SELECT userId, name, username, email, password, reputation, type
        FROM User JOIN AgentDepartment ON User.userId = AgentDepartment.agent
        WHERE AgentDepartment.department = ?
      ');

    $stmt->execute(array($this->category));
    
    $members = array();
    while ($member = $stmt->fetch()) {
      $members[] = new User(
        intval($member['userId']),
        $member['name'],
        $member['username'],
        $member['email'],
        $member['password'],
        intval($member['reputation']),
        $member['type'],
      );
    }

    return $members;
  }

  static function getDepartments(PDO $db): array
  {
    $stmt = $db->prepare('SELECT category FROM Department');
    $stmt->execute();
   
    $departments = array();
    while ($department = $stmt->fetch()) {
      $departments[] = new Department(
        $department['category']
      );
    }

    return $departments;
  }

}
?>