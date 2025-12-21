<?php

namespace App\Command;

use App\Models\Board;
use App\Command\Placer;
use App\Command\Rotater;
use App\Command\Mover;
use App\Command\Reporter;       
use App\Command\Exiter;
use App\Command\Command;
use App\Models\ToyRobot;
use App\Enums\RotationDirection;


use Exception;

class CommandFactory
{
    private Board $board;
    private ToyRobot $toyRobot;
    

    public function __construct(Board $board, ToyRobot $toyRobot)
    {
        $this->board = $board;
        $this->toyRobot = $toyRobot;
    }

    /** 
     * Create a Command object based on the command string
     *
     * @param string $commandText
     * @return Command
     * @throws Exception
     */
    public function make(string $commandText): Command
    {
        $commandArray = explode(' ', trim($commandText));
        $commandType = strtoupper($commandArray[0]);

        return match ($commandType) {
            'PLACE'  => new Placer($this->board, $commandText),
            'LEFT'   => new Rotater($this->board, RotationDirection::LEFT, $this->toyRobot),
            'RIGHT'  => new Rotater($this->board, RotationDirection::RIGHT, $this->toyRobot),
            'MOVE'   => new Mover($this->board, $commandText, $this->toyRobot),
            'REPORT' => new Reporter($this->board, $commandText),
            'EXIT'   => new Exiter($this->board, $commandText),
            default  => throw new Exception("Command type not found: {$commandType}")
        };
    }
}
