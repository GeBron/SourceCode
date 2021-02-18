<?php
abstract class MenuVisitor {
    abstract public function visitMenuOption($option);
    abstract public function visitMenu($menu);
}

abstract class MenuComponent {
    protected $marked = FALSE;
    protected $label;

    public function mark() { $this->marked = TRUE; } 
    public function isMarked() { return $this->marked; }

    public function getLabel() { return $this->label; }
    public function setLabel($label) { $this->label = $label; }

    abstract public function hasMenuOptionWithId($id);
    abstract public function markPathToMenuOption($id);

}

class MenuOption extends MenuComponent {
    protected $marked = FALSE;
    protected $label;
    private $id;

    public function __construct($label,$id) {
        $this->label = $label;
        $this->id = $id;
    }
    public function hasMenuOptionWithId($id) {
        return $id == $this->id;
    }
    public function markPathToMenuOption($id) {
        if ($this->hasMenuOptionWithId($id)) $this->mark();
    }

    public function getId() { return $this->id; }

}

class Menu extends MenuComponent {
    protected $marked = FALSE;
    protected $label;
    private $children = array();

    public function __construct($label) {
        $this->label = $label;
    }

    public function add($child) {
        return $this->children[] = $child;
    }

    public function hasMenuOptionWithId($id) {
        foreach ($this->children as $child) {
            if ($child->hasMenuOptionWithId($id)) return TRUE;
        }
        return FALSE;
    }

    public function markPathToMenuOption($id) {
        if (!$this->hasMenuOptionWithId($id)) return FALSE;
        $this->mark();
        foreach ($this->children as $child) {
            $child->markPathToMenuOption($id);
        }
    }

    public function getChildren() {
        return $this->children;
    }
}
?>
