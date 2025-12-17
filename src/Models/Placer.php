<?php

namespace App\Models;
use App\Command\Command;

use App\Exceptions\PlacerException;

class Placer implements Command
{
    private Board $board;
    private string $command;

    private const DIRECTIONS = ['NORTH', 'SOUTH', 'EAST', 'WEST'];

    public function __construct(Board $board, string $command)
    {
        $this->board = $board;
        $this->command = trim($command);
    }

    public function execute(): void
    {
        if (!$this->board) {
            throw new PlacerException(
                'Board not initialized',
                1201,
                ['command' => $this->command]
            );
        }

        $parts = explode(' ', $this->command, 2);

         
        if (count($parts) !== 2) {
            throw new PlacerException(
                'Invalid PLACE command format',
                1202,
                ['command' => $this->command]
            );
        }

        $params = array_map('trim', explode(',', $parts[1]));

        // Validate parameter count
        if (count($params) !== 3) {
            throw new PlacerException(
                'PLACE requires X,Y,DIRECTION',
                1203,
                ['params' => $params]
            );
        }

        [$x, $y, $direction] = $params;

        // Validate X and Y are integers
        if (!is_numeric($x) || !is_numeric($y)) {
            throw new PlacerException(
                'X and Y must be numbers',
                1204,
                ['x' => $x, 'y' => $y]
            );
        }

        $x = (int) $x;
        $y = (int) $y;
        $direction = strtoupper($direction);

     
        if (!in_array($direction, self::DIRECTIONS, true)) {
            throw new PlacerException(
                'Invalid direction',
                1205,
                [
                    'direction' => $direction,
                    'allowed' => self::DIRECTIONS
                ]
            );
        }

        
        $this->board->placeRobot($x, $y, $direction);
    }
}
