<?php

namespace App;

use App\Exceptions\BoardException;

class Mover implements Command
{
    private Board $board;
    private string $command;

    private const DIRECTIONS = ['NORTH', 'SOUTH', 'EAST', 'WEST'];

    public function __construct(Board $board, string $command)
    {
        $this->board = $board;
        $this->command = $command;
    }

    public function execute(): void
    {
        if (!$this->board) {
            throw new BoardException('Board not initialized',1301,['command' => $this->command]);
        }

        $placement = $this->board->getRobotPlaced();
 
        if ($placement === null) {
            throw new BoardException(
                'Robot is not placed on the board',
                1302,
                ['command' => $this->command]
            );
        }

       
        foreach (['x', 'y', 'facing'] as $key) {
            if (!array_key_exists($key, $placement)) {
                throw new BoardException(
                    "Invalid placement data: missing {$key}",
                    1303,
                    ['placement' => $placement]
                );
            }
        }

        
        if (!in_array($placement['facing'], self::DIRECTIONS, true)) {
            throw new BoardException(
                'Invalid facing direction',
                1304,
                [
                    'facing' => $placement['facing'],
                    'allowed' => self::DIRECTIONS
                ]
            );
        }

        $x = (int) $placement['x'];
        $y = (int) $placement['y'];
        $facing = $placement['facing'];

       
        switch ($facing) {
            case 'NORTH': $y++; break;
            case 'SOUTH': $y--; break;
            case 'EAST':  $x++; break;
            case 'WEST':  $x--; break;
        }

         
        $this->board->placeRobot($x, $y, $facing);
    }
}
