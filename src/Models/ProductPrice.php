<?php

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
     * @return int
     */
    public function value(): int{
        return $this->value;
    }

}