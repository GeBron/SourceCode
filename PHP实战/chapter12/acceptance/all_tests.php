<?php
require_once('simpletest/web_tester.php');
require_once('simpletest/reporter.php');

class AllAcceptanceTests extends GroupTest {
    function __construct() {
        parent::__construct('All acceptance tests');
        $this->addTestFile('adding_contact_test.php');
    }
}
$test = new AllAcceptanceTests();
$test->run(new HtmlReporter());
?>