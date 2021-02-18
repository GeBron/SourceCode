<?php
class DateRange {
    private $start;
    private $end;

    public function __construct($start,$end) {
        $this->start = $start;
        $this->end = $end;
    }

    public function contains($other) {
        return $this->start < $other->getStart()
            && $this->end > $other->getEnd();
    }

    public function getStart() { return $this->start; }
    public function getEnd() { return $this->end; }
}
