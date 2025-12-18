<?php

namespace App\Command;

use App\Command\Command;
use App\Models\Board;
use App\Exceptions\BoardException;  
use App\Enums\Direction;

class Mover implements Command
{
    private Board $board;
    private string $command;

    public function __construct(Board $board, string $command)
    {
        $this->board = $board;
        $this->command = $command;
    }

    public function execute(): void
    {
        if (!$this->board) {
            throw new BoardException('Board not initialized', 1301, ['command' => $this->command]);
        }

        $placement = $this->board->getRobotPlaced();
        $direction = Direction::validate($placement['facing'], BoardException::class, 1304);
        $newPosition = $direction->move((int) $placement['x'], (int) $placement['y']);
        $this->board->placeRobot($newPosition['x'], $newPosition['y'], $direction->value);
    }
}
