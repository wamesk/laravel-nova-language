<?php

//declare(strict_types = 1);

namespace Wame\LaravelNovaLanguage\Nova;

use App\Nova\Resource;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Nette\Utils\Strings;
use Outl1ne\NovaSortable\Traits\HasSortableRows;
use ShuvroRoy\NovaTabs\Tab;
use ShuvroRoy\NovaTabs\Tabs;
use Wame\LaravelNovaLanguage\Enums\LanguageMainEnum;
use Wame\LaravelNovaLanguage\Enums\LanguageRequiredEnum;
use Wame\LaravelNovaLanguage\Enums\LanguageStatusEnum;

class Language extends Resource
{
    use HasSortableRows;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \Wame\LaravelNovaLanguage\Models\Language::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'code', 'title',
    ];

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        if ($request->viaRelationship) {
            return self::relatableQuery($request, $query);
        }
        if (empty($request->get('orderBy'))) {
            $query->getQuery()->orders = [];

            return $query->orderBy('code', 'asc');
        }

        return $query;
    }

    public static function relatableQuery(NovaRequest $request, $query): Builder
    {
        if (Strings::contains($request->path(), 'associatable/language')) {
            $query->where('status', LanguageStatusEnum::ENABLED);
        }

        return $query;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Tabs::make(__('laravel-nova-language::language.detail', ['title' => $this->title ?: '']), [
                Tab::make(__('laravel-nova-language::language.singular'), [
                    ID::make()
                        ->sortable()
                        ->showOnPreview(),

                    Text::make(__('laravel-nova-language::language.field.code'), 'code')
                        ->sortable()
                        ->filterable()
                        ->exceptOnForms()
                        ->showOnPreview(),

                    Text::make(__('laravel-nova-language::language.field.title'), 'title')
                        ->help(__('laravel-nova-language::language.field.title.help'))
                        ->sortable()
                        ->filterable()
                        ->required()
                        ->rules('required')
                        ->showOnPreview(),

                    Boolean::make(__('laravel-nova-language::language.field.main'), 'main')
                        ->default(LanguageMainEnum::DISABLED)
                        ->sortable()
                        ->filterable()
                        ->exceptOnForms()
                        ->showOnPreview(),

                    Boolean::make(__('laravel-nova-language::language.field.required'), 'required')
                        ->default(LanguageRequiredEnum::DISABLED)
                        ->sortable()
                        ->filterable()
                        ->showOnPreview(),

                    Boolean::make(__('laravel-nova-language::language.field.status'), 'status')
                        ->default(LanguageStatusEnum::ENABLED)
                        ->sortable()
                        ->filterable()
                        ->showOnPreview(),
                ]),
            ])->withToolbar(),
        ];
    }

    public static function label(): string
    {
        return __('laravel-nova-language::language.label');
    }

    public static function createButtonLabel(): string
    {
        return __('laravel-nova-language::language.create.button');
    }

    public static function updateButtonLabel(): string
    {
        return __('laravel-nova-language::language.update.button');
    }
}
