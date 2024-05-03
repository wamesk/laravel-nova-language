<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->char('id', 5)->primary();
            $table->string('code', 2);
            $table->string('title', 50);
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('main')->default(false);
            $table->boolean('required')->default(false);
            $table->boolean('status')->default(true);
            $table->datetimes();
            $table->softDeletesDatetime();

            $table->index('code');
            $table->index('sort');
            $table->index('main');
            $table->index('status');
            $table->index(['status', 'code']);
            $table->index(['status', 'id']);
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
