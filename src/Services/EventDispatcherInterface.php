<?php

namespace App\Services;

use App\Event\ListenableInterface;

interface EventDispatcherInterface
{
    /**
     * @param ListenableInterface $event
     * @return void
     */
    public function dispatch(ListenableInterface $event): void;
}