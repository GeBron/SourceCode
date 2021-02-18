<?php
class EqualFieldsSpecification {
    private $field1;
    private $field2;

    public function __construct($field1,$field2) {
        $this->field1 = $field1;
        $this->field2 = $field2;
    }

    public function isSatisfiedBy($candidate) {
        return $candidate ->get($this->field1)
            == $candidate ->get($this->field2);
    }

    public function getFieldname() {
        return FALSE;
    }
}
