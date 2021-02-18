<?php
set_include_path(get_include_path() . PATH_SEPARATOR .
        dirname(__FILE__) . '/../');
require_once('Zend/Mail.php');
require_once('Zend/Mail/Transport/Smtp.php');

class Mailer {
    private $transport;

    function __construct($host, $port) {
        $this->transport = new Zend_Mail_Transport_Smtp($host, $port);
    }

    function send($address, $message) {
        $mail = new Zend_Mail();
        $mail->setFrom('me@localhost', 'Me');
        $mail->addTo($address);
        $mail->setBodyText($message);
        @$mail->send($this->transport);
    }
}
?>