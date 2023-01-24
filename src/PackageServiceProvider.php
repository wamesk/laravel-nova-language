<?php

namespace Wame\LaravelNovaLanguage;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            // Export model
            $model = app_path('Models/Language.php');
            if (!file_exists($model)) $this->createModel($model);

            // Export Nova resource
            $this->publishes([__DIR__ . '/../app/Nova/Language.php' => app_path('Nova/Language.php')], ['nova', 'wame', 'language']);

            // Export policy
            $this->publishes([__DIR__ . '/../app/Policies/LanguagePolicy.php' => app_path('Policies/LanguagePolicy.php')], ['policy', 'wame', 'language']);

            // Export migration
            $this->publishes([__DIR__ . '/../database/migrations/2022_08_16_143118_create_languages_table.php' => database_path('migrations/2022_08_16_143118_create_languages_table.php')], ['migrations', 'wame', 'language']);

            // Export seeder
            $this->publishes([__DIR__ . '/../database/seeders/LanguageSeeder.php' => database_path('seeders/LanguageSeeder.php')], ['seeders', 'wame', 'language']);

            // Export lang
            $this->publishes([__DIR__ . '/../resources/lang/sk/language.php' => resource_path('lang/sk/language.php')], ['langs', 'wame', 'language']);
        }
    }


    private function createModel($model)
    {
        $file = fopen($model, "w");
        $idType = config('wame-commands.id-type');

        if ($idType === 'ulid') {
            $use = "use Illuminate\Database\Eloquent\Concerns\HasUlids;\n";
            $use2 = "    use HasUlids;\n";
        } elseif ($idType === 'uuid') {
            $use = "use Illuminate\Database\Eloquent\Concerns\HasUuids;\n";
            $use2 = "    use HasUuids;\n";
        } else {
            $use = '';
            $use2 = '';
        }

        $lines = [
            "<?php \n",
            "\n",
            "namespace App\Models;\n",
            "\n",
            $use,
            "\n",
            "class Language extends \Wame\LaravelNovaLanguage\Models\Language\n",
            "{\n",
            $use2,
            "\n",
            "}\n",
            "\n",
        ];

        fwrite($file, implode('', $lines));
        fclose($file);
    }

}
