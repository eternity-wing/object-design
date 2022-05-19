<?php

namespace App\Models;

use Webmozart\Assert\Assert;

/**
 * @Class DiscountPercentage
 */
final class DiscountPercentage
{
    private const DEFAULT_PERCENTAGE = 0;

    private const MIN_PERCENTAGE = 0;
    private const MAX_PERCENTAGE = 100;

    /**
     * @var int
     */
    private int $percentage;

    /**
     * @param int $percentage
     */
    public function __construct(int $percentage)
    {
        Assert::greaterThanEq($percentage, self::MIN_PERCENTAGE);
        Assert::lessThanEq($percentage, self::MAX_PERCENTAGE);
        $this->percentage = $percentage;
    }

    /**
     * @return DiscountPercentage
     */
    public static function withDefaultValue(): DiscountPercentage
    {
        return new DiscountPercentage(self::DEFAULT_PERCENTAGE);
    }

    /**
     * @return int
     */
    public function percentage(): int
    {
        return $this->percentage;
    }

}