<?php
require_once 'Zend/Filter.php';

interface ValueSpecification {
    public function isSatisfiedBy($candidate);
}

class AlnumValueSpecification {
    public function isSatisfiedBy($candidate) {
        return ctype_alnum($candidate);
    }
}

class SingleFieldSpecification {
    private $fieldname;
    private $valueSpecification;

    public function __construct($fieldname,$spec) {
        $this->fieldname = $fieldname;
        $this->valueSpecification = $spec;
    }

    function getValidatedField() { 
        return $this->fieldname; 
    }

    function isSatisfiedBy($candidate) {
        return $this->valueSpecification->isSatisfiedBy(
            $candidate->get($this->fieldname));
    }

    function forField($fieldname) {
        $this->fieldname = $fieldname;
    }
}

class BasicValidator {
    private $specification;
    private $message;

    public function __construct($specification='',$message='') {
        $this->specification = $specification;
        $this->message = $message;
    }
    public function validate($request) {
        if ($this->specification->isSatisfiedBy($request)) {
            $request->setClean(
                 $this->specification->getValidatedField());
            return TRUE;
        }
        else {
            $request->addError(
                new ValidationError($this->message));
            return FALSE;
        }
    }
    public function withMessage($message) {
        $this->message = $message;
        return $this;
    }

    public function forField($fieldname) {
        $this->specification->forField($fieldname);
        return $this;
    }
}

class EqualFieldsSpecification {
    private $field1;
    private $field2;

    public function __construct($field1,$field2) {
        $this->field1 = $field1;
        $this->field2 = $field2;
    }

    public function isSatisfiedBy($candidate) {
        return $candidate->get($this->field1)
            == $candidate->get($this->field2);
    }

    public function getValidatedField() {
        return FALSE;
    }
}
