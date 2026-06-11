<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Saf Kreatin Monohidrat',
            'description' => 'Antrenman performansınızı artırın ve kas gelişiminizi destekleyin.',
            'price' => 450.00,
            'image' => 'kreatin.jpg'
        ]);

        Product::create([
            'name' => 'Patlayıcı Güç Pre-Workout',
            'description' => 'Antrenman öncesi maksimum enerji ve pump etkisi için özel formül.',
            'price' => 580.00,
            'image' => 'preworkout.jpg'
        ]);

        Product::create([
            'name' => 'Günlük Vitamin Paketi',
            'description' => 'İhtiyacın olan tüm günlük vitamin ve mineraller tek bir pakette.',
            'price' => 320.00,
            'image' => 'vitamin.jpg'
        ]);
    }
}