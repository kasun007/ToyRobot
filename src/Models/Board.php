<?php

namespace App\Models;

use App\Exceptions\BoardException;

class Board
{
    private ?array $robotPlacement = null;
    private int $width;
    private int $height;
    private int $MIN_WIDTH = 0;
    private int $MIN_HEIGHT = 0;
    private string $facing;

    function __construct(int $width = 5, int $height = 5)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function getRobotPlaced(): array
    {
        if ($this->robotPlacement === null) {
            throw new BoardException(
                'Robot is not placed on the board',
                1302
            );
        }

        foreach (['x', 'y', 'facing'] as $key) {
            if (!array_key_exists($key, $this->robotPlacement)) {
                throw new BoardException(
                    "Invalid placement data: missing {$key}",
                    1303,
                    ['placement' => $this->robotPlacement]
                );
            }
        }

        return $this->robotPlacement;
    }

    function isOutOfBounds(int $x, int $y): bool
    {

        return $x < $this->MIN_WIDTH || $x >= $this->width ||
            $y < $this->MIN_HEIGHT || $y >= $this->height;
    }

    function placeRobot(int $x, int $y, string $facing): bool
    {
        if ($this->isOutOfBounds($x, $y)) {
            return false;
        }

        $this->robotPlacement = [
            'x' => $x,
            'y' => $y,
            'facing' => $facing
        ];

        return true;
    }

    function setRobotPlacement(array $placement): void
    {
        $this->robotPlacement = $placement;
    }

    function getBoardSize(): array
    {
        return [
            'width' => $this->width,
            'height' => $this->height
        ];
    }
}
