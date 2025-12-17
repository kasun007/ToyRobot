<?php

namespace Tests\Unit\Models;

use App\Models\Rotater;
use App\Models\Board;
use App\Exceptions\RotaterException;
use App\Exceptions\BoardException;
use PHPUnit\Framework\TestCase;

class RotaterTest extends TestCase
{
    private Board $board;

    protected function setUp(): void
    {
        parent::setUp();
        $this->board = $this->createMock(Board::class);
    }

    /** @test */
    public function it_rotates_robot_right_from_north_to_east(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 0, 'y' => 0, 'facing' => 'NORTH']);

        $this->board->expects($this->once())
            ->method('placeRobot')
            ->with(0, 0, 'EAST');

        $rotater = new Rotater($this->board, 'RIGHT');
        $rotater->execute();
    }

    /** @test */
    public function it_rotates_robot_right_from_east_to_south(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 1, 'y' => 1, 'facing' => 'EAST']);

        $this->board->expects($this->once())
            ->method('placeRobot')
            ->with(1, 1, 'SOUTH');

        $rotater = new Rotater($this->board, 'RIGHT');
        $rotater->execute();
    }

    /** @test */
    public function it_rotates_robot_right_from_south_to_west(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 2, 'y' => 2, 'facing' => 'SOUTH']);

        $this->board->expects($this->once())
            ->method('placeRobot')
            ->with(2, 2, 'WEST');

        $rotater = new Rotater($this->board, 'RIGHT');
        $rotater->execute();
    }

    /** @test */
    public function it_rotates_robot_right_from_west_to_north(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 3, 'y' => 3, 'facing' => 'WEST']);

        $this->board->expects($this->once())
            ->method('placeRobot')
            ->with(3, 3, 'NORTH');

        $rotater = new Rotater($this->board, 'RIGHT');
        $rotater->execute();
    }

    /** @test */
    public function it_rotates_robot_left_from_north_to_west(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 0, 'y' => 0, 'facing' => 'NORTH']);

        $this->board->expects($this->once())
            ->method('placeRobot')
            ->with(0, 0, 'WEST');

        $rotater = new Rotater($this->board, 'LEFT');
        $rotater->execute();
    }

    /** @test */
    public function it_rotates_robot_left_from_west_to_south(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 1, 'y' => 1, 'facing' => 'WEST']);

        $this->board->expects($this->once())
            ->method('placeRobot')
            ->with(1, 1, 'SOUTH');

        $rotater = new Rotater($this->board, 'LEFT');
        $rotater->execute();
    }

    /** @test */
    public function it_rotates_robot_left_from_south_to_east(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 2, 'y' => 2, 'facing' => 'SOUTH']);

        $this->board->expects($this->once())
            ->method('placeRobot')
            ->with(2, 2, 'EAST');

        $rotater = new Rotater($this->board, 'LEFT');
        $rotater->execute();
    }

    /** @test */
    public function it_rotates_robot_left_from_east_to_north(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 3, 'y' => 3, 'facing' => 'EAST']);

        $this->board->expects($this->once())
            ->method('placeRobot')
            ->with(3, 3, 'NORTH');

        $rotater = new Rotater($this->board, 'LEFT');
        $rotater->execute();
    }

    /** @test */
    public function it_accepts_lowercase_direction(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 0, 'y' => 0, 'facing' => 'NORTH']);

        $this->board->expects($this->once())
            ->method('placeRobot')
            ->with(0, 0, 'EAST');

        $rotater = new Rotater($this->board, 'right');
        $rotater->execute();
    }

    /** @test */
    public function it_accepts_mixed_case_direction(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 0, 'y' => 0, 'facing' => 'NORTH']);

        $this->board->expects($this->once())
            ->method('placeRobot')
            ->with(0, 0, 'WEST');

        $rotater = new Rotater($this->board, 'LeFt');
        $rotater->execute();
    }

    /** @test */
    public function it_throws_exception_for_invalid_direction(): void
    {
        $this->expectException(RotaterException::class);
        $this->expectExceptionMessage('Invalid rotation direction: FORWARD');
        $this->expectExceptionCode(1200);

        new Rotater($this->board, 'FORWARD');
    }

    /** @test */
    public function it_throws_exception_when_robot_not_placed(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(null);

        $this->expectException(RotaterException::class);
        $this->expectExceptionMessage('Robot is not placed on the board');
        $this->expectExceptionCode(1102);

        $rotater = new Rotater($this->board, 'RIGHT');
        $rotater->execute();
    }

    /** @test */
    public function it_throws_exception_when_placement_missing_x(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['y' => 0, 'facing' => 'NORTH']);

        $this->expectException(RotaterException::class);
        $this->expectExceptionMessage('Invalid placement data: missing x');
        $this->expectExceptionCode(1103);

        $rotater = new Rotater($this->board, 'RIGHT');
        $rotater->execute();
    }

    /** @test */
    public function it_throws_exception_when_placement_missing_y(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 0, 'facing' => 'NORTH']);

        $this->expectException(RotaterException::class);
        $this->expectExceptionMessage('Invalid placement data: missing y');
        $this->expectExceptionCode(1103);

        $rotater = new Rotater($this->board, 'RIGHT');
        $rotater->execute();
    }

    /** @test */
    public function it_throws_exception_when_placement_missing_facing(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 0, 'y' => 0]);

        $this->expectException(RotaterException::class);
        $this->expectExceptionMessage('Invalid placement data: missing facing');
        $this->expectExceptionCode(1103);

        $rotater = new Rotater($this->board, 'RIGHT');
        $rotater->execute();
    }

    /** @test */
    public function it_throws_exception_for_invalid_facing_direction(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 0, 'y' => 0, 'facing' => 'NORTHWEST']);

        $this->expectException(BoardException::class);
        $this->expectExceptionMessage('Invalid facing direction');
        $this->expectExceptionCode(1104);

        $rotater = new Rotater($this->board, 'RIGHT');
        $rotater->execute();
    }

    /** @test */
    public function it_does_not_call_place_robot_when_robot_not_placed(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(null);

        $this->board->expects($this->never())
            ->method('placeRobot');

        $rotater = new Rotater($this->board, 'RIGHT');

        try {
            $rotater->execute();
        } catch (RotaterException $e) {
            // Expected exception
        }
    }

    /** @test */
    public function it_maintains_position_during_rotation(): void
    {
        $this->board->method('getRobotPlaced')
            ->willReturn(['x' => 4, 'y' => 3, 'facing' => 'SOUTH']);

        $this->board->expects($this->once())
            ->method('placeRobot')
            ->with(4, 3, 'WEST');

        $rotater = new Rotater($this->board, 'RIGHT');
        $rotater->execute();
    }
}