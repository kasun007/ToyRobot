<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Board;
use App\Router  ;

$board = new Board();
$router = new Router($board);

echo "Toy Robot Simulator\n";
echo "Commands: PLACE X,Y,F | MOVE | LEFT | RIGHT | REPORT | EXIT\n\n";

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
    
    $router->followCommands($command);
}

?>