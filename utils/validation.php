<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../classes/session.class.php');

    function valid_token(String $token) : bool {
        if ($_SESSION['csrf'] !== $token){
            $session = new Session();
            $session->addMessage('error', 'Request does not appear to be legitimate!');
            unset($_SESSION['csrf']);
            return false;
        }
        unset($_SESSION['csrf']);
        return true;
    }

    function valid_name(String $name) : bool {
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            $session = new Session();
            $session->addMessage('error','Name can only contain letter and spaces!');
            return false;
        }
        return true;
    }

    function valid_new_username(PDO $db, string $username): bool{
        $stmt = $db->prepare('
            SELECT userId, name, username, email, password, reputation, type
            FROM User 
            WHERE username = ?
        ');

        $stmt->execute(array($username));
        if ($stmt->fetch()){
            $session = new Session();
            $session->addMessage('error', 'Username already in use. Please choose a different one!');
            return false;
        }
        return true;
    }

    function valid_username(string $username): bool {
        if (!preg_match("/^[a-zA-Z\d]+$/", $username)) {
            $session = new Session();
            $session->addMessage('error', 'Username can only contain letters and numbers!');
            return false;
        }
        return true;
    }
    

    function valid_email(String $email) : bool {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == null){
            $session = new Session();
            $session->addMessage('error','Invalid email address format!');
            return false;
        }
        return true;
    }

    function valid_new_email(PDO $db, String $email) : bool {
        $stmt = $db->prepare('
            SELECT userId, name, username, email, password, reputation, type
            FROM User 
            WHERE email = ?
        ');

        $stmt->execute(array($email));
        if ($stmt->fetch()){
            $session = new Session();
            $session->addMessage('error', 'Email already in use. Please try a different one!');
            return false;
        }
        return true;
    }
    function valid_password(string $password): bool {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $special = preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
    
        if (!$uppercase || !$lowercase || !$number || !$special || strlen($password) < 10) {
            $session = new Session();
            $session->addMessage('error', 'The password must be at least 10 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
            return false; 
        }
        return true;
    }

?>