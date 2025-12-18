<?php

use App\Command\Mover;
use App\Models\Board;
use App\Exceptions\BoardException;
use Mockery;

beforeEach(function () {
    $this->board = Mockery::mock(Board::class);
});

afterEach(function () {
    Mockery::close();
});

it('moves robot north successfully', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 2, 'y' => 2, 'facing' => 'NORTH']);

    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(2, 3, 'NORTH')
        ->andReturn(true);

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});

it('moves robot south successfully', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 2, 'y' => 2, 'facing' => 'SOUTH']);

    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(2, 1, 'SOUTH')
        ->andReturn(true);

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});

it('moves robot east successfully', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 2, 'y' => 2, 'facing' => 'EAST']);

    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(3, 2, 'EAST')
        ->andReturn(true);

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});

it('moves robot west successfully', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 2, 'y' => 2, 'facing' => 'WEST']);

    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(1, 2, 'WEST')
        ->andReturn(true);

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});

it('prevents robot from moving off north edge', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 2, 'y' => 4, 'facing' => 'NORTH']);

    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(2, 5, 'NORTH')
        ->andReturn(false);

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});

it('prevents robot from moving off south edge', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 2, 'y' => 0, 'facing' => 'SOUTH']);

    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(2, -1, 'SOUTH')
        ->andReturn(false);

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});

it('prevents robot from moving off east edge', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 4, 'y' => 2, 'facing' => 'EAST']);

    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(5, 2, 'EAST')
        ->andReturn(false);

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});

it('prevents robot from moving off west edge', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 0, 'y' => 2, 'facing' => 'WEST']);

    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(-1, 2, 'WEST')
        ->andReturn(false);

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});

it('throws exception when robot not placed', function () {
    $board = new Board();
    $mover = new Mover($board, 'MOVE');

    expect(fn() => $mover->execute())
        ->toThrow(BoardException::class, 'Robot is not placed on the board');
});





it('throws exception for invalid facing direction', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 2, 'y' => 2, 'facing' => 'INVALID']);

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
})->throws(BoardException::class, 'Invalid facing direction', 1304);


it('throws exception for missing x coordinate', function () {
    $board = new Board();

    // Simulate invalid placement
    $board->setRobotPlacement([
        // 'x' is missing
        'y' => 1,
        'facing' => 'NORTH',
    ]);

    $mover = new Mover($board, 'MOVE');

    expect(fn() => $mover->execute())
        ->toThrow(BoardException::class, 'Invalid placement data: missing x');
});





it('throws exception for missing y coordinate', function () {
    $board = new Board();

    // Simulate invalid placement
    $board->setRobotPlacement([
        // 'x' is missing
        'x' => 2,
        'facing' => 'NORTH',
    ]);;

    $mover = new Mover($board, 'MOVE');
    
    expect(fn() => $mover->execute())
        ->toThrow(BoardException::class, 'Invalid placement data: missing y');
});

it('throws exception for missing facing coordinate', function () {
    $board = new Board();

    // Simulate invalid placement
    $board->setRobotPlacement([
        'y' => 2,
        'x' => 2,
         
    ]);;

    $mover = new Mover($board, 'MOVE');
    
    expect(fn() => $mover->execute())
        ->toThrow(BoardException::class, 'Invalid placement data: missing facing');
});
