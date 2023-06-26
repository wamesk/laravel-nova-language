<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            if (Builder::$defaultMorphKeyType === 'ulid') {
                $table->ulid('id')->primary();
            } elseif (Builder::$defaultMorphKeyType === 'uuid') {
                $table->uuid('id')->primary();
            } else {
                $table->id('id')->primary();
            }

            $table->string('code', 2);
            $table->char('locale', 5)->nullable();
            $table->string('title', 50);
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('main')->default(false);
            $table->boolean('required')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
            $table->index('locale');
            $table->unique('locale');
            $table->index('sort');
            $table->index('main');
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
    public function down()
    {
        Schema::dropIfExists('languages');
    }

};
