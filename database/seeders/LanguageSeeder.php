<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

/**
 * php artisan db:seed --class=LanguageSeeder
 */
class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $items = [
            ['code' => 'sk', 'locale' => 'sk_SK', 'title' => 'Slovenčina'],
            ['code' => 'cs', 'locale' => 'cs_CZ', 'title' => 'Čeština'],
        ];

        foreach ($items as $item) {
            Language::updateOrCreate(['locale' => $item['locale']], $item);
        }
    }
}
