<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Client;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Pricing;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'pork'
        ]);

        Warehouse::create([
            'name' => 'barals',
            'location' => 'tagbilaran'
        ]);

        Item::create([
            'product_code' => '1001',
            'name' => 'belly',
            'category_id' => 1,
            'image' => 'belly.png'
        ]);

        Item::create([
            'product_code' => '1002',
            'name' => 'chicken',
            'category_id' => 1,
            'image' => 'belly.png'
        ]);
        

        Product::create([
            'item_id' => 1,
            'quantity' => 2,
            'price' => 200,
            'warehouse_id' => 1,
        ]);

        Product::create([
            'item_id' => 2,
            'quantity' => 2,
            'price' => 200,
            'warehouse_id' => 1,
        ]);

        Client::create([
            'name' => 'mark russel baral',
            'tin_name' => 'mark',
            'tin_number' => 221101,
            'type' => 'wholesale'
        ]);

        Client::create([
            'name' => 'mark russel barals',
            'tin_name' => 'marks',
            'tin_number' => 221101,
            'type' => 'wholesale'
        ]);

        Purchase::create([
            'date' => '16/02/2024',
            'product_id' => 1,
            'client_id' => 1,
            'type' => 'wholesale',
            'quantity' => 3,
            'price' => 100,
            'total_price' => 200,
            'status' => 'paid',
            'mode_of_payment' => 'gcash'
        ]);

        Pricing::create([
            'client_id' => 1,
            'product_id' => 1,
            'price' => '200',
        ]);

        Pricing::create([
            'client_id' => 1,
            'product_id' => 2,
            'price' => '200',
        ]);

        Pricing::create([
            'client_id' => 2,
            'product_id' => 2,
            'price' => '200',
        ]);


    }
}
