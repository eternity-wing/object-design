<?php

/**
 * @Class Product
 */
final class Product
{
    /**
     * @var ProductTitle
     */
    private ProductTitle $title;
    /**
     * @var ProductPrice
     */
    private ProductPrice $price;
    /**
     * @var DiscountPercentage
     */
    private DiscountPercentage $discount;

    /**
     * @var array
     */
    private array $events;

    /**
     * @param ProductTitle $title
     * @param ProductPrice $price
     * @param DiscountPercentage $discount
     */
    public function __construct(ProductTitle $title, ProductPrice $price, DiscountPercentage $discount)
    {
        $this->title = $title;
        $this->price = $price;
        $this->discount = $discount;
        $this->events = [$title, $price, $discount];
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = new ProductTitle($title);
        $this->events[] = $this->title;
    }

    /**
     * @param int $price
     * @return void
     */
    public function setPrice(int $price): void
    {
        $this->price = new ProductPrice($price);
        $this->events[] = $this->price;
    }

    /**
     * @param int $discount
     * @return void
     */
    public function setDiscount(int $discount): void
    {
        $this->discount = new DiscountPercentage($discount);
        $this->events[] = $this->discount;
    }

    /**
     * @return array
     */
    public function events(): array
    {
        return $this->events;
    }

}