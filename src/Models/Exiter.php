<?php

namespace App\Models;

use App\Command\Command;
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
        $placement = $this->board->getRobotPlaced();

        if ($placement === null) {
            throw new ExiterException(
                'Robot is not placed on the board',
                1302,
                ['command' => $this->command]
            );
        }

         

        

        exit(0);
    }
}