<?php 
namespace App;
class Left implements Command
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

        $rotations = [
            'NORTH' => 'WEST',
            'WEST' => 'SOUTH',
            'SOUTH' => 'EAST',
            'EAST' => 'NORTH'
        ];

        $newFacing = $rotations[$placement['facing']] ?? $placement['facing'];
        $this->board->placeRobot($placement['x'], $placement['y'], $newFacing);
    }
}

?>