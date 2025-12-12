<?php

namespace App;
class Placer implements Command
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
        $parts = explode(' ', $this->command);

      
        if (!isset($parts[1])) {
            echo "Error: PLACE command requires parameters (e.g., PLACE 0,0,NORTH)\n";
            return;
        }

        $params = explode(',', $parts[1]);

        if (count($params) < 3) {
            echo "Error: PLACE requires X,Y,DIRECTION\n";
            return;
        }

        $x = (int)$params[0];
        $y = (int)$params[1];
        $direction = strtoupper(trim($params[2]));

        $this->board->placeRobot($x, $y, $direction);
    }
}

?>
