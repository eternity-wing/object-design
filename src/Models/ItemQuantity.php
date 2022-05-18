<?php

namespace App\Models;

use Webmozart\Assert\Assert;

/**
 * @Class ItemQuantity
 */
final class ItemQuantity
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
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @return ItemQuantity
     */
    public function incremented(): ItemQuantity
    {
        return new ItemQuantity($this->value + 1);
    }

    /**
     * @return ItemQuantity
     */
    public function decremented(): ItemQuantity
    {
        return new ItemQuantity($this->value - 1);
    }
}