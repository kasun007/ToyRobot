<?php
namespace App\Command;
use App\Exceptions\ReporterException;
use App\Command\Command;
use App\Models\Board;
class Reporter implements Command
{
    private Board $board;
    private string $command;

    public function __construct(Board $board, string $command)
    {
        $this->board = $board;
        $this->command = $command;
    }

    public function execute() :string
    {
        $placement = $this->board->getRobotPlaced();

        

       return "Output: {$placement['x']},{$placement['y']},{$placement['facing']}";
    }
}
?>