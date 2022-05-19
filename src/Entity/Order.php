<?php

namespace App\Entity;

use App\Exception\NotFoundException;
use App\Models\ItemQuantity;
use App\Models\Price;
use App\Models\UUID;
use Exception;

/**
 * @Class Order
 */
final class Order
{
    /**
     * @var OrderItem[]
     */
    private array $items;


    /**
     * @param Product $product
     * @return void
     * @throws Exception
     */
    public function addProduct(Product $product): void
    {
        if (!isset($this->items[$product->id()->value()])) {
            $this->items[$product->id()->value()] = new OrderItem(new ProductPack($product->id(), [$product]), new ItemQuantity(0));
        }
        $this->incrementItemQuantity($product->id());
    }

    /**
     * @param ProductPack $productPack
     * @return void
     * @throws Exception
     */
    public function addProductPack(ProductPack $productPack): void
    {
        if (!isset($this->items[$productPack->id()->value()])) {
            $this->items[$productPack->id()->value()] = new OrderItem($productPack, new ItemQuantity(0));
        }
        $this->incrementItemQuantity($productPack->id());
    }

    /**
     * @param UUID $id
     * @return void
     */
    public function removeItem(UUID $id): void
    {
        if (isset($this->items[$id->value()])) {
            unset($this->items[$id->value()]);
        }
    }

    /**
     * @param UUID $id
     * @return void
     */
    private function incrementItemQuantity(UUID $id): void
    {
        if (!isset($this->items[$id->value()])) {
            throw new NotFoundException();
        }
        $this->items[$id->value()]->increment();
    }

    /**
     * @param UUID $id
     * @return void
     */
    private function decrementItemQuantity(UUID $id): void
    {
        if (!isset($this->items[$id->value()])) {
            throw new NotFoundException();
        }
        $this->items[$id->value()]->decrement();
    }

    /**
     * @return int
     */
    public function totalPrice(): int
    {
        $price = new Price(0);
        foreach ($this->items as $item) {
            $price = $price->withAdding($item->totalPrice());
        }
        return $price->value();
    }

    /**
     * @return OrderItem[]
     */
    public function items(): array
    {
        return $this->items;
    }
}