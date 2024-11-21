<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
        	'name' => 'Fabricados ',
        	'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
        	'name' => 'No fabricados',
        	'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
        	'name' => 'Parrilla',
        	'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
        	'name' => 'Carnes crudas',
        	'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'Bar',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'Lechoneria',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);       
        Category::create([
            'name' => 'Maquilas ',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'Condimentos',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'Materias prima',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'Materias P Exenta',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'NO Gravados',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'Gravados',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
    }
}
