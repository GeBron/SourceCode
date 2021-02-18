<?
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';
require_once 'Time.php';

error_reporting(E_ALL);
$GLOBALS['time'] = new Time;

class PeriodTest extends UnitTestCase {
    function testGetMethods() {
        $period = Time::Period(1,2,3,4,5,6,7);
        $this->assertEqual(1,$period->getYears());
        $this->assertEqual(2,$period->getMonths());
        $this->assertEqual(3,$period->getWeeks());
        $this->assertEqual(4,$period->getDays());
        $this->assertEqual(5,$period->getHours());
        $this->assertEqual(6,$period->getMinutes());
        $this->assertEqual(7,$period->getSeconds());
    }
    function doTestAdd($period,$timestamp) {
        $datetime = $period->addTo(Time::DateAndTime(mktime(12,32,55,8,16,2004)));
        $this->assertEqual(Time::DateAndTime($timestamp),$datetime);
    }

    function testAddSeconds() {
        $this->doTestAdd(Time::seconds(6),mktime(12,33,01,8,16,2004));
    }
    function testAddMinutes() {
        $this->doTestAdd(Time::minutes(6),mktime(12,38,55,8,16,2004));
    }
    function testAddHours() {
        $this->doTestAdd(Time::hours(5),mktime(17,32,55,8,16,2004));
    }
    function testAddDays() {
        $this->doTestAdd(Time::days(3),mktime(12,32,55,8,19,2004));
    }
    function testAddMonths() {
        $this->doTestAdd(Time::months(6),mktime(12,32,55,2,16,2005));
    }
    function testAddYears() {
        $this->doTestAdd(Time::years(6),mktime(12,32,55,8,16,2010));
    }
}


class IntervalTest extends UnitTestCase {
    function _testDaysBack() {
        $start = Time::DateAndTime(mktime(12,32,55,8,11,2004));
        $end = Time::DateAndTime(mktime(12,32,55,8,16,2004));
        $interval = Time::intervalFromPeriodAndEnd(
            Time::days(5),
            $end
        );
        $this->assertEqual($end,$interval->getEnd());
        $this->assertEqual($start,$interval->getStart());
    }
}

class FieldValueTest extends UnitTestCase {
    function setUp() {
        $this->dt = Time::DateAndTime(mktime(12,32,55,8,15,2004));
        $this->fv = new FieldWithValue(TimeField::dayOfMonth(),6);

    }
    function testAddToCopy() {
        $copy = $this->fv->addToCopy($this->dt,6);
        $this->assertEqual(mktime(12,32,55,8,21,2004),$copy->getTimestamp());
    }
}

class FieldTest extends UnitTestCase {
    function setUp() {
        $this->dt = Time::DateAndTime(mktime(12,32,55,8,15,2004));
//        print $this->dt->format("%a %e %b %Y %H:%M:%S")."\n";
        $this->domField = TimeField::dayOfMonth();
    }
    
    public function testSetCopy() {
        $copy = $this->domField->setCopy($this->dt,6);
        $this->assertEqual(mktime(12,32,55,8,6,2004),$copy->getTimestamp());

    }

    function testGetDow() {
        $field = TimeField::dayOfWeek();
        $this->assertEqual(Time::SUNDAY,$field->get($this->dt));
    }

    function testGet() {
        $this->assertEqual(15,$this->domField->get($this->dt));
    }

    function testAddToCopy() {
        $copy = $this->domField->addToCopy($this->dt,6);
        $this->assertEqual(mktime(12,32,55,8,21,2004),$copy->getTimestamp());
    }

    function testAddWeeks() {
        $field = TimeField::WeekOfYear();
        $copy = $field->addToCopy($this->dt,2);
        $this->assertEqual(mktime(12,32,55,8,29,2004),$copy->getTimestamp());
    }

}

Mock::generate('TimeField');
class PropertyTest extends UnitTestCase {
    function setUp() {
    }
    function dayDateAndTime($day,$month) {
        return Time::DateAndTime($this->dayTimestamp($day,$month));
    }
    function dayTimestamp($day,$month) {
        return mktime(12,32,55,$month,$day,2004);
    }

    function testSetDOM() {
        $dt = $this->dayDateAndTime(15,8);
        $copy = $dt->dayOfMonth()->setCopy(6);
        $this->assertEqual($this->dayTimestamp(6,8),$copy->getTimestamp());
    }
    function testSetDOWMondayToSunday() {
        $rfcformat = "%a %e %b %Y %H:%M:%S";
        $dt = Time::DateAndTime(mktime(12,32,55,8,9,2004));
        $copy = $dt->dayOfWeek()->setCopy(Time::SUNDAY);
        $this->assertEqual(mktime(12,32,55,8,15,2004),$copy->getTimestamp());
    }
    function testSetDOWMondayToSundayAcrossStartOfMonth() {
        $dt = new DateAndTime(mktime(12,32,55,7,26,2004));
        $copy = $dt->dayOfWeek()->setCopy(Time::SUNDAY);
        $this->assertEqual(mktime(12,32,55,8,1,2004),$copy->getTimestamp());
    }
    function testSetDOWSundayToMonday() {
        $dt = Time::DateAndTime(mktime(12,32,55,8,15,2004));
        $copy = $dt->dayOfWeek()->setCopy(Time::MONDAY);
        $this->assertEqual(mktime(12,32,55,8,9,2004),$copy->getTimestamp());
    }
    function testSetDOWSundayToMondayAcrossStartOfMonth() {
        $dt = Time::DateAndTime(mktime(12,32,55,8,1,2004));
        $copy = $dt->dayOfWeek()->setCopy(Time::MONDAY);
        $this->assertEqual(mktime(12,32,55,7,26,2004),$copy->getTimestamp());
    }

    function testAddToCopy() {
        $dt = new DateAndTime(time() - 3600);
        $dt2 = new DateAndTime;
        $field = new MockTimeField($this);
        $field->expectOnce('addToCopy',array($dt,5));
        $field->setReturnValue('addToCopy',$dt2);
        $prop = new Property($dt,$field);
        $this->assertEqual($dt2,$prop->addToCopy(5));
        $field->tally();
    }
    function testGet() {
        $dt = new DateAndTime;
        $field = new MockTimeField($this);
        $field->expectOnce('get',array($dt));
        $field->setReturnValue('get',5);
        $prop = new Property($dt,$field);
        $this->assertEqual(5,$prop->get());
        $field->tally();
    }
}


class PeriodTests extends GroupTest {
    function PeriodTests() {
        $this->GroupTest("PeriodTests");
//        $this->AddTestCase(new CalcTest());
        $this->AddTestCase(new PeriodTest());
        $this->AddTestCase(new IntervalTest());
        $this->AddTestCase(new PropertyTest());
        $this->AddTestCase(new FieldValueTest());
        $this->AddTestCase(new FieldTest());
    }
}

if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    $test = new PeriodTests();
    $test->run(new TextReporter());
}
