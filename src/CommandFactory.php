<?php

namespace App;

use App\Models\Board;
use App\Command\Placer;
use App\Command\Rotater;
use App\Command\Mover;
use App\Command\Reporter;       
use App\Command\Exiter;
use App\Command\Command;
use Exception;

class CommandFactory
{
    private Board $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
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
            'LEFT'   => new Rotater($this->board, 'LEFT'),
            'RIGHT'  => new Rotater($this->board, 'RIGHT'),
            'MOVE'   => new Mover($this->board, $commandText),
            'REPORT' => new Reporter($this->board, $commandText),
            'EXIT'   => new Exiter($this->board, $commandText),
            default  => throw new Exception("Command type not found: {$commandType}")
        };
    }
}
