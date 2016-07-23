<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Wiki::class, 9)->create();

        factory(App\Site::class, 3)->create()->each(function ($item) {
            $item->doors()->saveMany(factory(App\Door::class, 2)->make());
        });

        App\Door::each(function ($door) {
            $door->advisors()->saveMany(factory(App\Advisor::class, 2)->make());
            $door->complains()->saveMany(factory(App\Complain::class, 2)->make());
        });

        factory(App\Category::class, 3)->create()->each(function ($item) {
            $item->children()->saveMany(factory(App\Category::class, 2)->make());
        });

        App\Category::whereNotNull('parent_id')->each(function ($category) {
            $category->products()->saveMany(factory(App\Product::class, 3)->make());
        });

        App\Product::each(function ($product) {
            $product->variations()->saveMany(factory(App\Variation::class, 3)->make());
        });
    }
}
