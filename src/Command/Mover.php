<?php

namespace App\Command;

use App\Command\Command;
use App\Models\Board;
use App\Exceptions\BoardException;
use App\Enums\Direction;
use App\Models\ToyRobot;

class Mover implements Command
{
    private Board $board;
    private string $command;
    private ToyRobot $toyRobot;

    public function __construct(Board $board, string $command, ToyRobot $toyRobot)
    {
        $this->board = $board;
        $this->command = $command;
        $this->toyRobot = $toyRobot;
    }

    public function execute(): void
    {
        $placement = $this->board->getRobotPlaced();
        $direction = Direction::validate($placement['facing'], BoardException::class, 1304);
        $this->toyRobot->move();
        
    }
}
