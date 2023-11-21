<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $men = Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => null,
            'name' => 'Men',
            'content' => 'Mens wear',
            'status'=>'1'
        ]);


          Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $men->id,
            'name' => 'Men shoes',
            'content' => 'Men shoes sport',
            'status'=>'1'
        ]);

        Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $men->id,
            'name' => 'Men Trousers',
            'content' => 'Men Trousers',
            'status'=>'1'
        ]);


        $women = Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => null,
            'name' => 'Women',
            'content' => 'women wear',
            'status'=>'1'
        ]);

        Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $women->id,
            'name' => 'Women Bag',
            'content' => 'Women Bags',
            'status'=>'1'
        ]);

        Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $women->id,
            'name' => 'Women Trousers',
            'content' => ' women Trousers',
            'status'=>'1'
        ]);



        $child = Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => null,
            'name' => 'Child',
            'content' => 'Child wear',
            'status'=>'1'
        ]);


        Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' =>  $child->id,
            'name' => 'Children Toy',
            'content' => 'Children Toys',
            'status'=>'1'
        ]);

        Category::create([
            'image' => null,
            'thumbnail' => null,
            'cat_ust' => $child->id,
            'name' => 'Kids Pant',
            'content' => 'Kids Pants',
            'status'=>'1'
        ]);
    }
}
