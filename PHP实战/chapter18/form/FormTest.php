<?php
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';
require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/Renderer/Default.php';
require_once 'HTML/QuickForm/input.php';
require_once 'Form.php';

error_reporting(E_ALL);

Mock::generate('HTML_QuickForm','MockQuickForm');
Mock::generate('HTML_QuickForm_input','MockQuickFormInput');

class TextInputTest extends UnitTestCase {
    function setUp() {
        $this->quickFormInput = new MockQuickFormInput;
        $this->quickFormInput->setReturnValue('getName','input');
        $this->input = new TextInput(
            $this->quickFormInput,'Validation','Message');
        $this->quickForm = new MockQuickForm;
        $this->form = new Form;
        $this->form->supersedeQuickForm($this->quickForm);
    }

    function testAddsValidationRule() {
        $this->quickForm->expectOnce(
            'addRule',
            array('input','Message','Validation',null,'client'));
        $this->input->addQuickFormRuleToForm($this->form);
    }

    function testDoesntAddValidationRuleIfNoValidation() {
        $this->quickForm->expectNever('addRule');
        $this->input = new TextInput(
            $this->quickFormInput);
        $this->input->addQuickFormRuleToForm($this->form);
    }
}

class FormTest extends UnitTestCase {

    function setUp() {
        $this->quickForm = new MockQuickForm;
        $this->quickFormInput = new MockQuickFormInput;
        $this->quickFormInput->setReturnValue('getName','input');
        $this->form = new Form;
        $this->form->supersedeQuickForm($this->quickForm);
        $this->radio = new RadioButtonGroup($this->quickFormInput);
    }

    function testAddsRadioButtonsToSelf() {
        $this->form->add($this->radio);
        $this->assertEqual(array('input' => $this->radio),$this->form->getElements());
    }

    function testAddsRadioButtonsToQuickForm() {
        $this->quickForm->expectOnce('addElement',array($this->quickFormInput));
        $this->form->add($this->radio);
    }

    function createTextInput() {
        $input = new TextInput($this->quickFormInput);
        $this->quickForm->setReturnValue('addElement',$input);
        return $input;
    }

    function createSelect() {
        $select = new SelectMenu($this->quickFormInput,'Validation','Message');
        $this->quickForm->setReturnValue('addElement',$select);
        return $select;
    }

    function testAddsTextInputToSelf() {
        $element = $this->createTextInput();
        $this->form->addTextElement('Name','Validation','Message');
        $this->assertEqual(array('Name' => $element),
            $this->form->getElements());
    }

    function testAddsTextInputToQuickForm() {
        $this->createTextInput();
        $this->quickForm->expectOnce(
            'addElement',
            array('text','Name','Validation','Message'));
        $this->form->addTextElement('Name','Validation','Message');
    }

    function testAddsValidationForTextInput() {
        $input = new TextInput($this->quickFormInput,'Validation','Message');
        $this->quickForm->setReturnValue('addElement',$input);
        $this->quickForm->expectOnce('addRule',
            array('input','Message','Validation',null,'client'));
        $this->form->addTextElement('input','Validation','Message');
    }

    function testAddsSelectMenuToSelf() {
        $element = $this->createSelect();
        $this->form->addSelect('Name');
        $this->assertEqual(array('Name' => $element),
            $this->form->getElements());
    }

    function testAddsSelectMenuToQuickForm() {
        $this->quickForm->expectOnce('addElement',array('select','Name'));
        $this->createSelect();
        $this->form->addSelect('Name');
    }
}

class FormTests extends GroupTest {
    function FormTests() {
        $this->GroupTest(" FormTests");
        $this->AddTestCase(new FormTest);
        $this->AddTestCase(new TextInputTest);
    }
}

if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    $test = new FormTests();
    $test->run(new TextReporter());
}

