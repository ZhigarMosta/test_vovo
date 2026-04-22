<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [];

        $categories = DB::table('categories')->pluck('id')->toArray();

        $names = [
            'Смартфон Samsung Galaxy',
            'Ноутбук ASUS VivoBook',
            'Наушники Sony WH-1000XM4',
            'Умные часы Apple Watch',
            'Планшет iPad Air',
            'Куртка зимняя',
            'Джинсы классические',
            'Кроссовки Nike Air Max',
            'Рубашка мужская',
            'Сумка через плечо',
            ' роман "Война и мир"',
            'Сборник рецептов',
            'Энциклопедия',
            'Аудиокнига',
            'Тетрадь',
            'Велосипед',
            'Гантели 10кг',
            'Мяч футбольный',
            'Теннисная ракетка',
            'Коврик для йоги',
            'Лампа настольная',
            'Чайник электрический',
            'Подушка',
            'Кресло офисное',
            'Растение в горшке',
        ];

        $prices = [29990, 54990, 24990, 32900, 45900, 8990, 3990, 7490, 2990, 4590, 990, 590, 1990, 490, 190, 25900, 1990, 1290, 4990, 1990, 2490, 1890, 990, 12990, 390];

        $ratings = [4.5, 4.2, 4.8, 4.7, 4.3, 4.0, 4.5, 4.6, 3.9, 4.1, 4.9, 4.4, 4.6, 4.2, 4.0, 4.5, 4.8, 4.7, 4.3, 4.1, 4.4, 4.6, 4.5, 4.2, 4.3];

        for ($i = 0; $i < count($names); $i++) {
            $products[] = [
                'name' => $names[$i],
                'price' => $prices[$i],
                'category_id' => $categories[array_rand($categories)],
                'in_stock' => (bool) rand(0, 1),
                'rating' => $ratings[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}
