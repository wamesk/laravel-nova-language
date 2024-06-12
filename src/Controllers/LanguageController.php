<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaLanguage\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;
use Wame\LaravelNovaLanguage\Enums\LanguageRequiredEnum;
use Wame\LaravelNovaLanguage\Enums\LanguageStatusEnum;
use Wame\LaravelNovaLanguage\Models\Language;

class LanguageController extends Controller
{
    /**
     * @return Collection
     */
    public static function getActiveCodes(): Collection
    {
        return Language::query()->where('deleted_at', null)->where('status', LanguageStatusEnum::ENABLED)->get()->pluck('code', 'locale');
    }

    /**
     * @return array
     */
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

    /**
     * Helper for display using
     *
     * @param NovaRequest $request
     * @param Language $model
     *
     * @return string|null
     */
    public static function displayUsing($request, $model): ?string
    {
        if (!$model->language_code) {
            return null;
        } elseif ($request instanceof ResourceIndexRequest) {
            return $model->language_code;
        } else {
            $language = $model->language;
            $languageData = $language->languageData();
            $culture = $languageData->getCulture($model->language_code);

            if ($culture) {
                $name = $culture['name'];
            } else {
                $name = $languageData->getName();
            }

            return $name . ' (' . $model->language_code . ')';
        }
    }

    /**
     * Usage
     * ->rulesFor(...LanguageController::translatableRequired())
     *
     * @return array
     */
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
