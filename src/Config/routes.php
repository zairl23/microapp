<?php
 return array(
    "/" => function() {
        echo 'hello';
    },
    'user/register' => function() use ($app) {
        $command = new \Neychang\Microapp\Commands\RegisterUser(
            'matthiasnoback@gmail.com',
            's3cr3t'
        );
        $app->container['commandBus']->handle($command);
    }
);