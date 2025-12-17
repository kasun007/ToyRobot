<?php

namespace App\Models;

use App\Exceptions\RotaterException;
use App\Command\Command;

class Rotater implements Command
{
    private Board $board;
    private string $direction; // 'LEFT' or 'RIGHT'

    private const DIRECTIONS = ['NORTH', 'EAST', 'SOUTH', 'WEST'];

    public function __construct(Board $board, string $direction)
    {
        $this->board = $board;
        $this->direction = strtoupper($direction);

        if (!in_array($this->direction, ['LEFT', 'RIGHT'], true)) {
            throw new RotaterException(
                "Invalid rotation direction: {$direction}",
                1200
            );
        }
    }

    public function execute(): void
    {
        $placement = $this->board->getRobotPlaced();

        if ($placement === null) {
            throw new RotaterException(
                'Robot is not placed on the board',
                1102,
                ['command' => $this->direction]
            );
        }

        // Validate placement structure
        foreach (['x', 'y', 'facing'] as $key) {
            if (!array_key_exists($key, $placement)) {
                throw new RotaterException(
                    "Invalid placement data: missing {$key}",
                    1103,
                    ['placement' => $placement]
                );
            }
        }

        if (!in_array($placement['facing'], self::DIRECTIONS, true)) {
            throw new BoardException(
                'Invalid facing direction',
                1104,
                [
                    'facing' => $placement['facing'],
                    'allowed' => self::DIRECTIONS
                ]
            );
        }

        // Determine new facing
        $currentIndex = array_search($placement['facing'], self::DIRECTIONS, true);
        $newIndex = $this->direction === 'RIGHT'
            ? ($currentIndex + 1) % count(self::DIRECTIONS)
            : ($currentIndex - 1 + count(self::DIRECTIONS)) % count(self::DIRECTIONS);

        $newFacing = self::DIRECTIONS[$newIndex];

        $this->board->placeRobot(
            $placement['x'],
            $placement['y'],
            $newFacing
        );
    }
}
