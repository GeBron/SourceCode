<?php
class SingleFieldSpecification {
    private $fieldname;
    private $valueSpecification;

    public function __construct($fieldname,$specification) {
        $this->fieldname = $fieldname;
        $this->valueSpecification = $specification;
    }

    function getValidatedField() {
        return $this->fieldname;
    }

    function isSatisfiedBy($candidate) {
        return $this->valueSpecification->isSatisfiedBy(
            $candidate->get($this->fieldname));
    }
}
