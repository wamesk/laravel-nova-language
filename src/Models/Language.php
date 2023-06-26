<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaLanguage\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Language extends BaseModel implements Sortable
{
    use SoftDeletes;
    use SortableTrait;

    public const MAIN_DISABLED = 0;
    public const MAIN_ENABLED = 1;

    public const STATUS_DISABLED = 0;
    public const STATUS_ENABLED = 1;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
        'sort_on_has_many' => true,
        'sort_on_belongs_to' => true,
        'nova_order_by' => 'ASC',
    ];

    /**
     * @return \Rinvex\Language\Language|null
     */
    public function languageData(): ?\Rinvex\Language\Language
    {
        return $this->code ? language($this->code) : null;
    }

}
