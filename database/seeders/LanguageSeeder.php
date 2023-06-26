<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Rinvex\Country\CountryLoader;
use Rinvex\Language\LanguageLoader;

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
    public function run()
    {
        $list = LanguageLoader::languages();

        foreach ($list as $item) {
            $data = [
                'code' => $item['iso_639_1'],
                'locale' => $item['iso_639_1']
            ];

            if (isset($item['cultures']) && $item['cultures'] != null) {
                foreach ($item['cultures'] as $code => $culture) {
                    $data['title'] = $culture['name'];
                    $data['locale'] = $code;
                    Language::updateOrCreate(['code' => $data['code']], $data);
                }
            } else {
                $data['title'] = $item['name'];
                Language::updateOrCreate(['code' => $data['code']], $data);
            }
        }

        // Default
        $language = Language::where(['locale' => 'sk'])->first();
        $language->main = Language::MAIN_ENABLED;
        $language->save();
    }

}
