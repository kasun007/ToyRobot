<?php

namespace App;



class Board
{
    private ?array $robotPlacement = null;
    private int $width;
    private int $height;

    function __construct(int $width = 5, int $height = 5)
    {
        $this->width = $width;
        $this->height = $height;
    }

    function getRobotPlaced(): ?array
    {
        return $this->robotPlacement;
    }

    function isOutOfBounds(int $x, int $y): bool
    {
        return $x < 0 || $x >= $this->width || $y < 0 || $y >= $this->height;
    }

    function placeRobot(int $x, int $y, string $facing): bool
    {
        // Check if out of bounds
        if ($this->isOutOfBounds($x, $y)) {
            return false;  // Invalid placement
        }

        $this->robotPlacement = [
            'x' => $x,
            'y' => $y,
            'facing' => $facing
        ];

        return true;  // Successfully placed
    }

    function setRobotPlacement(array $placement): void
    {
        $this->robotPlacement = $placement;
    }

    function getBoardSize(): array
    {
        return [
            'width' => $this->width,
            'height' => $this->height
        ];
    }
}


enum Direction: string
{
    case NORTH = 'NORTH';
    case EAST = 'EAST';
    case SOUTH = 'SOUTH';
    case WEST = 'WEST';
}

interface RouterInterface
{
    public function followCommands(string $command): string;
    public function report(): string;
}

class Router implements RouterInterface
{
    private Board $board;

    public function __construct(Board $board)
    {
        $this->board = $board;
    }


    /**
     * Get the board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * Execute all commands in sequence
     */
    public function followCommands(string $command): string
    {
        if ($command === null || empty($command)) {
            return "";
        }

        // Split the string into individual commands
        $commands = explode("\n", $command);

        foreach ($commands as $singleCommand) {
            $singleCommand = trim($singleCommand);

            // Check if it's a PLACE command
            if (strpos($singleCommand, 'PLACE') === 0) {
                $parts = explode(' ', $singleCommand);
                $params = explode(',', $parts[1]);
                $x = (int)$params[0];
                $y = (int)$params[1];
                $direction = trim($params[2]);

                $this->board->placeRobot($x, $y, $direction);
                return    implode(', ', $this->board->getRobotPlaced());
            } elseif ($singleCommand === 'REPORT') {
                return  $this->report() ;
            } elseif ($singleCommand === 'MOVE') {
                return $this->moveForward();
            } elseif ($singleCommand === 'LEFT') {
                $placement = $this->board->getRobotPlaced();
                if ($placement !== null) {
                    $newFacing = $this->rotateLeft($placement['facing']);
                    $this->board->placeRobot(
                        $placement['x'],
                        $placement['y'],
                        $newFacing
                    );
                }


                return    implode(', ', $this->board->getRobotPlaced());
            } elseif ($singleCommand === 'RIGHT') {
                $placement = $this->board->getRobotPlaced();

                if ($placement !== null) {
                    $newFacing = $this->rotateRight($placement['facing']);
                    $this->board->placeRobot(
                        $placement['x'],
                        $placement['y'],
                        $newFacing
                    );
                }


                return    implode(', ', $this->board->getRobotPlaced());
            }
        }

        return   "INCORRECT COMMAND";
    }





    /**
     * Report the current state
     */
    function report(): string
    {
        // Return current robot position and direction
        return  implode(', ', $this->board->getRobotPlaced());
    }


    /**
     * Rotate the robot left (counter-clockwise)
     */
    private function rotateLeft(string $currentFacing): string
    {
        $rotations = [
            'NORTH' => 'WEST',
            'WEST' => 'SOUTH',
            'SOUTH' => 'EAST',
            'EAST' => 'NORTH'
        ];

        return $rotations[$currentFacing] ?? $currentFacing;
    }


    /**
     * Rotate the robot right (clockwise)
     */
    private function rotateRight(string $currentFacing): string
    {
        $rotations = [
            'NORTH' => 'EAST',
            'EAST' => 'SOUTH',
            'SOUTH' => 'WEST',
            'WEST' => 'NORTH'
        ];

        return $rotations[$currentFacing] ?? $currentFacing;
    }


    private function moveForward(): string
    {
        $placement = $this->board->getRobotPlaced();

        if ($placement === null) {
            return ""; // Robot not placed yet
        }

        $x = $placement['x'];
        $y = $placement['y'];
        $facing = $placement['facing'];

        // Calculate new position based on facing direction
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

        // Only move if the new position is valid
        $this->board->placeRobot($x, $y, $facing);
        return   implode(', ', $this->board->getRobotPlaced());
    }
}
