<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\ProductPack;
use App\Event\NewProductEvent;
use App\EventListener\NewProductListener;
use App\Models\DiscountPercentage;
use App\Models\Price;
use App\Models\ProductTitle;
use App\Models\UUID;
use App\Services\EventDispatcher;
use Webmozart\Assert\Assert;

class Console
{

    public function runOrderScenario(): void
    {
        $products = $this->defaultProducts();
        echo "Products list before update\n";
        $this->printProducts($products);
        echo "*************************************************************************************\n";
        echo "*************************************************************************************\n";
        echo "*************************************************************************************\n";

        $products[] = $this->newProduct("Coca", 5000, 5);
        $products[] = $this->newProduct("Lemonade", 1700, 5);
        $products[] = $this->newProduct("Pepsi", 2230, 5);


        echo "*************************************************************************************\n";
        echo "*************************************************************************************\n";
        echo "*************************************************************************************\n";

        $products[0]->setPrice(700);
        $products[0]->setTitle("edited Product");
        $products[0]->setDiscount(8);

        echo "Products list after update\n";
        $this->printProducts($products);

        echo "*************************************************************************************\n";
        echo "*************************************************************************************\n";
        echo "*************************************************************************************\n";


        $pack1 = new ProductPack(UUID::generate(), [$products[0], $products[2], $products[4]]);
        $pack2 = ProductPack::withDiscount(UUID::generate(), [$products[1], $products[5]], new DiscountPercentage(14));
        $this->printPacks([$pack1, $pack2]);
        echo "*************************************************************************************\n";
        echo "*************************************************************************************\n";
        echo "*************************************************************************************\n";


        $order = new Order();
        $order->addProduct($products[0]);
        $order->addProduct($products[0]);
        $order->addProduct($products[3]);
        $order->addProductPack($pack1);
        $order->addProductPack($pack2);
        $order->addProductPack($pack2);

        echo "Order Total Price: {$order->totalPrice()}\n";
        $this->printOrderedItems($order->items());

    }

    /**
     * @return Product[]
     */
    private function defaultProducts(): array
    {
        $productsArray = [
            ["title" => "product-1", "price" => 10000, "discount" => 25],
            ["title" => "product-2", "price" => 20000, "discount" => 17],
            ["title" => "product-3", "price" => 15000, "discount" => 32],
            ["title" => "product-4", "price" => 25000, "discount" => 9],
            ["title" => "product-5", "price" => 30000, "discount" => 11],
        ];

        return array_map(static function ($productArray): Product {
            [$title, $price, $discount] = array_values($productArray);
            return new Product(UUID::generate(), new ProductTitle($title), new Price($price), new DiscountPercentage($discount));
        }, $productsArray);

    }

    /**
     * @param Product[] $products
     * @return void
     */
    private function printProducts(array $products): void
    {
        if (count($products) === 0) {
            echo "Products list is empty\n";
            return;
        }
        echo "Products List:\n";
        foreach ($products as $product) {
            echo "{$product}\n";
        }
        echo "\n";
    }

    /**
     * @param OrderItem[] $items
     * @return void
     */
    private function printOrderedItems(array $items): void
    {
        if (count($items) === 0) {
            echo "Ordered items list is empty\n";
            return;
        }
        echo "Ordered Items List:\n";
        foreach ($items as $uuid => $item) {
            echo "Item: ID:$uuid\nquantity:{$item->quantity()->value()}\ntotalPrice:{$item->totalPrice()->value()}\nPack content:\n";
            $this->printPack($item->pack());
        }
    }


    /**
     * @param ProductPack[] $packs
     * @return void
     */
    private function printPacks(array $packs): void
    {
        Assert::allIsInstanceOf($packs, ProductPack::class);
        if (count($packs) === 0) {
            echo "Packs list is empty\n";
            return;
        }
        echo "Packs List:\n";
        foreach ($packs as $pack) {
            $this->printPack($pack);
        }
        echo "\n";
    }

    /**
     * @param ProductPack $pack
     * @return void
     */
    private function printPack(ProductPack $pack): void
    {
        printf("Pack ID:%4s discount:%d\n", $pack->id()->value(), $pack->discount() ? $pack->discount()->percentage() : 0);
        echo "Products:\n";
        foreach ($pack->products() as $product) {
            echo "{$product}\n";
        }
        echo "\n\n";
    }


    /**
     * @param string $title
     * @param int $price
     * @param int $discount
     * @return Product
     */
    private function newProduct(string $title, int $price, int $discount): Product
    {
        $product = new Product(UUID::generate(), new ProductTitle($title), new Price($price), new DiscountPercentage($discount));
        $eventDispatcher = new EventDispatcher([NewProductEvent::LISTENER_KEY => new NewProductListener()]);

        foreach ($product->events() as $event) {
            $eventDispatcher->dispatch($event);
        }
        return $product;
    }

}