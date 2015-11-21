<?php

return [
	'Neychang\Microapp\Events\UserRegistered' => [
		['Neychang\Microapp\EventSubscribers\SendWelcomeMailWhenUserRegistered', 'notify']
	]
];