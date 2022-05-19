<?php

namespace App\EventListener;

use App\Entity\Product;
use App\Event\ListenableInterface;
use App\Event\NewProductEvent;
use Webmozart\Assert\Assert;

/**
 * @Class NewProductListener
 */
final class NewProductListener implements EventListenerInterface
{
    /**
     * @param ListenableInterface $event
     * @return void
     */
    public function listen(ListenableInterface $event): void
    {
        Assert::isInstanceOf($event, NewProductEvent::class);
        /**
         * @var Product $product
         */
        $product = $event->payload();
        echo "NewProductListener: product $product\n";
    }
}