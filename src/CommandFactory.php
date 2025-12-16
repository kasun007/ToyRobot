<?php

namespace App;

use App\Board;
use App\Placer;
use App\Mover;
use App\Left;
use App\Right;
use App\Reporter;
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
            'LEFT'   => new Left($this->board, $commandText),
            'RIGHT'  => new Right($this->board, $commandText),
            'MOVE'   => new Mover($this->board, $commandText),
            'REPORT' => new Reporter($this->board, $commandText),
            default  => throw new Exception("Command type not found: {$commandType}")
        };
    }
}
