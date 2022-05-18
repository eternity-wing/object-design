<?php

namespace App\Event;

use App\Entity\Product;

/**
 * @Class NewProductEvent
 */
final class NewProductEvent implements ListenableInterface
{
    public const LISTENER_KEY = 'new-product';
    /**
     * @var Product
     */
    private Product $payload;

    /**
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->payload = $product;
    }

    /**
     * @return Product|mixed
     */
    public function payload()
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function listenerKey(): string
    {
        return self::LISTENER_KEY;
    }
}