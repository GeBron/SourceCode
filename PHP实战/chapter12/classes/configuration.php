<?php
class Configuration {
    private $all;
    private $host;

    function __construct() {
        $this->all = parse_ini_file(
                dirname(__FILE__) . '/../configuration',
                true);
        $this->host = trim(`hostname`);
    }

    function getHome() {
        return $this->all[$this->host]['home'];
    }

    function getDbHost() {
        return $this->all[$this->host]['db_host'];
    }

    function getDbUsername() {
        return $this->all[$this->host]['db_username'];
    }

    function getDbPassword() {
        return $this->all[$this->host]['db_password'];
    }

    function getDb() {
        return $this->all[$this->host]['db'];
    }
}
?>