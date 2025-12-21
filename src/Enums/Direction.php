<?php

namespace App\Enums;

use App\Exceptions\BoardException;

enum Direction: string
{
    case NORTH = 'NORTH';
    case SOUTH = 'SOUTH';
    case EAST  = 'EAST';
    case WEST  = 'WEST';

    /**
     * Validate direction from string.
     */
    public static function validate(
        string $facing,
        string $exceptionClass = BoardException::class,
        int $errorCode = 1304
    ): self {
        $direction = self::tryFrom($facing);

        if (!$direction) {
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
