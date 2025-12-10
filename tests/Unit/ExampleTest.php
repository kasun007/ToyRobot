<?php

use App\ToyRobot;
 
test('robot moves correctly', function () {
    $robot = new ToyRobot();

    expect($robot->move())->toBe('Robot moved');
});

test('robot turns left', function () {
    $robot = new ToyRobot();

    expect($robot->left())->toBe('Robot turned left');
});

test('robot turns right', function () {
    $robot = new ToyRobot();

    expect($robot->right())->toBe('Robot turned right');
});

test('robot reports position', function () {
    $robot = new ToyRobot();

    expect($robot->report())->toBe([0, 0, 'NORTH']);
});
