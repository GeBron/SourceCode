<?php
ini_set('include_path',ini_get('include_path').':..');
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';
require_once 'ValidationFacade.php';
require_once 'Validator.php';
require_once 'Request.php';
error_reporting(E_ALL);

Mock::generate('RawRequest');
Mock::generate('CleanRequest');
Mock::generate('Validator','MockValidator');
Mock::generate('ValidationCoordinator','MockCoordinator');


class ValidatorTest extends UnitTestCase {
    function setUp() {
        $this->coordinator = new MockCoordinator($this);
        $this->validator = new AlnumFieldValidator('one','message');
        $this->coordinator->expectOnce('get',array('one'));
    }

    function testSetsCleanOnSuccess() {
        $this->coordinator->setReturnValue('get','bubbles2');
        $this->coordinator->expectOnce('setClean',array('one'));
        $this->validator->validate($this->coordinator);
        $this->coordinator->tally();
    }
    function testDoesNotSetCleanOnFailure() {
        $this->coordinator->setReturnValue('get','/bubbles2');
        $this->coordinator->expectNever('setClean');
        $this->validator->validate($this->coordinator);
        $this->coordinator->tally();
    }
    function testAddsErrorOnFailure() {
        $this->coordinator->setReturnValue('get','/bubbles2');
        $this->coordinator->expectOnce(
            'addError',
            array('message')
        );
        $this->validator->validate($this->coordinator);
        $this->coordinator->tally();
    }
    function testDoesNotAddErrorOnSuccess() {
        $this->coordinator->setReturnValue('get','bubbles2');
        $this->coordinator->expectNever('addError');
        $this->validator->validate($this->coordinator);
        $this->coordinator->tally();
    }


}

class ValidationTest extends UnitTestCase {
    function setUp() {
        $this->validator = new ValidationFacade;
    }

    function validate() {
        $this->validator->addAlnumValidation('one','message');
        $this->validator->validate(new RawRequest);
        return $this->validator->getCleanRequest();
    }

    function testValidationSuccess() {
        $_POST['one'] = 'bubbles';
        $clean = $this->validate();
        $this->assertEqual('bubbles',$clean->get('one'));
    }
}

class AddValidationTest extends UnitTestCase {
    function setUp() {
        $this->facade = new ValidationFacade;
        $this->alnumvalidator =
        new BasicValidator(
            new SingleFieldSpecification(
                'one',
                new AlnumValueSpecification
            ),
            'message'
        );
    }

    function testStandardAddAlnum() {
        $this->facade->addAlnumValidation('one','message');
        $this->assertEqual(
            array($this->alnumvalidator),
            $this->facade->getValidators()
        );
    }
    function testFluentAddAlnum() {
        $this->facade->addAlnumValidation('one')->withMessage('message');
        $this->assertEqual(
            array($this->alnumvalidator),
            $this->facade->getValidators()
        );
    }
    function testMoreFluentAddAlnum() {
        $this->facade
            ->addAlnumValidation()
            ->forField('one')
            ->withMessage('message');
        $this->assertEqual(
            array($this->alnumvalidator),
            $this->facade->getValidators()
        );
    }
    function testReverseOrderAddAlnum() {
        $this->facade
            ->addAlnumValidation()
            ->withMessage('message')
            ->forField('one');
        $this->assertEqual(
            array($this->alnumvalidator),
            $this->facade->getValidators()
        );
    }
}

class FacadeTest extends UnitTestCase {
    function setUp() {
        $this->facade = new PartialMockValidationFacade;
        $this->raw = new MockRawRequest;
        $this->validator1 = new MockValidator($this);
        $this->validator2 = new MockValidator($this);
        $this->facade->addValidator($this->validator1);
        $this->facade->addValidator($this->validator2);
        $this->coordinator = new MockCoordinator($this);
        $this->coordinator->setReturnValue(
            'getCleanRequest',
            new CleanRequest);
        $this->facade->setReturnValue(
            'createCoordinator',$this->coordinator);
    }

    function createRequest() {
        return new CleanRequest;
    }

    function testIsNotValidBeforeValidation() {
        $this->assertFalse($this->facade->isValid());
    }

    function testGetCleanDoesNotCrashBeforeValidation() {
        $this->assertFalse($this->facade->getCleanRequest());
    }

    function testValidateCreatesCoordinator() {
        $this->facade->expectOnce(
            'createCoordinator',
            array($this->raw,$this->createRequest())
        );
        $this->facade->validate($this->raw);
        $this->facade->tally();
    }

    function testValidateCallsValidators() {
        $this->validator1->expectOnce(
            'validate',
            array($this->coordinator));
        $this->validator2->expectOnce(
            'validate',
            array($this->coordinator));
        $this->facade->validate($this->raw);
        $this->validator1->tally();
        $this->validator2->tally();
    }

    function testValidateReturnsCleanRequest() {
        $this->facade->validate($this->raw);
        $this->assertEqual(
            new CleanRequest,
            $this->facade->getCleanRequest());
    }

    function testValidationReturnsTrueOnSuccess() {
        $this->coordinator->setReturnValue(
            'getErrors',
            array());
        $this->assertTrue($this->facade->validate($this->raw));
    }

    function testValidationReturnsFalseOnFailure() {
        $this->coordinator->setReturnValue(
            'getErrors',
            array('error'));
        $this->assertFalse($this->facade->validate($this->raw));
    }

    function testRealFacadeCreatesCoordinator() {
        $facade = new ValidationFacade;
        $this->assertEqual(
            new ValidationCoordinator(
                $this->raw,
                new CleanRequest
            ),
            $facade->createCoordinator(
                $this->raw,
                new CleanRequest
            )
        );
    }
}

class CoordinatorTest extends UnitTestCase {
    function setUp() {
        $this->raw = new MockRawRequest;
        $this->clean = new CleanRequest;
        $this->errors = '';
        $this->coordinator = new ValidationCoordinator(
            $this->raw,
            $this->clean,
            $this->errors
        );
    }

    function testSetsValueInClean() {
        $this->raw->setReturnValue('getForValidation',5);
        $this->coordinator->setClean('five');
        $this->assertEqual(5,
            $this->coordinator->getCleanRequest()->get('five')
        );
    }

    function testGetsFromRaw() {
        $this->raw->setReturnValue('getForValidation',2);
        $this->assertEqual(2,$this->coordinator->get('two'));
        $this->raw->tally();
    }
}


class ValidatorTests extends GroupTest {
    function ValidatorTests() {
        $this->GroupTest("ValidatorTests");
        $this->AddTestCase(new CoordinatorTest());
//        $this->AddTestCase(new FacadeTest());
        $this->AddTestCase(new ValidationTest());
        $this->AddTestCase(new AddValidationTest());
       $this->AddTestCase(new ValidatorTest());
    }
}

if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
$test = new ValidatorTests();
$test->run(new TextReporter());
}
