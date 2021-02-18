<?php
$testname = 'SomeTest';
$run = 1;      //Number of cases actually run
$cases = 1;    //Total number of cases
$passes = 0;
$failures = 2;
$exceptions = 0;
$count = 0;    //Start counting tests at 0
$ok = FALSE;
$failreports = array(
    array(
    'message'=>"Equal expectation fails because [Integer: 1]".
        "differs from [Integer: 2] by 1 at line [8]",
    'breadcrumb'=>'testSomething'
    ),
    array(
    'message'=>"Equal expectation fails because [Integer: 2]".
        "differs from [Integer: 3] by 1 at line [9]",
    'breadcrumb'=>'testSomething'
    ),
);
?>
<?=$testname ?>
<?php foreach ($failreports as $failure): ?>

<?=++$count ?>) <?=$failure['message'] ?>

        <?=$failure['breadcrumb'] ?>
<?php endforeach; ?>

<?php if ($ok): ?>
OK
<?php else: ?>
FAILURES!!!
<?php endif; ?>
Test cases run: <?=$run ?>/<?=$cases ?>, Passes: <?=$passes ?>,
Failures: <?=$failures ?>, Exceptions: <?=$exceptions ?>
