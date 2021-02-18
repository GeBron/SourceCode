<?php
require_once('../classes/contact.php');
require_once('../classes/transaction.php');

class TestOfContactPersistence extends UnitTestCase {

    function setUp() {
        $this->dropSchema();
        $this->createSchema();
    }

    function tearDown() {
        $this->dropSchema();
    }

    function createSchema() {
        $transaction = new MysqlTransaction(
                'localhost', 'me', 'secret', 'test');
        $transaction->execute(file_get_contents(
                '../database/create_schema.sql'));
        $transaction->commit();
    }

    function dropSchema() {
        $transaction = new MysqlTransaction(
                'localhost', 'me', 'secret', 'test');
        $transaction->execute(file_get_contents(
                '../database/drop_schema.sql'));
        $transaction->commit();
    }

    function testContactCanBeFoundAgain() {
        $contact = new Contact('Me', 'me@me.com');
        $transaction = new MysqlTransaction(
                'localhost', 'me', 'secret', 'test');
        $contact->save($transaction);

        $finder = new ContactFinder();
        $contact = $finder->findByName($transaction, 'Me');
        $this->assertEqual($contact->getEmail(), 'me@me.com');
    }
}

Mock::generate('Mailer');

class TestOfContactMail extends UnitTestCase {

    function testMailWasSent() {
        $mailer = new MockMailer();
        $mailer->expectOnce('send', array(
                'me@me.com', "Hi Me,\n\nHello"));
        $contact = new Contact('Me', 'me@me.com');
        $contact->send('Hello', $mailer);
    }
}
?>