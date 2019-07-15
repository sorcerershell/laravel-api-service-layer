<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new Product([
            '_id' => '507f191e810c19729de860ea',
            'name' => 'Product 1',
            'price' => 100000,
            'image' => 'http://s3-ap-southeast-1.amazonaws.com/s3.irvinsaltedegg.com/engineering-test/images/product-1.jpg'
        ]);
        $product->save();
    }
}
