<?php
abstract class AbstractInputControl {
    protected $quickFormElement;

    abstract public function setValue($value);
    abstract public function getValue();

    public function asHtml() {
        $renderer = new HTML_QuickForm_Renderer_Default;
        $renderer->setElementTemplate("{element}");
        $this->quickFormElement->accept($renderer);
        return $renderer->toHtml();
    }
    public function getName() {
        return $this->quickFormElement->getName();
    }
}
