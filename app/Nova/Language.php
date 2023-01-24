<?php

namespace App\Nova;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Nette\Utils\Strings;
use Outl1ne\NovaSortable\Traits\HasSortableRows;


class Language extends BaseResource
{
    use HasSortableRows;


    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Language::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = ['code', ' - ', 'title'];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'code', 'locale', 'title'
    ];


    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->viaRelationship) {
            return self::relatableQuery($request, $query);
        } else {
            if (empty($request->get('orderBy'))) {
                $query->getQuery()->orders = [];
                return $query->orderBy('code', 'asc');
            }

            return $query;
        }
    }


    public static function relatableQuery(NovaRequest $request, $query)
    {
        if (Strings::contains($request->path(), 'associatable/language')) {
            $query->where('status', \App\Models\Language::STATUS_ENABLED);
        }

        return $query;
    }


    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Tabs::make(__('language.detail', ['title' => $this->title ?: '']), [
                Tab::make(__('language.singular'), [
                    ID::make()->onlyOnForms(),

                    Text::make(__('language.field.code'), 'code')
                        ->help(__('language.field.code.help'))
                        ->sortable()
                        ->filterable()
                        ->rules('required')
                        ->showOnPreview(),

                    Text::make(__('language.field.locale'), 'locale')
                        ->help(__('language.field.locale.help'))
                        ->sortable()
                        ->filterable()
                        ->rules('required')
                        ->showOnPreview(),

                    Text::make(__('language.field.title'), 'title')
                        ->help(__('language.field.title.help'))
                        ->sortable()
                        ->filterable()
                        ->rules('required'),

                    Boolean::make(__('language.field.status'), 'status')
                        ->help(__('language.field.status.help'))
                        ->default(\App\Models\Language::STATUS_ENABLED)
                        ->sortable()
                        ->filterable()
                        ->showOnPreview(),
                ]),
            ])->withToolbar(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
