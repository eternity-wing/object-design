<?php

namespace App\Entity;

use App\Models\DiscountPercentage;
use App\Models\ProductPrice;
use App\Models\UUID;
use Webmozart\Assert\Assert;

/**
 * @Class ProductPack
 */
final class ProductPack
{
    private const MIN_PACK_SIZE = 1;

    /**
     * @var UUID
     */
    private UUID $id;
    /**
     * @var Product[]
     */
    private array $products;
    /**
     * @var DiscountPercentage | null
     */
    private ?DiscountPercentage $discount;

    /**
     * @param array $products
     */
    public function __construct(UUID $id, array $products)
    {
        Assert::minCount($products, self::MIN_PACK_SIZE);
        Assert::allIsInstanceOf($products, Product::class);
        $this->id = $id;
        $this->products = $products;
    }

    /**
     * @param array $products
     * @param DiscountPercentage $discount
     * @return ProductPack
     */
    public static function withDiscount(array $products, DiscountPercentage $discount): ProductPack
    {
        $pack = new ProductPack(UUID::generate(), $products);
        $pack->discount = $discount;
        return $pack;
    }

    /**
     * @return ProductPrice
     */
    public function totalPrice(): ProductPrice
    {
        return $this->discount ? $this->totalPriceByBasketDiscount() : $this->totalPriceByUnitsDiscount();
    }

    /**
     * @return ProductPrice
     */
    private function totalPriceByBasketDiscount(): ProductPrice
    {
        $price = new ProductPrice(0);
        foreach ($this->products as $product) {
            $price = $price->withAdding($product->price());
        }
        return $price->withDiscountApplied($this->discount);
    }

    /**
     * @return ProductPrice
     */
    private function totalPriceByUnitsDiscount(): ProductPrice
    {
        $totalPrice = new ProductPrice(0);
        foreach ($this->products as $product) {
            $totalPrice = $totalPrice->withAdding($product->price()->withDiscountApplied($product->discount()));
        }
        return $totalPrice;
    }

    /**
     * @return UUID
     */
    public function id(): UUID
    {
        return $this->id;
    }
}