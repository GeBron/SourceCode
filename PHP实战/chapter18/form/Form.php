<?php
require_once 'HTML/QuickForm.php';
require_once 'HTML/QuickForm/Renderer/Default.php';
abstract class AbstractInputControl {
    protected $quickFormElement;

    abstract public function setValue($value);
    abstract public function getValue();

    public function __construct($quickFormElement) {
        $this->quickFormElement = $quickFormElement;
    }
    
    public function asHtml() {
        $renderer = new HTML_QuickForm_Renderer_Default;
        $renderer->setElementTemplate("{element}");
        $this->quickFormElement->accept($renderer);
        return $renderer->toHtml();
    }

    public function getName() {
        return $this->quickFormElement->getName();
    }

    public function getQuickFormElement() {
        return $this->quickFormElement;
    }

    public function addQuickFormRuleToForm() {}
}

class TextInput extends AbstractInputControl {
    protected $quickFormElement;
    private $validation;
    private $message;

    public function __construct(
        $quickFormElement,$validation='',$message='') {
        $this->validation = $validation;
        $this->message = $message;
        $this->quickFormElement = $quickFormElement;
    }

    public function setValue($value) {
        $this->quickFormElement->setValue($value);
    }

    public function getValue() {
        return $this->quickFormElement->getValue();
    }

    public function getLabel() {
        return $this->quickFormElement->getLabel();
    }

    public function addQuickFormRuleToForm($form) {
        if (!$this->validation) return;
        $form->getQuickForm()->addRule(
            $this->getName(),
            $this->message,
            $this->validation,
            null,
            'client'
        );
    }
}

abstract class SelectOne extends AbstractInputControl
{
    protected $quickFormElement;

    public function __construct($quickFormElement) {
        $this->quickFormElement = $quickFormElement;
    }

    abstract public function addOption($text,$value);
}

class SelectMenu extends SelectOne{
    protected $quickFormElement;

    public function addOption($text,$value) {
        $this->quickFormElement->addOption($text,$value);
    }

    public function setValue($value) {
        $this->quickFormElement->setValue($value);
    }

    public function getValue() {
        $values = $this->quickFormElement->getValue();
        return $values[0];
    }
}

class RadioButtonGroup extends SelectOne
{
    private $value;
    private $options = array();

    protected $quickFormElement;

    public function addOption($text,$value) {
        $elements = $this->quickFormElement->getElements();
        $element = new HTML_QuickForm_radio(
            NULL,$text,NULL,$value);
        $elements[] = $element;
        $this->quickFormElement->setElements($elements);
        $this->options[$value] = $element;
    }

    public function setValue($value) {
        $this->value = $value;
        if (!array_key_exists($value,$this->options)) return;
        $this->options[$value]->setChecked(TRUE);
    }

    public function getValue() {
        return $this->value;
    }

    public function options() {
        return $this->options;
    }
}

class Form {
    private $quickForm;
    private $elements = array();

    public function __construct() {
        $this->quickForm = new HTML_QuickForm;
    }

    public function add($element) {
        $this->quickForm->addElement($element->getQuickFormElement());
        return $this->registerElementAndRule($element->getName(),$element);
    }

    public function addTextElement($name,$validation,$message) {
        $element =
            $this->quickForm->addElement(
            'text',$name,$validation,$message);
        return $this->registerElementAndRule($name,$element);
    }

    public function addSelect($name) {
        $element =
            $this->quickForm->addElement('select',$name);
        return $this->registerElementAndRule($name,$element);
    }

    public function registerElementAndRule($name,$element) {
        $this->elements[$name] = $element;
        $element->addQuickFormRuleToForm($this);
        return $element;
    }

    
    public function getElements() {
        return $this->elements;
    }

    public function getValidationScript() {
        return $this->quickForm->getValidationScript();
    }

    public function validate() {
        return $this->quickForm->validate();
    }

    public function getQuickForm() {
        return $this->quickForm;
    }

    // Added for the sake of retrofitted tests:
    public function supersedeQuickForm($quickForm) {
        $this->quickForm = $quickForm;
    }
}
