<?php namespace Neychang\Microapp\EventSubscribers;

class SendWelcomeMailWhenUserRegistered {

	public function notify($message)
    {
       	var_dump($message);

        // send the welcome mail
    }

}