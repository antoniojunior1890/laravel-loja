<?php

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(\App\Models\Category::class, 10)->create()->each(function ($user) {
//            $user->products()->save(factory(\App\Models\Product::class)->make());
//        });



        $orders = factory(\App\Models\Order::class,5)->create();
        $products = factory(\App\Models\Product::class,20)->create();

        $orders->first()->products()->sync($products);
    }
}
