<?php

namespace App\Models;

use Webmozart\Assert\Assert;

/**
 * @Class Price
 */
final class Price
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
        Assert::greaterThanEq($value, 0);
        $this->value = $value;
    }

    /**
     * @param DiscountPercentage $discountPercentage
     * @return Price
     */
    public function withDiscountApplied(DiscountPercentage $discountPercentage): Price
    {
        $discount = round(($discountPercentage->percentage() / 100) * $this->value);
        return new Price($this->value - $discount);
    }

    /**
     * @param Price $price
     * @return Price
     */
    public function withAdding(Price $price): Price
    {
        return new Price($this->value + $price->value);
    }


    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }


}