<?php

namespace App\Event;

interface ListenableInterface
{
    /**
     * @return string
     */
    public function listenerKey(): string;

    /**
     * @return mixed
     */
    public function payload();
}