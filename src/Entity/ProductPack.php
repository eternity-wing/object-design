<?php

namespace App\Entity;

use App\Models\DiscountPercentage;
use App\Models\Price;
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
    private ?DiscountPercentage $discount = null;

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
     * @param UUID $id
     * @param array $products
     * @param DiscountPercentage $discount
     * @return ProductPack
     */
    public static function withDiscount(UUID $id, array $products, DiscountPercentage $discount): ProductPack
    {
        $pack = new ProductPack($id, $products);
        $pack->discount = $discount;
        return $pack;
    }

    /**
     * @return Price
     */
    public function totalPrice(): Price
    {
        return $this->discount ? $this->totalPriceByBasketDiscount() : $this->totalPriceByUnitsDiscount();
    }

    /**
     * @return Price
     */
    private function totalPriceByBasketDiscount(): Price
    {
        $price = new Price(0);
        foreach ($this->products as $product) {
            $price = $price->withAdding($product->price());
        }
        return $price->withDiscountApplied($this->discount);
    }

    /**
     * @return Price
     */
    private function totalPriceByUnitsDiscount(): Price
    {
        $totalPrice = new Price(0);
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

    /**
     * @return DiscountPercentage|null
     */
    public function discount(): ?DiscountPercentage
    {
        return $this->discount;
    }

    /**
     * @return array|Product[]
     */
    public function products(): array
    {
        return $this->products;
    }

}