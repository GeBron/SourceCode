<?
require_once 'Time.php';

class Interval {
    private $start;
    private $end;

    public function __construct($start,$end) {
        $this->start = $start;
        $this->end = $end;
    }

    public function getEnd() { return $this->end; }

    public function getStart() { return $this->start; }

}

class Period {
    private $fields;


    public function __construct($years,$months,$weeks,$days,
                                $hours,$minutes,$seconds) 
    {
        $this->fields = array(
            'years' => new FieldWithValue(
                TimeField::Year(),$years), 
            'months' => new FieldWithValue(
                TimeField::Month(),$months), 
            'weeks' => new FieldWithValue(
                TimeField::WeekOfYear(),$weeks),
            'days' => new FieldWithValue(
                TimeField::DayOfMonth(),$days), 
            'hours' => new FieldWithValue(
                TimeField::Hour(),$hours), 
            'minutes' => new FieldWithValue(
                TimeField::Minute(),$minutes), 
            'seconds' => new FieldWithValue(
                TimeField::Second(),$seconds),  
        );
    }
    public function addTo($datetime) {
        foreach ($this->fields as $fieldValue) {
            $datetime = $fieldValue->addToCopy($datetime);
        }
        return $datetime;
    }
    public static function years($n) {
        return Time::Period($n,0,0,0,0,0,0);
    }
    public static function months($n) {
        return Time::Period(0,$n,0,0,0,0,0);
    }
    public static function weeks($n) {
        return Time::Period(0,0,0,7*$n,0,0,0);
    }
    public static function days($n) {
        return Time::Period(0,0,0,$n,0,0,0);
    }
    public static function hours($n) {
        return Time::Period(0,0,0,0,$n,0,0);
    }
    public static function minutes($n) {
        return Time::Period(0,0,0,0,0,$n,0);
    }
    public static function seconds($n) {
        return Time::Period(0,0,0,0,0,0,$n);
    }

    public function getWeeks() { return $this->fields['weeks']->getValue(); }
    public function getYears() { return $this->fields['years']->getValue(); }
    public function getMonths() { return $this->fields['months']->getValue(); }
    public function getDays() { return $this->fields['days']->getValue(); }
    public function getHours() { return $this->fields['hours']->getValue(); }
    public function getMinutes() { return $this->fields['minutes']->getValue(); }
    public function getSeconds() { return $this->fields['seconds']->getValue(); }
}

class Property {
    private $datetime;
    private $field;
    public function __construct($datetime,$field) {
        $this->datetime = $datetime;
        $this->field = $field;
    }

    public function setCopy($value) {
        return $this->field->setCopy($this->datetime,$value);
    }

    public function addToCopy($value) {
        return $this->field->addToCopy($this->datetime,$value);
    }

    public function get() {
        return $this->field->get($this->datetime);
    }

    
}

class FieldWithValue {
    private $field;
    private $value;
    public function __construct($field,$value) {
        if (!is_object($field)) throw new Exception;
        $this->field = $field;
        $this->value = $value;
    }
    public function addToCopy($datetime) {
        return $this->field->addToCopy($datetime,$this->value);
    }
    public function getValue() {
        return $this->value;
    }
}

abstract class TimeField {
    abstract public function get(Instant $time);
    abstract public function setCopy(Instant $time,$value);
    abstract public function addToCopy(Instant $time,$value);

    public static function Year() {
        return new StandardField(5,'%Y'); }

    public static function Month() {
        return new StandardField(3,'%m'); }

    public static function WeekOfYear() {
        return new Field_WeekOfYear; }

    public static function DayOfMonth() {
        return new StandardField(4,'%e'); }

    public static function DayOfWeek() {
        return new Field_DayOfWeek; }

    public static function Hour() {
        return new StandardField(0,'%H'); }

    public static function Minute() {
        return new StandardField(1,'%M'); }

    public static function Second() {
        return new StandardField(2,'%S'); }


}

class StandardField extends TimeField {
    private $integerID;
    private $strftimeFormat;

    public function __construct($integerID,$strftimeFormat) {
        $this->integerID = $integerID;
        $this->strftimeFormat = $strftimeFormat;
    }
    public function get(Instant $time) {
        return strftime(
            $this->strftimeFormat,
            $time->getTimestamp());
    }

    public function setCopy(Instant $time,$value) {
        $array = $this->instantToArray($time);
        $array[$this->integerID] = $value;
        return $this->arrayToInstant($array);
    }

    public function addToCopy(Instant $time,$value) {
        $array = $this->instantToArray($time);
        $array[$this->integerID] += $value;
        return $this->arrayToInstant($array);
    }

    private function instantToArray(Instant $instant) {
        return explode('-',
            strftime(
                '%H-%M-%S-%m-%e-%Y',
                $instant->getTimestamp())
            );
    }

    private function arrayToInstant($array) {
        return new DateAndTime(
            call_user_func_array('mktime',$array));
        return new DateAndTime(mktime(
            $array[0],
            $array[1],
            $array[2],
            $array[3],
            $array[4],
            $array[5]
            ));
    }


}

class Field_DayOfWeek extends TimeField {
    public function get(Instant $time){
        return strftime('%u',$time->getTimestamp());
    }
    public function setCopy(Instant $time,$value){
        $dayfield = TimeField::dayOfMonth();
        return $dayfield->addToCopy(
            $time,
            $value - $this->get($time)
        );

    }

    public function addToCopy(Instant $time,$value){
    }
}

class Field_WeekOfYear extends TimeField {
    public function get(Instant $time){
        return strftime('%V',$time->getTimestamp());
    }

    public function setCopy(Instant $time,$value){
        $dayfield = TimeField::dayOfMonth();
        return $dayfield->addToCopy(
            $time,
            $value - $this->get($time)
        );

    }

    public function addToCopy(Instant $time,$value){
        return $time->dayOfMonth()->addToCopy($value * 7);
    }
}

interface Instant {}

class DateAndTime implements Instant {
    private $timestamp;

    public function __construct($timestamp=FALSE) {
        if (!$timestamp) $timestamp = time();
        $this->timestamp = $timestamp;
    }

    public function format($format) {
        return strftime($format,$this->timestamp);
    }
    public function getTimestamp() {
        return $this->timestamp;
    }

    public function dayOfWeek() {
        return new Property($this,TimeField::dayOfWeek());
    }
    public function dayOfMonth() {
//        return new Property($this,new StandardField(4,'%e'));
        return new Property($this,TimeField::dayOfMonth());
    }
    public function weekOfYear() {
//        return new Property($this,new Field_WeekOfYear);
        return new Property($this,TimeField::weekOfYear());
    }

}
?>
