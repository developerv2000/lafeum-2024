<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quote_categories', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->nestedSet();
        });

        Schema::create('category_quote', function (Blueprint $table) {
            $table->unsignedSmallInteger('quote_id');
            $table->foreign('quote_id')
                ->references('id')
                ->on('quotes');

            $table->unsignedSmallInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('quote_categories');

            $table->primary(['quote_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_categories');
        Schema::dropIfExists('category_quote');
    }
};
