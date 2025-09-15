<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Organik Tarım Teknikleri',
                'description' => 'Toprak hazırlığı, kompost yapımı, doğal gübre kullanımı ve zararlılarla organik mücadele teknikleri',
                'color' => '#2D5016',
                'icon' => 'bi-gear'
            ],
            [
                'name' => 'Sebze & Meyve Yetiştirme',
                'description' => 'Sebze yetiştirme rehberleri, meyve ağaçları bakımı ve aromatik bitkiler',
                'color' => '#8B4513',
                'icon' => 'bi-apple'
            ],
            [
                'name' => 'Organik Sertifikasyon',
                'description' => 'Sertifikasyon süreci, gerekli belgeler ve kontrol kuruluşları hakkında bilgiler',
                'color' => '#FFD700',
                'icon' => 'bi-award'
            ],
            [
                'name' => 'Pazarlama & Satış',
                'description' => 'Organik ürün pazarlama stratejileri, online satış kanalları ve yerel pazarlar',
                'color' => '#228B22',
                'icon' => 'bi-shop'
            ],
            [
                'name' => 'Sürdürülebilirlik',
                'description' => 'Çevre dostu uygulamalar, atık yönetimi ve biyoçeşitlilik',
                'color' => '#32CD32',
                'icon' => 'bi-recycle'
            ]
        ];

        foreach($categories as $category){
            Category::create($category);
        }
    }
}
