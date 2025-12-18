<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Board;
use App\CommandFactory;
use App\Exceptions\BoardException;

$board = new Board();
$factory = new CommandFactory($board);

echo "Welcome to Toy Robot Simulator!\n";
echo "Type commands (PLACE, MOVE, LEFT, RIGHT, REPORT) or EXIT to quit.\n\n";

while (true) {
    echo "> ";
    $commandText = trim(fgets(STDIN));

    if ($commandText === '') {
        continue;
    }



    try {
        $command = $factory->make($commandText);
        $command = $factory->make($commandText);
        echo $command->execute();
    } catch (BoardException $e) {
        echo "Board Error: " . $e->getMessage() . PHP_EOL;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . PHP_EOL;
    }
}
