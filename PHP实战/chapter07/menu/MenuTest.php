<?php
require_once 'simpletest/unit_tester.php';
require_once 'simpletest/reporter.php';
require_once 'simpletest/mock_objects.php';
require_once 'Menu.php';
Mock::generate('MenuOption','MockMenuOption');

class DummyRequest {}
class DummyNewsPage { function getId() {return 6;} }

class MenuOptionTest extends UnitTestCase {
    function setUp() {
        $this->option = new MenuOption('News from...',6);
    }

    function testCurrent() {
        $this->assertEqual(FALSE,$this->option->isMarked());
        $this->option->mark();
        $this->assertEqual(TRUE,$this->option->isMarked());
    }
}

class MenuTest extends UnitTestCase {
    function setUp() {
        $_POST = array();
        $_GET = array();
        $this->toplevelmenu = new Menu('');

        $this->menu1 = new Menu('News');
        $this->option1 = new MockMenuOption($this);
        $this->option1->setReturnValue('getLabel','News from...');

        $this->option1->setReturnValue(
            'hasMenuOptionWithId',TRUE,array(6));
        $this->menu1->add($this->option1);

        $this->toplevelmenu->add($this->menu1);

        $this->menu2 = new Menu('Olds');
        $this->option2 = new MockMenuOption($this);
        $this->option2->setReturnValue('getLabel','Olds from...');
        $this->option1->setReturnValue(
            'hasMenuOptionWithId',TRUE,array(7));
        $this->menu2->add($this->option2);
        $this->toplevelmenu->add(
            $this->menu2);
    }

    function testAddOption() {
        $options = $this->menu1->getChildren();
        $this->assertEqual(
            $this->option1, 
            $options[0]);
    }

    function testHasExistingCommandId() {
        $this->assertTrue(
            $this->toplevelmenu->hasMenuOptionWithId(6));
    }
    function testDoesNotHaveNonExistentCommandId() {
        $this->assertFalse(
            $this->toplevelmenu->hasMenuOptionWithId(5));
    }

    function testmarkPathToMenuOptionSetsCurrent() {
        $this->option1->expectOnce('markPathToMenuOption',array(6));
        $this->toplevelmenu->markPathToMenuOption(6);
        $this->option1->tally();
        $this->assertTrue($this->menu1->isMarked());
    }

    function testmarkPathToMenuOptionDoesntSetTheOthers() {
        $this->option2->expectNever('markPathToMenuOption');
        $this->toplevelmenu->markPathToMenuOption(6);
        $this->option2->tally();
        $this->assertFalse($this->menu2->isMarked());
    }

    function testmarkWithNonExistentCommandIdDoesntSetsCurrent() {
        $this->option1->expectNever('markPathToMenuOption');
        $this->option2->expectNever('markPathToMenuOption');
        $this->toplevelmenu->markPathToMenuOption(4);
        $this->option1->tally();
        $this->option2->tally();
        $this->assertFalse($this->menu1->isMarked());
        $this->assertFalse($this->menu2->isMarked());
    }

    function testFluentInterface() {
        $menu = new Menu('News');
        $menu->add(new Menu('World'))->add(new Menu('Switzerland'));
        $menu = array_shift($menu->getChildren());
        $this->assertEqual('World',$menu->getLabel());
        $menu = array_shift($menu->getChildren());
        $this->assertEqual('Switzerland',$menu->getLabel());
    }
}

class MenuTests extends GroupTest {
    function MenuTests() {
        $this->GroupTest("MenuTests");
        $this->AddTestCase(new MenuTest());
        $this->AddTestCase(new MenuOptionTest());
    }
}

if (realpath($_SERVER['PHP_SELF']) == __FILE__) {
    $test = new MenuTests();
    $test->run(new TextReporter());
}
?>
