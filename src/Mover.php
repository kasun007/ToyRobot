<?php


namespace App;
class Mover implements Command
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

        $x = $placement['x'];
        $y = $placement['y'];
        $facing = $placement['facing'];

        switch ($facing) {
            case 'NORTH':
                $y++;
                break;
            case 'SOUTH':
                $y--;
                break;
            case 'EAST':
                $x++;
                break;
            case 'WEST':
                $x--;
                break;
        }

        $this->board->placeRobot($x, $y, $facing);
    }
}
?>