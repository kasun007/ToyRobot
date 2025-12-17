<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Board;
 
use App\CommandFactory;
use App\Exceptions\BoardException;

 
$board = new Board();
$factory = new CommandFactory($board);
 

$commands = file(__DIR__ . '/../commands.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($commands as $lineNumber => $commandText) {
    try {
        $commandText = trim($commandText);

        // Skip comments
        if ($commandText === '' || str_starts_with($commandText, '#')) {
            continue;
        }

         $command = $factory->make($commandText);
        echo $command->execute();

    } catch (BoardException $e) {
        echo "Error on line " . ($lineNumber + 1) . ": " . $e->getMessage() . PHP_EOL;
    } catch (Throwable $e) {
        echo "Unexpected error: " . $e->getMessage() . PHP_EOL;
    }
}
