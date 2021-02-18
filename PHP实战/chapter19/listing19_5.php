<?php
class ServiceLocator {
    private static $soleInstance;
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }
    public static function load($locator) {
        self::$soleInstance = $locator;
    }
    public static function databaseconnection() {
        return self::$soleInstance->connection;
    }
}
