<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaLanguage\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;
use Wame\LaravelNovaLanguage\Enums\LanguageRequiredEnum;
use Wame\LaravelNovaLanguage\Enums\LanguageStatusEnum;
use Wame\LaravelNovaLanguage\Models\Language;

class LanguageService
{
    public static function getActiveCodes(): Collection
    {
        return Language::query()->whereNull('deleted_at')->where('status', LanguageStatusEnum::ENABLED)->get()->pluck('code', 'id');
    }

    public static function getListForSelect(): array
    {
        $list = self::getActiveCodes();

        $return = [];

        foreach ($list as $locale => $code) {
            $languageData = language($code);
            $culture = $languageData->getCulture($locale);

            if ($culture) {
                $name = $culture['name'];
            } else {
                $name = $languageData->getName();
            }

            $return[$locale] = $name . ' (' . $locale . ')';
        }

        natcasesort($return);

        return $return;
    }

    public static function displayUsing($request, $model): ?string
    {
        if (!$model->language_id) {
            return null;
        } elseif ($request instanceof ResourceIndexRequest) {
            return $model->language_id;
        } else {
            $language = $model->language;
            $languageData = $language->languageData();
            $culture = $languageData->getCulture($model->language_id);

            if ($culture) {
                $name = $culture['name'];
            } else {
                $name = $languageData->getName();
            }

            return $name . ' (' . $model->language_id . ')';
        }
    }

    public static function translatableRequired(): array
    {
        $langs = Cache::store('file')->get('languages-required');

        if (!$langs) {
            $langs = Language::query()->where('required', LanguageRequiredEnum::ENABLED)->pluck('code')->toArray();
            Cache::store('file')->put('languages-required', $langs);
        }

        return [$langs, ['required']];
    }

}
