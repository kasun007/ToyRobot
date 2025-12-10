<?php

use App\Board;
use App\Router  ;





it('check PLACE command', function () {
    $board = new Board();
    $commands = 'PLACE 0,0,NORTH';
    $router = new Router($board);
    
    expect($router->followCommands($commands))->toBe("0, 0, NORTH");
});



it('check REPORT command', function () {
    $board = new Board();
    
    $router = new Router($board);
    $command = 'PLACE 0,0,NORTH';
    $router->followCommands($command);
    $command2 = 'REPORT';
    
    expect($router->followCommands($command2))->toBe("0, 0, NORTH");
});


it('check LEFT command', function () {
    $board = new Board();
    
    $router = new Router($board);
    $command = 'PLACE 0,0,NORTH';
    $router->followCommands($command);
    $router->followCommands("LEFT");
    $command2 = 'REPORT';
    
    expect($router->followCommands($command2))->toBe("0, 0, WEST");
});


it('check INVALID command', function () {
    $board = new Board();
    
    $router = new Router($board);
    $command = 'PLACE 0,0,NORTH';
    $router->followCommands($command);
    $router->followCommands("LEFT");
    $command2 = 'INVALID';
    
    expect($router->followCommands($command2))->toBe("INCORRECT COMMAND");
});


?>