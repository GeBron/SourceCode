<?php
require_once(dirname(__FILE__) . '/mailer.php');

class Contact {
    private $name;
    private $email;

    function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }

    function getEmail() {
        return $this->email;
    }

    function getName() {
        return $this->name;
    }

    function send($message, $mailer) {
        $mailer->send($this->getEmail(),
                "Hi {$this->name},\n\n$message");
    }

    function save($transaction) {
        $transaction->execute(
                "insert into contacts (name, email) " .
                "values ('" . $this->name . "', '" .
                $this->email . "')");
    }
}

class ContactFinder {
    function findByName($transaction, $name) {
        $result = $transaction->select(
                "select * from contacts where name='$name'");
        $row = $result->next();
        return new Contact($row['name'], $row['email']);
    }

    function findAll($transaction) {
        return new ContactResultSet();
    }
}

class ContactResultSet {
    private $contacts;

    function __construct() {
        $this->contacts = array(new Contact('Me', 'me@myself.com'));
    }

    function next() {
        return array_shift($this->contacts);
    }
}
?>