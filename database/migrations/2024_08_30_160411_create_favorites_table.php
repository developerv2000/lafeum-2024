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
        Schema::create('favorites', function (Blueprint $table) {
            $table->unsignedMediumInteger('id')->autoIncrement();
            $table->unsignedSmallInteger('favoritable_id');
            $table->string('favoritable_type');

            $table->unsignedSmallInteger('user_id')
                ->foreign()
                ->references('id')
                ->on('users');

            $table->unsignedSmallInteger('folder_id')
                ->foreign()
                ->references('id')
                ->on('folders');

            $table->index(['favoritable_id', 'favoritable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
