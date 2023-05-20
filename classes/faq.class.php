<?php
  declare(strict_types = 1);

  class FAQ {
    public int $id;
    public string $problem;
    public string $answer;
    
    public function __construct(int $id, string $problem, string $answer) {
      $this->id = $id;
      $this->problem = $problem;
      $this->answer = $answer;
    }

    static function getFAQs(PDO $db) {
      $stmt = $db->prepare('SELECT FAQ.id, FAQ.title, content FROM FAQ ORDER BY 1');
      $stmt->execute();
  
      $faqs = array();
      while($faq = $stmt->fetch()){
        $faqs[] = new FAQ(
          intval($faq['id']),
          htmlentities($faq['title']),
          htmlentities($faq['content'])
        );
      }

      return $faqs;
    }

    static function getFAQ(PDO $db, int $id) : FAQ {
      $stmt = $db->prepare('SELECT FAQ.id, FAQ.title, content FROM FAQ WHERE FAQ.id = ?');
      $stmt->execute(array($id));
      $faq = $stmt->fetch();
      
      return new FAQ(
        $faq['id'],
        htmlentities($faq['title']),
        htmlentities($faq['content'])
      );
    }
    static function addFaq(PDO $db, string $problem, string $answer) {
      $stmt = $db->prepare('INSERT INTO FAQ (title, content) VALUES (?, ?)');
      $stmt->execute([$problem, $answer]);
    }

    static function searchFAQs(PDO $db, string $search) {
      $stmt = $db->prepare('SELECT * FROM FAQ WHERE title LIKE ? ');
      $stmt->execute(array($search . '%'));
  
      $faqs = array();
      while($faq = $stmt->fetch()){
        $faqs[] = new FAQ(
          intval($faq['id']),
          htmlentities($faq['title']),
          htmlentities($faq['content'])
        );
      }

      return $faqs;
    }

    static function removeFAQItem(PDO $db, int $id): void {
      $stmt = $db->prepare('DELETE FROM FAQ WHERE id = ?');
      $stmt->execute([$id]);
    }
  }
?>