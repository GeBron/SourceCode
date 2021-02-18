<?php
require_once(dirname(__FILE__) . '/../classes/mailer.php');

class TestOfMailer extends UnitTestCase {
    private $pid;

    function setUp() {
        $command = '../fakemail/fakemail ' .
                '--host=localhost --port=10025 ' .
                '--path=../../temp --background';
        $this->pid = `$command`;
        @unlink('../../temp/me@me.com.1');
    }

    function tearDown() {
        $command = 'kill ' . $this->pid;
        `$command`;
        @unlink('../../temp/me@me.com.1');
    }

    function testMailIsSent() {
        $mailer = new Mailer('localhost', 10025);
        $mailer->send('me@me.com', 'Hello');
        $this->assertMailText('me@me.com', 'Hello');
    }

    function assertMailText($address, $expected) {
        if (! file_exists("../../temp/$address.1")) {
            $this->fail("No mail for $address");
            return;
        }
        $content = file_get_contents("../../temp/$address.1");
        $this->assertNotIdentical(
                strstr($content, $expected),
                false,
                "Cannot find $expected in $address");
    }
}
?>