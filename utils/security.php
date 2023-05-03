<?php
    declare(strict_types = 1);
    require_once(__DIR__ . '/../classes/session.class.php');

    function generate_random_token(){
        return bin2hex(openssl_random_pseudo_bytes(32));
    }

    function valid_token(String $attemp) : bool {
        if ($_SESSION['csrf'] !== $attemp){
            $session = new Session();
            $session->addMessage('error', 'Request does not appear to be legitimate!');
            return false;
        }
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

    function valid_email(String $email) : bool {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == null){
            $session = new Session();
            $session->addMessage('error','Invalid email address format!');
            return false;
        }
        return true;
    }

   
    function valid_text(String $attemp) : bool {
        if (!preg_match ("/^[a-zA-Z\s]+$/", $attemp)) {
            $session = new Session();
            $session->addMessage('warning', "Formato de texto inválido");
            return false;
        }
        return true;
    }

    function valid_state(String $attemp) : bool {
        if (!preg_match ("/^[a-zA-Z\s]+$/", $attemp)) {
            $session = new Session();
            $session->addMessage('warning', "Formato de texto inválido");
            return false;
        }
        return true;
    }

    function valid_stars(String $attemp) : bool {
        if (!preg_match ('/[1-5]/', $attemp)) {
            $session = new Session();
            $session->addMessage('warning', "Número de estrelas inválido");
            return false;
        }
        return true;
    }

    function valid_password(String $attemp) : bool {

        $uppercase = preg_match('@[A-Z]@', $attemp);
        $lowercase = preg_match('@[a-z]@', $attemp);
        $number = preg_match('@[0-9]@', $attemp);

        if (!$uppercase || !$lowercase || !$number || strlen(($_POST['password2'])) < 8) {
            $session = new Session();
            $session->addMessage('warning', "A nova palavra passe deve conter pelo menos 8 caracteres, ter uma letra maiúscula, uma letra minúscula e um número");
            return false; 
        }
        return true;
    }

    function valid_CSRF(String $attemp) : bool {
        if ($_SESSION['csrf'] !== $attemp) {
            $session = new Session();
            $session->addMessage('error', "Operação inválida");
            return false;
        }
        return true;
    }

    function filter_text(String $text) : String {
        return preg_replace ("/[^a-zA-Z0-9\s]/", '', $text);
    }
?>