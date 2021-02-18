<?php
// You will have to have a SimpleTest symlink or path entry for this to work.
// In addition, the Zend framework's Zend/Mail package must be available to
// the mailer_class.php file. Fakemail is bundled, but you will need the
// CPAN module Net::Server::Mail::SMTP.
//
require_once('simpletest/unit_tester.php');
require_once('simpletest/mock_objects.php');
require_once('simpletest/reporter.php');

class AllTests extends TestSuite {
    function __construct() {
        parent::__construct('All tests');
        $this->addTestFile('contact_test.php');
        $this->addTestFile('mailer_test.php');
    }
}
$test = new AllTests();
$test->run(new HtmlReporter());
?>