<?php

namespace Wame\LaravelNovaLanguage\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasLanguage
{
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function languageData(): ?Language
    {
        return $this->lanuage_id ? language($this->lanuage_id) : null;
    }

}
