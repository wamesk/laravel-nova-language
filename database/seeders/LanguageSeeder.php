<?php

namespace Wame\LaravelNovaLanguage\Database\Seeders;

use Illuminate\Database\Seeder;
use Rinvex\Language\LanguageLoader;
use Wame\LaravelNovaLanguage\Enums\LanguageMainEnum;
use Wame\LaravelNovaLanguage\Models\Language;

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
        /** @var LanguageLoader $languageLoader */
        $languageLoader = resolve(LanguageLoader::class);
        $list = $languageLoader->languages();

        /** @var Language $model */
        $model = resolve(Language::class);

        foreach ($list as $item) {
            $data = [
                'id' => $item['iso_639_1'],
                'code' => $item['iso_639_1'],
            ];

            if (isset($item['cultures']) && $item['cultures'] != null) {
                foreach ($item['cultures'] as $code => $culture) {
                    $data['title'] = $culture['name'];
                    $data['id'] = $code;
                    $model->query()->updateOrCreate(['code' => $data['code']], $data);
                }
            } else {
                $data['title'] = $item['name'];
                $model->query()->updateOrCreate(['id' => $data['id']], $data);
            }
        }

        // Default
        $language = $model->query()->where(['code' => 'sk'])->first();
        $language->main = LanguageMainEnum::ENABLED;
        $language->save();
    }
}
