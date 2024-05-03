<?php

namespace Wame\LaravelNovaLanguage\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasLanguage
{
    /**
     * @return BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_code', 'locale');
    }

    /**
     * @return Language|null
     */
    public function languageData(): ?Language
    {
        return $this->lanuage_code ? language($this->lanuage_code) : null;
    }

}
