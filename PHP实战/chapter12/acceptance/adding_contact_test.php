<?php
require_once(dirname(__FILE__) . '/../classes/configuration.php');
require_once(dirname(__FILE__) . '/../classes/transaction.php');

class TestOfAddingContacts extends WebTestCase {
    protected $configuration;

    function __construct() {
        parent::__construct();
        $this->configuration = new configuration();
    }

    function setUp() {
        $this->dropSchema();
        $this->createSchema();
    }

    function tearDown() {
        $this->dropSchema();
    }

    function testNewContactShouldBeVisible() {
        $this->get($this->configuration->getHome());
        $this->click('Add contact');
        $this->setField('Name:', 'Me');
        $this->setField('E-mail:', 'me@myself.com');
        $this->click('Add');
        $this->assertText('Me');
        $this->assertText('me@myself.com');
    }

    function createSchema() {
        $this->sqlScript('create_schema.sql');
    }

    function dropSchema() {
        $this->sqlScript('drop_schema.sql');
    }

    function sqlScript($script) {
        $transaction = new MysqlTransaction(
                $this->configuration->getDbHost(),
                $this->configuration->getDbUsername(),
                $this->configuration->getDbPassword(),
                $this->configuration->getDb());
        $transaction->execute(file_get_contents(
                "../database/$script"));
        $transaction->commit();
    }
}
?>