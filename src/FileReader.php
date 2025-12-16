<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Board;
use App\CommandFactory;
use App\Exceptions\BoardException;

$board = new Board();
$factory = new CommandFactory($board);

$commands = file(__DIR__ . '/../commands.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($commands as $lineNumber => $commandText) {
    try {
        $command = $factory->make($commandText);
        $command->execute();
    } catch (BoardException $e) {
        echo "Error on line " . ($lineNumber + 1) . ": " . $e->getMessage() . PHP_EOL;
    } catch (Exception $e) {
        echo "Unknown error: " . $e->getMessage() . PHP_EOL;
    }
}
