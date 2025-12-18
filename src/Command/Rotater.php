<?php

namespace App\Command;

use App\Exceptions\RotaterException;
use App\Command\Command;
use App\Enums\Direction;
use App\Enums\RotationDirection;
use App\Models\Board;

class Rotater implements Command
{
    private Board $board;
    private RotationDirection $direction;

    public function __construct(Board $board, string $direction)
    {
        $this->board = $board;

        $rotationDirection = RotationDirection::tryFrom(strtoupper($direction));
        if ($rotationDirection === null) {
            throw new RotaterException(
                "Invalid rotation direction: {$direction}",
                1200
            );
        }

        $this->direction = $rotationDirection;
    }

    public function execute(): void
    {
        $placement = $this->board->getRobotPlaced();



        $currentDirection = Direction::validate($placement['facing'], RotaterException::class, 1104);

        $newDirection = $currentDirection->rotate($this->direction);


        $this->board->placeRobot(
            $placement['x'],
            $placement['y'],
            $newDirection->value
        );
    }
}
