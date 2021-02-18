<?php
ini_set('include_path',ini_get('include_path').':..');
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';
require_once 'Zend/Filter.php';
require_once 'Request.php';
error_reporting(E_ALL);
Mock::generate('RawRequest');
Mock::generate('CleanRequest');



class RawRequestTestHelper extends RawRequest {
    public function getFrom($request,$var) {
        return  $request->getForValidation($var);
    }
}

class RawRequestTest extends UnitTestCase {
    function setUp() {
        $_GET = array();
        $_POST = array();
        $this->request = $this->createRequest();
        $this->helper = new RawRequestTestHelper;
    }

    function createRequest() {
        return new RawRequest;
    }

    function testCanCreateRawRequest() {
        $this->assertIsA($this->createRequest(),'RawRequest');
    }

    function testSuperglobalsAreUnset() {
        $_POST['one'] = 1;
        $_GET['two'] = 2;
        $raw = new RawRequest;
        $this->assertFalse(isset($_POST));
        $this->assertFalse(isset($_GET));
    }

    function testInitFromArray() {
        $request = new RawRequest(array('one' => 1));
        $this->assertEqual(1,$request->getForValidation('one'));
    }

    function testGet() {
        $_GET['qwert'] = 42;
        $request = $this->createRequest();
        $this->assertEqual(42,
            $this->helper->getFrom($request,'qwert')
        );
    }
    function testPost() {
        $_POST['qwert'] = 42;
        $request = $this->createRequest();
        $this->assertEqual(42,
            $this->helper->getFrom($request,'qwert')
        );
    }
    function testPostOverridesGet() {
        $_GET['qwert'] = 1;
        $_POST['qwert'] = 42;
        $request = $this->createRequest();
        $this->assertEqual(42,
            $this->helper->getFrom($request,'qwert')
        );
    }


//    function testGetForValidation
}

class RequestTest extends UnitTestCase {
    function setUp() {
        $_GET = array();
        $_POST = array();
        $this->request = $this->createRequest();
    }

    function createRequest() {
        return new CleanRequest;
    }

    function testSet() {
        $request = $this->request->set('hello',42);
        $this->assertEqual(42,$request->get('hello'));
    }
    
    function testSetWorksOnCloneOnly() {
        $request = $this->request->set('hello',42);
        $this->assertFalse($this->request->get('hello'));
    }

    function testDelete() {
        $request = $this->createRequest()->set('qwert',42);
        $request->delete('qwert');
        $this->assertFalse($request->get('qwert'));
    }

    function testIsSetFailure() {
        $this->assertFalse($this->request->has('nonexistent'));
    }

    function testIsSetSuccess() {
        $request = $this->createRequest()->set('qwert',42);
        $this->assertTrue($request->has('qwert'));
    }

    function testEmptyQueryString() {
        $this->assertEqual('',$this->request->toQueryString());
    }

    function _testQueryString() {
        $this->request->set('cmd','newspage');
        $this->request->set('id','5');
        $this->assertEqual('?cmd=newspage&id=5',$this->request->toQueryString());
    }
}


class RequestTests extends GroupTest {
    function RequestTests() {
        $this->GroupTest("RequestTests");
        $this->AddTestCase(new RequestTest());
        $this->AddTestCase(new RawRequestTest());
    }
}

if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    $test = new RequestTests();
    $test->run(new TextReporter);
}
