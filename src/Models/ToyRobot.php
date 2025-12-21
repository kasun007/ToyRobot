<?php

namespace App\Models;

use App\Enums\Direction;
use App\Enums\RotationDirection;
use App\Exceptions\BoardException;
use App\Services\RotationService;

class ToyRobot
{
    private Board $board;
    private RotationService $rotationService;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    public function rotate(RotationDirection $rotation): bool
    {
        try {
            $placement = $this->board->getRobotPlaced();
            $currentFacing = $placement['facing'];
            $directions = [Direction::NORTH, Direction::EAST, Direction::SOUTH, Direction::WEST,];
            $currentIndex = array_search($currentFacing, $directions, true);
            $newIndex = $rotation === RotationDirection::RIGHT ? ($currentIndex + 1) % count($directions) : ($currentIndex - 1 + count($directions)) % count($directions);
            $placement['facing'] = $directions[$newIndex]->value;
            $this->board->setRobotPlacement($placement);
            return true;
        } catch (BoardException $e) {
            return false;
        }
    }

    public function move(): bool
    {
        try {
            $placement = $this->board->getRobotPlaced();
            $x = $placement['x'];
            $y = $placement['y'];
            $facing = $placement['facing'];
            switch ($facing) {
                case Direction::NORTH->value:
                    $y++;
                    break;
                case Direction::SOUTH->value:
                    $y--;
                    break;
                case Direction::EAST->value:
                    $x++;
                    break;
                case Direction::WEST->value:
                    $x--;
                    break;
                default:
                    throw new BoardException("Invalid facing direction: $facing");
            }
            if ($this->board->isOutOfBounds($x, $y)) {
                return false;
            }
            $this->board->setRobotPlacement(['x' => $x, 'y' => $y, 'facing' => $facing]);
            return true;
        } catch (BoardException $e) {
            return false;
        }
    }
}
