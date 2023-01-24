<?php

namespace Wame\LaravelNovaLanguage\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;


class Language extends Model implements Sortable
{
    use HasFactory;
    use SoftDeletes;
    use SortableTrait;


    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;


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

}
