<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'name' => 'English',
                'locale' => 'en',
            ],
            [
                'name' => '中国',
                'locale' => 'zh_CN',
            ],
            [
                'name' => 'ខ្មែរ',
                'locale' => 'km',
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
