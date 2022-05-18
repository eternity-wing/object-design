<?php

namespace App\EventListener;

use App\Event\ListenableInterface;

interface EventListenerInterface
{
    /**
     * @param ListenableInterface $event
     * @return void
     */
    public function listen(ListenableInterface $event):void;
}