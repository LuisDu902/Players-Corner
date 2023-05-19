<?php
  declare(strict_types = 1);

  class FAQ {
    public int $id;
    public string $problem;
    public string $answer;
    
    public function __construct(int $id, string $problem, string $answer)
    {
        $this->id = $id;
        $this->problem = $problem;
        $this->answer = $answer;
    }

    
    static function getFAQs(PDO $db, int $count, int $page) {
      $stmt = $db->prepare('SELECT FAQ.id, FAQ.title, content FROM FAQ ORDER BY 1 LIMIT ? OFFSET ?');

      $stmt->execute(array($count, $page * $count));
  
      $faqs = array();
      while($faq = $stmt->fetch()){
          $faqs[] = new FAQ(
              intval($faq['id']),
              $faq['title'],
              $faq['content']
          );
      }

      return $faqs;
    }

    static function getFAQ(PDO $db, int $id) : FAQ {
      $stmt = $db->prepare('
        SELECT FAQ.id, FAQ.title, content
        FROM FAQ
        WHERE FAQ.id = ?
      ');

      $stmt->execute(array($id));
      $faq = $stmt->fetch();
      
      return new FAQ(
        $faq['id'],
        $faq['title'],
        $faq['content']
      );
    }
    static function addFaq(PDO $db, string $problem, string $answer)
  {
      $stmt = $db->prepare('INSERT INTO FAQ (title, content) VALUES (?, ?)');
      $stmt->execute([$problem, $answer]);
  }

  }
?>