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
        Schema::create('knowledge', function (Blueprint $table) {
            $table->unsignedSmallInteger('id')->autoIncrement();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->nestedSet();
        });

        Schema::create('knowledge_term', function (Blueprint $table) {
            $table->unsignedSmallInteger('knowledge_id');
            $table->foreign('knowledge_id')
                ->references('id')
                ->on('knowledge');

            $table->unsignedSmallInteger('term_id');
            $table->foreign('term_id')
                ->references('id')
                ->on('terms');

            $table->primary(['knowledge_id', 'term_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge');
    }
};
