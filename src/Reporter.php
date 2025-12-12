<?php
namespace App;
class Reporter implements Command
{
    private Board $board;
    private string $command;

    public function __construct(Board $board, string $command)
    {
        $this->board = $board;
        $this->command = $command;
    }

    public function execute()
    {
        $placement = $this->board->getRobotPlaced();

        if ($placement === null) {
            echo "Error: Robot not placed yet\n";
            return;
        }

        echo "Output: " . implode(', ', $placement) . "\n";
    }
}
?>