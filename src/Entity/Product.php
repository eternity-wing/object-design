<?php

namespace App\Entity;

use App\Event\NewProductEvent;
use App\Models\Price;
use App\Models\ProductTitle;
use App\Models\DiscountPercentage;
use App\Models\UUID;

/**
 * @Class Product
 * TODO: it might be a good Idea to provide a ReadModel for products instead of exposing it's fields.
 */
final class Product
{
    /**
     * @var UUID
     */
    private UUID $id;
    /**
     * @var ProductTitle
     */
    private ProductTitle $title;
    /**
     * @var Price
     */
    private Price $price;
    /**
     * @var DiscountPercentage
     */
    private DiscountPercentage $discount;

    /**
     * @var array
     */
    private array $events;

    /**
     * @param UUID $id
     * @param ProductTitle $title
     * @param Price $price
     * @param DiscountPercentage $discount
     */
    public function __construct(UUID $id, ProductTitle $title, Price $price, DiscountPercentage $discount)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->discount = $discount;
        $this->events[] = new NewProductEvent($this);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf("id:%4s title:%4s price:%d discount:%d",
            $this->id->value(),
            $this->title->value(),
            $this->price->value(),
            $this->discount->percentage()
        );
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = new ProductTitle($title);
    }

    /**
     * @param int $price
     * @return void
     */
    public function setPrice(int $price): void
    {
        $this->price = new Price($price);
    }

    /**
     * @param int $discount
     * @return void
     */
    public function setDiscount(int $discount): void
    {
        $this->discount = new DiscountPercentage($discount);
    }

    /**
     * @return array
     */
    public function events(): array
    {
        return $this->events;
    }

    /**
     * @return array
     */
    public function clearEvents(): array
    {
        return $this->events = [];
    }

    /**
     * @return Price
     */
    public function price(): Price
    {
        return $this->price;
    }

    /**
     * @return DiscountPercentage
     */
    public function discount(): DiscountPercentage
    {
        return $this->discount;
    }

    /**
     * @return ProductTitle
     */
    public function title(): ProductTitle
    {
        return $this->title;
    }

    /**
     * @return UUID
     */
    public function id(): UUID
    {
        return $this->id;
    }
}