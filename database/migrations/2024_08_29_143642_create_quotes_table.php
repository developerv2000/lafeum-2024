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
        Schema::create('quotes', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->text('body');

            $table->unsignedSmallInteger('author_id')
                ->foreign()
                ->references('id')
                ->on('authors');

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->timestamp('publish_at')->useCurrent();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
