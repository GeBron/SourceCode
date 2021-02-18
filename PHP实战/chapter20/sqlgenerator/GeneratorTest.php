<?php
require_once 'SqlGenerator.php';
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
error_reporting(E_ALL);

abstract class DomainObject {
    abstract public function getID();
}

// This is just to be able to test: $object instanceof 'Topic'
class Topic extends DomainObject {
    public function getID() {}
}

class StubTopic extends Topic {
    public function getID() { return 1; }
    public function getName() { return 'Trains'; }
}
class ThisBaseTest extends UnitTestCase {
    const INSERT = "INSERT INTO Topics (id,name) VALUES (1,'Trains')";
    const UPDATE = "UPDATE Topics SET id = 1, name = 'Trains' WHERE id = 1";
    const DELETE = "DELETE FROM Topics WHERE id = 1";
    protected function assertInsert($sql) {
        $this->assertEqual($sql,self::INSERT);
    }
    protected function assertUpdate($sql) {
        $this->assertEqual($sql,self::UPDATE);
    }
    protected function assertDelete($sql) {
        $this->assertEqual($sql,self::DELETE);
    }
}

class AutoTest extends ThisBaseTest {

    function testInsert() {
        $sql = AutoSqlGenerator::makeInsertStatement(new StubTopic);
        $this->assertInsert($sql);
    }
    function testDelete() {
        $sql = AutoSqlGenerator::makeDeleteStatement(new StubTopic);
        $this->assertDelete($sql);
    }
    function testUpdate() {
        $sql = AutoSqlGenerator::makeUpdateStatement(new StubTopic);
        $this->assertUpdate($sql);
    }
}

class ObjectTest extends ThisBaseTest {

    function testObjectDelete() {
        $generator = new ObjectSqlGenerator(new TopicConverter);
        $sql = $generator->makeDeleteStatement(new StubTopic);
        $this->assertDelete($sql);
    }
    function testObjectInsert() {
        $generator = new ObjectSqlGenerator(new TopicConverter);
        $sql = $generator->makeInsertStatement(new StubTopic);
        $this->assertInsert($sql);
    }
    function testObjectUpdate() {
        $generator = new ObjectSqlGenerator(new TopicConverter);
        $sql = $generator->makeUpdateStatement(new StubTopic);
        $this->assertUpdate($sql);
    }
}

class QuotingTest extends ThisBaseTest {

    function testQuotingInsert() {
        $rowData = array('id' => 1, 'name' => "Trains");
        $sql = QuotingSqlGenerator::makeInsertStatement('Topics',$rowData);
        $this->assertInsert($sql);
    }
    function testQuotingUpdate() {
        $rowData = array('id' => 1, 'name' => "Trains");
        $sql = QuotingSqlGenerator::makeUpdateStatement('Topics',$rowData);
        $this->assertUpdate($sql);
    }
}

class BasicTest extends ThisBaseTest {
    function testStupid() {
        $values = array(1,'Trains');
        $valuestring = 'VALUES ('.join(',',$values).')';
        $this->assertEqual('VALUES (1,Trains)',$valuestring);
    }

    function testInsert() {
        $topic = new StubTopic;
        $rowData = array(
            'id' => $topic->getID(), 
            'name' => "'".$topic->getName()."'"
            );
        $sql = SqlGenerator::makeInsertStatement('Topics',$rowData);
        $this->assertInsert($sql);
    }

    function testUpdate() {
        $rowData = array('id' => 1, 'name' => "'Trains'");
        $sql = SqlGenerator::makeUpdateStatement('Topics',$rowData);
        $this->assertUpdate($sql);
    }

}

class GenerateTests extends GroupTest {
    function GenerateTests() {
        $this->GroupTest("GenerateTests");
        $this->AddTestCase(new AutoTest());
        $this->AddTestCase(new ObjectTest());
        $this->AddTestCase(new BasicTest());
        $this->AddTestCase(new QuotingTest());
    }
}

$test = new GenerateTests();
$test->run(new TextReporter());
