<?php

namespace App\Services;

interface EventListenerInterface
{
    /**
     * @param $payload
     * @return void
     */
    public function listen($payload):void;
}