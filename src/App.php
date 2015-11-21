<?php namespace Neychang\Microapp;

use Neychang\Microapp\Container\Container;
use Toro;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\CallableResolver\CallableCollection;
use SimpleBus\Message\Subscriber\Resolver\NameBasedMessageSubscriberResolver;
use SimpleBus\Message\Subscriber\NotifiesMessageSubscribersMiddleware;

class App {


	public function __construct()
	{
		$this->container = Container::getInstance();
	}

	public function run($handlers, $subscribers)
	{
		$this->registerCommandBus($handlers);
		$this->registerEventBus($subscribers);
	}

	public static function make($serviceName)
	{
		$instance = new static;

		return $instance->container[$serviceName];
	}

	protected function registerCommandBus($handlers)
	{
		$this->container['commandBus'] = function ($c) use ($handlers) {
		    $commandBus = new MessageBusSupportingMiddleware();
			$commandBus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());
		    
		    // Provide a map of command names to callables. You can provide actual callables, or lazy-loading ones.
		    $commandHandlersByCommandName = $handlers;

		    // Provide a service locator callable. It will be used to instantiate a handler service whenever requested.
		    $serviceLocator = function ($serviceId) {
		        //$handler = new $serviceId($c);

		        //return $handler->handle();
		    };

		    $commandHandlerMap = new CallableMap(
		        $commandHandlersByCommandName,
		        new ServiceLocatorAwareCallableResolver($serviceLocator)
		    );

		    $commandNameResolver = new ClassBasedNameResolver();
		    $commandHandlerResolver = new NameBasedMessageHandlerResolver(
		        $commandNameResolver,
		        $commandHandlerMap
		    );

		    $commandBus->appendMiddleware(
		        new DelegatesToMessageHandlerMiddleware(
		            $commandHandlerResolver
		        )
		    );

			return $commandBus;
		};

		$registeredServices[] = 'commandBus';
	}

	protected function registerEventBus($subscribers)
	{
		$this->container['eventBus'] = function($c) use ($subscribers) {
		    $eventBus = new MessageBusSupportingMiddleware();
		    $eventBus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());

		    // Provide a map of event names to callables. You can provide actual callables, or lazy-loading ones.
		    $eventSubscribersByEventName = $subscribers;


		    // Provide a service locator callable. It will be used to instantiate a subscriber service whenever requested.
		    $serviceLocator = function ($serviceId) {
		        // $handler = new $serviceId();

		        // return $handler->notify();
		    };

		    $eventSubscriberCollection = new CallableCollection(
		        $eventSubscribersByEventName,
		        new ServiceLocatorAwareCallableResolver($serviceLocator)
		    );

		    $eventNameResolver = new ClassBasedNameResolver();

		    $eventSubscribersResolver = new NameBasedMessageSubscriberResolver(
		        $eventNameResolver,
		        $eventSubscriberCollection
		    );

		    $eventBus->appendMiddleware(
		        new NotifiesMessageSubscribersMiddleware(
		            $eventSubscribersResolver
		        )
		    );

		    return $eventBus;
		};

		$registeredServices[] = 'eventBus';
	}
}