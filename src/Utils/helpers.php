<?php

if (!function_exists('translatableRequired'))
{
    /**
     * usage
     * ->rulesFor(...translatableRequired())
     *
     * @return array
     */
    function translatableRequired(): array
    {
        return \Wame\LaravelNovaLanguage\Services\LanguageService::translatableRequired();
    }
}
