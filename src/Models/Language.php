<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaLanguage\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Wame\LaravelNovaLanguage\Enums\LanguageMainEnum;
use Wame\LaravelNovaLanguage\Enums\LanguageRequiredEnum;
use Wame\LaravelNovaLanguage\Enums\LanguageStatusEnum;

/**
 * 
 *
 * @property string $id
 * @property string $code
 * @property string $title
 * @property int $sort
 * @property int $main
 * @property int $required
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Rinvex\Language\Language|null $language_data
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language onlyTrashed()
 * @method static Builder|Language ordered(string $direction = 'asc')
 * @method static Builder|Language query()
 * @method static Builder|Language whereCode($value)
 * @method static Builder|Language whereCreatedAt($value)
 * @method static Builder|Language whereDeletedAt($value)
 * @method static Builder|Language whereId($value)
 * @method static Builder|Language whereMain($value)
 * @method static Builder|Language whereRequired($value)
 * @method static Builder|Language whereSort($value)
 * @method static Builder|Language whereStatus($value)
 * @method static Builder|Language whereTitle($value)
 * @method static Builder|Language whereUpdatedAt($value)
 * @method static Builder|Language withTrashed()
 * @method static Builder|Language withoutTrashed()
 * @mixin \Eloquent
 */
class Language extends Model implements Sortable
{
    use SoftDeletes;
    use SortableTrait;
    use HasUlids;

    protected $appends = [
        'language_data',
    ];

    protected $guarded = ['id'];

    public array $sortable = [
        'order_column_name' => 'sort',
        'sort_when_creating' => true,
        'sort_on_has_many' => true,
        'sort_on_belongs_to' => true,
        'nova_order_by' => 'ASC',
    ];

    protected function casts(): array
    {
        return [
            'main' => LanguageMainEnum::class,
            'required' => LanguageRequiredEnum::class,
            'status' => LanguageStatusEnum::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function getLanguageDataAttribute(): ?\Rinvex\Language\Language
    {
        return $this->code ? language($this->code) : null;
    }
}
