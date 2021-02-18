<?php
class Visible {
    private function thisIsPrivate() {
    }
}

$visible = new Visible();
$visible->thisIsPrivate();
?>