<?php
namespace App\Models;
use App\Exceptions\ReporterException;
use App\Command\Command;
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

        if ($placement === null) {
            throw new ReporterException(
                'Robot is not placed on the board',
                1301,
                ['command' => $this->command]
            );
            return "";
        }

       return "Output: {$placement['x']},{$placement['y']},{$placement['facing']}";
    }
}
?>