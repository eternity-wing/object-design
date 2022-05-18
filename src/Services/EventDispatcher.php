<?php

namespace App\Services;

use App\Event\ListenableInterface;
use App\EventListener\EventListenerInterface;
use Webmozart\Assert\Assert;

/**
 * @Class EventDispatcher
 */
final class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var EventListenerInterface[]
     */
    private array $listeners;

    /**
     * @var EventListenerInterface[]|array
     */
    public function __construct(array $listeners)
    {
        Assert::allIsInstanceOf(array_values($listeners), EventListenerInterface::class);
        foreach ($listeners as $listenerKey => $listener){
            Assert::string($listenerKey);
            $this->listeners[$listenerKey] = $listener;
        }
    }

    /**
     * @param ListenableInterface $event
     * @return void
     */
    public function dispatch(ListenableInterface $event): void
    {
        if(isset($this->listeners[$event->listenerKey()])){
            $this->listeners[$event->listenerKey()]->listen($event);
        }
    }

}