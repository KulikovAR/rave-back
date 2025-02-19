<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DescriptionProductSeeder extends Seeder
{
    const ADMIN_PASSWORD = 'admin@admin';

    const ADMIN_EMAIL = 'admin@admin';

    const USER_PASSWORD = 'test@test.ru';

    const USER_EMAIL = 'test@test.ru';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $products = DB::connection('old')->select('select * from products');	
        foreach($products as $product) {
            $input = $product->composition;

            $output = strip_tags($input); 
            $items = explode("\n", trim($output)); 
            $items = array_map('trim', $items); 
            $items = array_filter($items); 

            $result = implode(', ', $items);

            

            $newProduct = \App\Models\Product::where('name',$product->name)->update([
                'description' => $result,
            ]);

        
            
        }



    }
}