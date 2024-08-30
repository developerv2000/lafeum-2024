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
        Schema::create('folders', function (Blueprint $table) {
            $table->unsignedMediumInteger('id')->autoIncrement();
            $table->string('name', 600);

            $table->unsignedMediumInteger('parent_id')
                ->foreign()
                ->references('id')
                ->on('folders')
                ->nullable();

            $table->unsignedSmallInteger('user_id')
                ->foreign()
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};
