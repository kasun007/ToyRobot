<?php

namespace Tests\Feature;

use App\Mover;
use App\Board;
use App\Exceptions\BoardException;
use Mockery;

beforeEach(function () {
    // Create a Mockery mock for Board
    $this->board = Mockery::mock(Board::class);
});

afterEach(function () {
    // Cleanup Mockery
    Mockery::close();
});

it('throws an exception if robot is not placed', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(null);

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
})->throws(BoardException::class, 'Robot is not placed on the board');

it('throws an exception if placement data is missing keys', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 0, 'y' => 0]); // missing 'facing'

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
})->throws(BoardException::class, 'Invalid placement data: missing facing');

it('throws an exception if facing direction is invalid', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 0, 'y' => 0, 'facing' => 'UP']);

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
})->throws(BoardException::class, 'Invalid facing direction');

it('moves the robot north correctly', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 1, 'y' => 1, 'facing' => 'NORTH']);
    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(1, 2, 'NORTH');

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});

it('moves the robot south correctly', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 2, 'y' => 2, 'facing' => 'SOUTH']);
    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(2, 1, 'SOUTH');

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});

it('moves the robot east correctly', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 0, 'y' => 0, 'facing' => 'EAST']);
    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(1, 0, 'EAST');

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});

it('moves the robot west correctly', function () {
    $this->board->shouldReceive('getRobotPlaced')
        ->once()
        ->andReturn(['x' => 5, 'y' => 5, 'facing' => 'WEST']);
    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(4, 5, 'WEST');

    $mover = new Mover($this->board, 'MOVE');
    $mover->execute();
});
