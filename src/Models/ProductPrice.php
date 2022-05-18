<?php

namespace App\Models;

use Webmozart\Assert\Assert;

/**
 * @Class ProductPrice
 */
final class ProductPrice
{
    /**
     * @var int
     */
    private int $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::greaterThan($value, 0);
        $this->value = $value;
    }

    /**
     * @param DiscountPercentage $discountPercentage
     * @return ProductPrice
     */
    public function withDiscountApplied(DiscountPercentage $discountPercentage): ProductPrice
    {
        $discount = (int)round($discountPercentage / 100) * $this->value;
        return new ProductPrice($this->value - $discount);
    }

    /**
     * @param ProductPrice $price
     * @return ProductPrice
     */
    public function withAdding(ProductPrice $price): ProductPrice
    {
        return new ProductPrice($this->value + $price->value);
    }


    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }


}