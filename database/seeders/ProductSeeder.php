<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            'Casual T-Shirt', 'Formal Shirt', 'Summer Dress', 'Jeans Jacket', 'Polo Shirt', 
            'Sportswear', 'Classic Blazer', 'Denim Shorts', 'Sweatshirt', 'Winter Coat', 
            'Cargo Pants', 'Hoodie', 'Cardigan', 'Leather Jacket', 'V-Neck T-Shirt',
            'Striped Shirt', 'Floral Dress', 'Maxi Skirt', 'Crop Top', 'Tank Top',
            'Slim-fit Jeans', 'Jogger Pants', 'Bomber Jacket', 'Puffer Jacket', 'Graphic Tee',
            'Plaid Shirt', 'Dungarees', 'Linen Shirt', 'Embroidered Dress', 'Pullover Sweater'
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product,
                'description' => 'A beautiful ' . $product,
                'image_url' => 'https://picsum.photos/id/'.rand(1,100).'/200/300',
                'price' => rand(10, 100),
            ]);
        }
    }
}
