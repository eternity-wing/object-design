<?php

namespace App\Entity;

use App\Exception\NotFoundException;
use App\Models\ProductPrice;
use App\Models\UUID;
use Exception;

/**
 * @Class Order
 */
final class Order
{
    /**
     * @var UUID
     */
    private UUID $userId;
    /**
     * @var OrderItem[]
     */
    private array $items;

    /**
     * @param UUID $userId
     */
    public function __construct(UUID $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param Product $product
     * @return void
     * @throws Exception
     */
    public function addProduct(Product $product): void
    {
        if (!isset($this->items[$product->id()->value()])) {
            $this->items[$product->id()->value()] = new ProductPack($product->id(), [$product]);
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
            $this->items[$productPack->id()->value()] = $productPack;
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
    public function incrementItemQuantity(UUID $id): void
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
    public function decrementItemQuantity(UUID $id): void
    {
        if (!isset($this->items[$id->value()])) {
            throw new NotFoundException();
        }
        $this->items[$id->value()]->decrement();
    }

    /**
     * @return int
     */
    public function totalPrice(): int{
        $price = new ProductPrice(0);
        foreach ($this->items as $item){
            $price = $price->withAdding($item->totalPrice());
        }
        return $price->value();
    }

    /**
     * @return OrderItem[]
     */
    public function items(): array{
        return $this->items;
    }
}