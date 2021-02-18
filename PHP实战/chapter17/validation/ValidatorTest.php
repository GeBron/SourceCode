<?php
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';
require_once 'Validator.php';
require_once 'ValidationFacade.php';
error_reporting(E_ALL);

Mock::generate('ValidationCoordinator','MockCoordinator');
Mock::generate('ValueSpecification');
Mock::generate('SingleFieldSpecification');

class ValidatorIntegrationTest extends UnitTestCase {
    public function setUp() {
        $this->coord = new MockCoordinator($this);
        $this->validator = new BasicValidator(
            new SingleFieldSpecification(
                'one',
                new AlnumValueSpecification
            ),
            'message'
        );
    }

    public function testAlnumValueSetsClean() {
        $this->coord->expectOnce('setClean',array('one'));
        $this->coord->setReturnValue('get','bubbles2',array('one'));
        $this->validator->validate($this->coord);
        $this->coord->tally();
    }
}

class EqualFieldsTest extends UnitTestCase {
    public function setUp() {
        $this->specification = new EqualFieldsSpecification('one','two');
        $this->coord = new MockCoordinator($this);
        $this->validator = new BasicValidator(
            $this->specification,
            'message'
        );
    }

    public function testSpecSucceedsIfEqual() {
        // This will return all equal values:
        $this->coord->setReturnValue('get','1');
        $this->assertTrue(
            $this->specification->isSatisfiedBy(
                $this->coord
            )
        );
    }

    public function testSpecFailsIfUnequal() {
        $this->coord->setReturnValue('get','1',array('one'));
        $this->coord->setReturnValue('get','2',array('two'));
        $this->assertFalse(
            $this->specification->isSatisfiedBy(
                $this->coord
            )
        );
    }

    public function testValidationSucceedsIfEqual() {
        $this->coord->setReturnValue('get','1');
        $this->coord->expectNever('addError');
        $this->coord->expectOnce('setClean',array(FALSE));
        $this->validator->validate($this->coord);
        $this->coord->tally();
    }
    public function testValidationFailsIfUnequal() {
        $this->coord->setReturnValue('get','1',array('one'));
        $this->coord->setReturnValue('get','2',array('two'));
        $this->coord->expectOnce(
            'addError',
            array(new ValidationError('message'))
        );
        $this->coord->expectNever('setClean');
        $this->validator->validate($this->coord);
        $this->coord->tally();
    }

    public function _testSucceedsIfEqual() {
        $this->coord->expectNever('addError');
    }
}

class  ValidatorTest extends UnitTestCase {

    function setUp() {
        $this->spec = new MockSingleFieldSpecification($this);
        $this->spec->setReturnValue('getValidatedField','one');
        $this->validator = new BasicValidator(
            $this->spec,
            'message'
        );
        $this->coord = new MockCoordinator($this);
        $this->error = new ValidationError('message');
    }

    function testValidatorChecksWithSpecification() {
        $this->spec->expectOnce('isSatisfiedBy',array($this->coord));
        $this->validator->validate($this->coord);
        $this->spec->tally();
    }

    function testDoesNotSetCleanOnFailure() {
        $this->coord->expectNever('setClean');
        $this->spec->setReturnValue('isSatisfiedBy',FALSE);
        $this->validator->validate($this->coord);
        $this->coord->tally();
    }
    function testSetsCleanOnSuccess() {
        $this->coord->expectOnce('setClean',array('one'));
        $this->spec->setReturnValue('isSatisfiedBy',TRUE);
        $this->validator->validate($this->coord);
        $this->coord->tally();
    }
    function testSetsErrorOnFailure() {
        $this->coord->expectOnce('addError',array($this->error));
        $this->spec->setReturnValue('isSatisfiedBy',FALSE);
        $this->validator->validate($this->coord);
        $this->coord->tally();
    }
    function testDoesNotSetErrorOnSuccess() {
        $this->coord->expectNever('addError');
        $this->spec->setReturnValue('isSatisfiedBy',TRUE);
        $this->validator->validate($this->coord);
        $this->coord->tally();
    }
}

class ValueSpecificationTest extends UnitTestCase {
    function setUp() {
        $this->spec = new AlnumValueSpecification;
    }

    function testAlphanumericSpecificationIsSatisfied() {
        $this->assertTrue($this->spec->isSatisfiedBy('bubbles2'));
    }

    function testAlphanumericSpecificationIsNotSatisfied() {
        $this->assertFalse($this->spec->isSatisfiedBy('/bubbles2'));
    }
    function testAlphanumericSpecificationIsNotSatisfiedbyEmpty() {
        $this->assertFalse($this->spec->isSatisfiedBy(''));
    }
}

class RequestSpecificationTest extends UnitTestCase {
    function setUp() {
        $this->coord = new MockCoordinator($this);
        $this->valuespec = new MockValueSpecification($this);
        $this->spec = new SingleFieldSpecification(
            'name',
            $this->valuespec
        );
    }

    function testSpecificationTellsFields() {
        $this->assertEqual(
            'name',
            $this->spec->getValidatedField());
    }

    function testSpecificationChecksWithValueSpecification() {
        $this->coord->setReturnValue('get','bubbles2',array('name'));
        $this->valuespec->expectOnce(
            'isSatisfiedBy',
            array('bubbles2'));
        $this->spec->isSatisfiedBy($this->coord);
        $this->valuespec->tally();
    }

    function testSpecificationIsSatisfiedWhenInnerNot() {
        $this->valuespec->setReturnValue('isSatisfiedBy',TRUE);
        $this->assertTrue(
            $this->spec->isSatisfiedBy($this->coord));
    }
    function testSpecificationIsNotSatisfiedWhenInnerIsNot() {
        $this->valuespec->setReturnValue('isSatisfiedBy',FALSE);
        $this->assertFalse(
            $this->spec->isSatisfiedBy($this->coord));
    }
}

class ValidatorTests extends GroupTest {
    function ValidatorTests() {
        $this->GroupTest("ValidatorTests");
        $this->AddTestCase(new ValidatorIntegrationTest());
        $this->AddTestCase(new EqualFieldsTest());
        $this->AddTestCase(new ValidatorTest());
        $this->AddTestCase(new ValueSpecificationTest());
        $this->AddTestCase(new RequestSpecificationTest());
    }
}

if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    $test = new ValidatorTests();
    $test->run(new TextReporter());
}
