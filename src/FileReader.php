<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Board;
use App\Command\CommandFactory;
use App\Exceptions\BoardException;
use App\Models\ToyRobot;
use App\Services\RotationService;

$board = new Board();

$toyRobot = new ToyRobot($board);
$factory = new CommandFactory($board, $toyRobot);
$commands = file(__DIR__ . '/../commands.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($commands as $lineNumber => $commandText) {
    try {
        $commandText = trim($commandText);
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
