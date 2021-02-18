<?php
class ValidationError {
    private $message;

    public function __construct($message) {
        $this->message = $message;
    }
    
    public function getMessage() {
        return $this->message;
    }
}

class ValidationCoordinator {
    private $raw;
    private $clean;
    private $errors = array();

    public function __construct($raw,$clean) {
        $this->raw = $raw;
        $this->clean = $clean;
    }

    public function get($name) {
        return $this->raw->getForValidation($name);
    }

    public function setClean($name=FALSE) {
        if (!$name) return FALSE;
        $this->clean = $this->clean->set(
            $name,
            $this->raw->getForValidation($name));
    }

    public function addError($error) {
        $this->errors[] = $error;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getCleanRequest() {
        return $this->clean;
    }
}

class AlnumFieldValidator extends Validator {
    private $fieldname;
    private $message;
    
    public function __construct($fieldname,$message) {
        $this->fieldname = $fieldname;
        $this->message = $message;
    }

    public function validate($coordinator) {
        if (ctype_alnum(
            $coordinator->get($this->fieldname)))
        {
            $coordinator->setClean($this->fieldname);
            return TRUE;
        } else {
            $coordinator->addError($this->message);
            return FALSE;
        }
    }
}

class Validator {
    public function validate($request) {}
}

class ValidationFacade {
    private $coordinator;
    private $validators = array();
    private $hasValidated = FALSE;

    public function addValidator($validator) {
        $this->validators[] = $validator;
        return $validator;
    }

    public function validate($request) {
        $this->coordinator = $this->createCoordinator(
            $request,
            new CleanRequest);
        foreach ($this->validators as $validator) {
            $validator->validate($this->coordinator);
        }
        $this->hasValidated = TRUE;
        return $this->isValid();
    }

    public function isValid() {
        if (!$this->hasValidated) return FALSE;
        return count($this->coordinator->getErrors()) == 0;
    }

    public function createCoordinator($raw,$clean) {
        return new ValidationCoordinator($raw,$clean);
    }

    public function addAlnumValidation($fieldname='',$message='') {
        return $this->addValidator(
            new BasicValidator(
                new SingleFieldSpecification(
                    $fieldname,
                    new AlnumValueSpecification
                ),
                $message
            )
        );
    }
    public function _addAlnumValidation($fieldname) {
        $this->addValidator(
            new FieldValidatorAlnum(
                $fieldname)
            );
    }

    public function getCleanRequest() {
        if (!$this->isValid()) return FALSE;
        return $this->coordinator->getCleanRequest();
    }

    public function getErrors() {
        if ($this->isValid()) return FALSE;
        return $this->coordinator->getErrors();
    }

    public function getValidators() {
        return $this->validators;
    }
}
