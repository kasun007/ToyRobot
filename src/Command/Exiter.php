<?php

namespace App\Command;

use App\Command\Command;
use App\Models\Board;
use App\Exceptions\ExiterException;

class Exiter implements Command
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

        exit(0);
    }
}
