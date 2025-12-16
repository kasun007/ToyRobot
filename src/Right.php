<?php

namespace App;

use App\Exceptions\BoardException;

class Right implements Command
{
    private Board $board;
    private string $command;

    private const DIRECTIONS = ['NORTH', 'EAST', 'SOUTH', 'WEST'];

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
                1101,
                ['command' => $this->command]
            );
        }

        $placement = $this->board->getRobotPlaced();

        if ($placement === null) {
            throw new BoardException(
                'Robot is not placed on the board',
                1102,
                ['command' => $this->command]
            );
        }

        // Validate placement structure
        foreach (['x', 'y', 'facing'] as $key) {
            if (!array_key_exists($key, $placement)) {
                throw new BoardException(
                    "Invalid placement data: missing {$key}",
                    1103,
                    ['placement' => $placement]
                );
            }
        }

        // Validate facing direction
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

        // Rotate RIGHT
        $rotations = [
            'NORTH' => 'EAST',
            'EAST'  => 'SOUTH',
            'SOUTH' => 'WEST',
            'WEST'  => 'NORTH'
        ];

        $newFacing = $rotations[$placement['facing']];

        $this->board->placeRobot(
            $placement['x'],
            $placement['y'],
            $newFacing
        );
    }
}
