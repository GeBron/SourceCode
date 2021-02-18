<?php
// Must have a SimpleTest symlink or path entry for this to work.
// Otherwise you will have to edit these paths.
// You will also need a user called "me" with a password of
// "secret" or else you will have to edit each test. In the real world
// there would be an application specific wrapper/factory for injecting
// these parameters.
//
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');
require_once('../classes/transaction.php');

class TestOfMysqlTransaction extends UnitTestCase {

    function createSchema() {
        $transaction = new MysqlTransaction(
                'localhost', 'me', 'secret', 'test');
        $transaction->execute('drop table if exists numbers');
        $transaction->execute(
                'create table numbers (n integer) type=InnoDB');
        $transaction->commit();
    }

    function dropSchema() {
        $transaction = new MysqlTransaction(
                'localhost', 'me', 'secret', 'test');
        $transaction->execute('drop table if exists numbers');
        $transaction->commit();
    }

    function testCanReadSimpleSelect() {
        $transaction = new MysqlTransaction(
                'localhost', 'me', 'secret', 'test');
        $result = $transaction->select('select 1 as one');
        $row = $result->next();
        $this->assertEqual($row['one'], '1');
    }

    function testShouldThrowExceptionOnBadSelectSyntax() {
        $transaction = new MysqlTransaction(
                'localhost', 'me', 'secret', 'test');
        try {
            $transaction->select('invalid SQL');
            $this->fail('Should have thrown');
        } catch (Exception $e) { }
    }

    function testCanWriteRowAndReadItBack() {
        $this->createSchema();
        $transaction = new MysqlTransaction(
                'localhost', 'me', 'secret', 'test');
        $transaction->execute('insert into numbers (n) values (1)');
        $result = $transaction->select('select * from numbers');
        $row = $result->next();
        $this->assertEqual($row['n'], '1');
        $this->dropSchema();
    }

    function setUpRow() {
        $this->createSchema();
        $transaction = new MysqlTransaction(
                'localhost', 'me', 'secret', 'test');
        $transaction->execute('insert into numbers (n) values (1)');
        $transaction->commit();
    }

    function testRowConflictBlowsOutTransaction() {
        $this->setUpRow();
        $one = new MysqlTransaction(
                'localhost', 'me', 'secret', 'test');
        $one->execute('update numbers set n = 2 where n = 1');
        $two = new MysqlTransaction(
                'localhost', 'me', 'secret', 'test');
        try {
            $two->execute('update numbers set n = 3 where n = 1');
            $this->fail('Should have thrown');
        } catch (Exception $e) { }
        $this->dropSchema();
    }
}
$test = new TestOfMysqlTransaction();
$test->run(new HtmlReporter());
?>