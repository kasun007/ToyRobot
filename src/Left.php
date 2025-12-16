<?php

namespace App;

use App\Exceptions\BoardException;

class Left implements Command
{
    private Board $board;
    private string $command;

    private const DIRECTIONS = ['NORTH', 'WEST', 'SOUTH', 'EAST'];

    public function __construct(Board $board, string $command)
    {
        $this->board = $board;
        $this->command = $command;
    }

    public function execute(): void
    {
        if (!$this->board) {
            throw new BoardException(
                'Board not initialized',
                1001,
                ['command' => $this->command]
            );
        }

        $placement = $this->board->getRobotPlaced();

        if ($placement === null) {
            throw new BoardException(
                'Robot is not placed on the board',
                1002,
                ['command' => $this->command]
            );
        }

        // Validate placement structure
        foreach (['x', 'y', 'facing'] as $key) {
            if (!array_key_exists($key, $placement)) {
                throw new BoardException(
                    "Invalid placement data: missing {$key}",
                    1003,
                    ['placement' => $placement]
                );
            }
        }

        // Validate facing direction
        if (!in_array($placement['facing'], self::DIRECTIONS, true)) {
            throw new BoardException(
                'Invalid facing direction',
                1004,
                [
                    'facing' => $placement['facing'],
                    'allowed' => self::DIRECTIONS
                ]
            );
        }

        // Rotate LEFT
        $rotations = [
            'NORTH' => 'WEST',
            'WEST'  => 'SOUTH',
            'SOUTH' => 'EAST',
            'EAST'  => 'NORTH'
        ];

        $newFacing = $rotations[$placement['facing']];

        $this->board->placeRobot(
            $placement['x'],
            $placement['y'],
            $newFacing
        );
    }
}
