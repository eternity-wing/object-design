<?php

use Webmozart\Assert\Assert;

/**
 * @Class ProductTitle
 */
final class ProductTitle
{
    /**
     * @var string
     */
    private string $title;

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        Assert::notEmpty($title);
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function title(): string{
        return $this->title;
    }

}