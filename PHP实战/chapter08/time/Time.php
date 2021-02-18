<?
require_once 'TimeClasses.php';

class Bar {
    public static function BAZ() {
        return 5;
    }
}
class Foo {
    public static function Bar() {
        return new Bar;
    }
}
class Time {
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
    const SUNDAY = 7;
    public function Property($datetime,$field) {
        return new Property($datetime,$field);
    }

    public function DateAndTime($timestamp=FALSE) {
        return new DateAndTime($timestamp);
    }
    public function Period($a1,$a2,$a3,$a4,$a5,$a6,$a7) {
        return new Period($a1,$a2,$a3,$a4,$a5,$a6,$a7);
    }
    public function Interval($start,$end) {
        return new Interval($start,$end);
    }

    public function intervalFromPeriodAndEnd($period,$end) {
         return new Interval($period->subtractFrom($end),$end);
    }

    public static function seconds($n) { return Period::seconds($n); }
    public static function minutes($n) { return Period::minutes($n); }
    public static function hours($n) { return Period::hours($n); }
    public static function days($n) { return Period::days($n); }
    public static function weeks($n) { return Period::weeks($n); }
    public static function months($n) { return Period::months($n); }
    public static function years($n) { return Period::years($n); }
}
