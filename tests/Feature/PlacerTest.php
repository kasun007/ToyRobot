<?php

use App\Placer;
use App\Board;

beforeEach(function () {
    $this->board = Mockery::mock(Board::class);
    $this->placer = new Placer($this->board, '');
});

afterEach(function () {
    Mockery::close();
});

it('executes a valid PLACE command', function () {
    $command = 'PLACE 0,0,NORTH';
    $placer = new Placer($this->board, $command);
    
    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(0, 0, 'NORTH');
    
    $placer->execute();
});

it('executes PLACE command with different coordinates', function () {
    $command = 'PLACE 3,4,SOUTH';
    $placer = new Placer($this->board, $command);
    
    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(3, 4, 'SOUTH');
    
    $placer->execute();
});

it('handles lowercase direction by converting to uppercase', function () {
    $command = 'PLACE 1,2,east';
    $placer = new Placer($this->board, $command);
    
    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(1, 2, 'EAST');
    
    $placer->execute();
});



it('outputs error when PLACE command has no parameters', function () {
    $command = 'PLACE';
    $placer = new Placer($this->board, $command);
    
    $this->board->shouldReceive('placeRobot')->never();
    
    ob_start();
    $placer->execute();
    $output = ob_get_clean();
    
    expect($output)->toContain('Error: PLACE command requires parameters');
});

it('outputs error when PLACE command has incomplete parameters', function () {
    $command = 'PLACE 0,0';
    $placer = new Placer($this->board, $command);
    
    $this->board->shouldReceive('placeRobot')->never();
    
    ob_start();
    $placer->execute();
    $output = ob_get_clean();
    
    expect($output)->toContain('Error: PLACE requires X,Y,DIRECTION');
});

it('outputs error when only one parameter is provided', function () {
    $command = 'PLACE 5';
    $placer = new Placer($this->board, $command);
    
    $this->board->shouldReceive('placeRobot')->never();
    
    ob_start();
    $placer->execute();
    $output = ob_get_clean();
    
    expect($output)->toContain('Error: PLACE requires X,Y,DIRECTION');
});

it('converts non-integer coordinates to integers', function () {
    $command = 'PLACE 2.7,3.9,NORTH';
    $placer = new Placer($this->board, $command);
    
    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(2, 3, 'NORTH');
    
    $placer->execute();
});

it('handles all valid directions', function ($direction) {
    $command = "PLACE 0,0,$direction";
    $placer = new Placer($this->board, $command);
    
    $this->board->shouldReceive('placeRobot')
        ->once()
        ->with(0, 0, strtoupper($direction));
    
    $placer->execute();
})->with(['NORTH', 'SOUTH', 'EAST', 'WEST', 'north', 'south', 'east', 'west']);