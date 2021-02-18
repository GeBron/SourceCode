<?php
require_once(dirname(__FILE__) . '/configuration.php');
require_once(dirname(__FILE__) . '/transaction.php');
require_once(dirname(__FILE__) . '/contact.php');

class AddContactController {
    private $added = false;

    function __construct($request) {
        if (@$request['add']) {
            if (@$request['name'] && @$request['email']) {
                try {
                    $this->saveContact($request['name'],
                                       $request['email']);
                } catch (Exception $e) {
                }
                $this->added = true;
            }
        }
    }

    private function saveContact($name, $email) {
        $configuration = new Configuration();
        $transaction = new MysqlTransaction(
                $configuration->getDbHost(),
                $configuration->getDbUsername(),
                $configuration->getDbPassword(),
                $configuration->getDb());
        $contact = new Contact($name, $email);
        $contact->save($transaction);
        $transaction->commit();
    }

    function added() {
        return $this->added;
    }
}
?>