<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaLanguage;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            // Export model
            $model = app_path('Models/Language.php');
            if (!file_exists($model)) {
                $this->createModel($model);
            }

            // Export Nova resource
            $this->publishes([__DIR__ . '/../app/Nova' => app_path('Nova')], ['nova', 'wame', 'language']);

            // Export policy
            $this->publishes([__DIR__ . '/../app/Policies' => app_path('Policies')], ['policy', 'wame', 'language']);

            // Export migration
            $this->publishes([__DIR__ . '/../database/migrations' => database_path('migrations')], ['migrations', 'wame', 'language']);

            // Export seeder
            $this->publishes([__DIR__ . '/../database/seeders' => database_path('seeders')], ['seeders', 'wame', 'language']);

            // Export lang
            $this->publishes([__DIR__ . '/../resources/lang' => resource_path('lang')], ['langs', 'wame', 'language']);
        }
    }


    private function createModel($model): void
    {
        $file = fopen($model, 'w');
        $idType = config('wame-commands.id-type') ?? 'ulid';

        if ('ulid' === $idType) {
            $use = "use Illuminate\Database\Eloquent\Concerns\HasUlids;\n";
            $use2 = "    use HasUlids;\n";
        } elseif ('uuid' === $idType) {
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
