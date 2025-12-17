<?php

use App\Models\Board ;  
 


it('returns null when robot has not been placed', function () {
    $board = new Board();
    
    expect($board->getRobotPlaced())->toBeNull();
});

it('returns placement array when robot has been placed', function () {
    $board = new Board();
    $board->placeRobot(2, 3, 'EAST');
    
    expect($board->getRobotPlaced())->toBe([
        'x' => 2,
        'y' => 3,
        'facing' => 'EAST'
    ]);
});

it('can set robot placement with array', function () {
    $board = new Board();
    
    $board->setRobotPlacement([
        'x' => 4,
        'y' => 2,
        'facing' => 'SOUTH'
    ]);
    
    expect($board->getRobotPlaced())->toBe([
        'x' => 4,
        'y' => 2,
        'facing' => 'SOUTH'
    ]);
});


it('sets up board with default 5x5 size', function () {
    $board = new Board();
    
    expect($board->getBoardSize())->toBe([
        'width' => 5,
        'height' => 5
    ]);
});

it('sets up board with custom size', function () {
    $board = new Board(10, 8);
    
    expect($board->getBoardSize())->toBe([
        'width' => 10,
        'height' => 8
    ]);
});

it('validates bounds based on board size', function () {
    $board = new Board(5, 5);
    
    expect($board->placeRobot(4, 4, 'NORTH'))->toBeTrue();
    expect($board->placeRobot(5, 5, 'NORTH'))->toBeFalse();
});

it('validates bounds for custom board size', function () {
    $board = new Board(3, 3);
    
    expect($board->placeRobot(2, 2, 'NORTH'))->toBeTrue();
    expect($board->placeRobot(3, 3, 'NORTH'))->toBeFalse();
});











 