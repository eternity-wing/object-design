<?php

namespace App\Entity;

use App\Models\ItemQuantity;
use App\Models\Price;

/**
 * @Class OrderItem
 */
final class OrderItem
{
    /**
     * @var ProductPack
     */
    private ProductPack $pack;
    /**
     * @var ItemQuantity
     */
    private ItemQuantity $quantity;

    /**
     * @param ProductPack $productPack
     * @param ItemQuantity $quantity
     */
    public function __construct(ProductPack $productPack, ItemQuantity $quantity)
    {
        $this->pack = $productPack;
        $this->quantity = $quantity;
    }

    /**
     * @return void
     */
    public function increment(): void
    {
        $this->quantity = $this->quantity->incremented();
    }

    /**
     * @return void
     */
    public function decrement(): void
    {
        $this->quantity = $this->quantity->decremented();
    }

    /**
     * @return Price
     */
    public function totalPrice(): Price
    {
        return new Price($this->pack->totalPrice()->value() * $this->quantity->value());
    }

    /**
     * @return ProductPack
     */
    public function pack(): ProductPack
    {
        return $this->pack;
    }

    /**
     * @return ItemQuantity
     */
    public function quantity(): ItemQuantity
    {
        return $this->quantity;
    }
}