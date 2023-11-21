<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       SiteSetting::create([
        'name'=>'adres',
        'data'=>'Az.Baku',
       ]);


       SiteSetting::create([
        'name'=>'phone',
        'data'=>'+994553292029',
       ]);


       SiteSetting::create([
        'name'=>'email',
        'data'=>'muradgafaroff@gmail.com',
       ]);

       SiteSetting::create([
        'name'=>'map',
        'data'=> null,
       ]);
    }
}
