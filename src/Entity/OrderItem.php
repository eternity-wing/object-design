<?php

namespace App\Entity;

use App\Models\ItemQuantity;
use App\Models\ProductPrice;

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
     * @return ProductPrice
     */
    public function totalPrice(): ProductPrice
    {
        return new ProductPrice($this->pack->totalPrice()->value() * $this->quantity->value());
    }

}