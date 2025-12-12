<?php
require_once __DIR__ . '/../vendor/autoload.php';


use App\Board;
use App\Command;
use App\Mover;
use App\Placer;
use App\Left;
use App\Right;
use App\Reporter;

$board = new Board();

function create($board, $command)  
{
    $commandArray = explode(' ', trim($command));
 
    $commandType = $commandArray[0];
 
    switch ($commandType) {
        case 'PLACE':
            return new Placer($board, $command);
        case 'LEFT':
            return new Left($board, $command);   
        case 'RIGHT':
            return new Right($board, $command);   
        case 'MOVE':
            return new Mover($board, $command);  
        case 'REPORT':
            return new Reporter($board, $command);  

        default:
            throw new Exception("Command type not found");
    }
}

while (true) {
    echo "> ";
    $command = trim(fgets(STDIN));

    if ($command === 'EXIT' || $command === 'exit') {
        echo "Goodbye!\n";
        break;
    }

    if (empty($command)) {
        continue;
    }

    try {
        
           $handler = create($board, $command);
             
             $handler->execute();
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
