<?php

namespace App\Enums;

use App\Exceptions\BoardException;
use App\Exceptions\RotaterException;

enum Direction: string
{
    case NORTH = 'NORTH';
    case SOUTH = 'SOUTH';
    case EAST = 'EAST';
    case WEST = 'WEST';


    public function move(int $x, int $y): array
    {
        return match ($this) {
            self::NORTH => ['x' => $x, 'y' => $y + 1],
            self::SOUTH => ['x' => $x, 'y' => $y - 1],
            self::EAST => ['x' => $x + 1, 'y' => $y],
            self::WEST => ['x' => $x - 1, 'y' => $y],
        };
    }


    public function rotate(RotationDirection $rotation): self
    {
        $directions = [
            self::NORTH,
            self::EAST,
            self::SOUTH,
            self::WEST,
        ];

        $currentIndex = array_search($this, $directions, true);

        $newIndex = $rotation === RotationDirection::RIGHT
            ? ($currentIndex + 1) % count($directions)
            : ($currentIndex - 1 + count($directions)) % count($directions);

        return $directions[$newIndex];
    }



    public static function validate(string $facing, string $exceptionClass = BoardException::class, int $errorCode = 1304): self
    {
        $direction = self::tryFrom($facing);

        if ($direction === null) {
            throw new $exceptionClass(
                'Invalid facing direction',
                $errorCode,
                [
                    'facing' => $facing,
                    'allowed' => array_column(self::cases(), 'value')
                ]
            );
        }

        return $direction;
    }
}



enum RotationDirection: string
{
    case LEFT = 'LEFT';
    case RIGHT = 'RIGHT';
}
