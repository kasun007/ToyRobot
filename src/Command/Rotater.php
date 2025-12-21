<?php

namespace App\Command;

use App\Exceptions\RotaterException;
use App\Command\Command;
use App\Enums\Direction;
use App\Enums\RotationDirection;
use App\Models\Board;
use App\Models\ToyRobot;

class Rotater implements Command
{
    private Board $board;
    private RotationDirection $direction;
    private ToyRobot $toyRobot;

    public function __construct(Board $board, RotationDirection $direction, ToyRobot $toyRobot)
    {
        $this->board = $board;
        $this->toyRobot = $toyRobot;
        $this->direction = $direction;
        // Validate rotation direction
        $rotationDirection = RotationDirection::tryFrom(strtoupper($direction->value));
        if ($rotationDirection === null) {
            throw new RotaterException(
                "Invalid rotation direction: {$direction}",
                1200
            );
        }
    }

    public function execute(): void
    {
        // Check if robot is placed
        $placement = $this->board->getRobotPlaced();
        if ($placement === null) {
            throw new RotaterException("Robot is not placed on the board", 1101);
        }
 
        // Validate current direction
        Direction::validate($placement['facing'], RotaterException::class, 1104);

        // Rotate robot - ToyRobot updates its own direction internally
        $newDirection = $this->toyRobot->rotate($this->direction);
       
    }
}
