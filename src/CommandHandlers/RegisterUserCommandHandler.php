<?php namespace Neychang\Microapp\CommandHandlers;

use Neychang\Microapp\Commands\RegisterUser;
use Neychang\Microapp\Events\UserRegistered;
use Neychang\Microapp\App;

class RegisterUserCommandHandler {


    public function handle(RegisterUser $command)
    {

    	var_dump($command);
        
        App::make('eventBus')->handle(new UserRegistered(1));

    }
}

