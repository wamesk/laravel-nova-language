<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table): void {
            if ('id' === Builder::$defaultMorphKeyType) {
                $table->id('id')->primary();
            } elseif ('uuid' === Builder::$defaultMorphKeyType) {
                $table->uuid('id')->primary();
            } else {
                $table->ulid('id')->primary();
            }

            $table->string('code', 11);
            $table->char('locale', 6)->nullable();
            $table->string('title', 100);
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
            $table->unique('locale');
            $table->index('sort');
            $table->index('status');
            $table->index(['status', 'code']);
            $table->index(['status', 'locale']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
