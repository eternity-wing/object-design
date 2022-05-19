<?php

namespace App\Models;

use Webmozart\Assert\Assert;

/**
 * @Class ProductTitle
 */
final class ProductTitle
{
    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

}