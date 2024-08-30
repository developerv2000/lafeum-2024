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
        Schema::create('daily_posts', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();

            $table->date('date')
                ->useCurrent()
                ->unique();

            $table->unsignedSmallInteger('quote_id')
                ->foreign()
                ->references('id')
                ->on('quotes')
                ->onDelete('set null');

            $table->unsignedSmallInteger('term_id')
                ->foreign()
                ->references('id')
                ->on('terms')
                ->onDelete('set null');

            $table->unsignedSmallInteger('video_id')
                ->foreign()
                ->references('id')
                ->on('videos')
                ->onDelete('set null');

            $table->unsignedSmallInteger('photo_id')
                ->foreign()
                ->references('id')
                ->on('photos')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_posts');
    }
};
