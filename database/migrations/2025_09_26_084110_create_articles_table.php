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
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('category_article_id')->index();
            $table->foreign('category_article_id')
                ->references('id')
                ->on('category_articles')
                ->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('author');
            $table->string('title');
            $table->string('thumbnail')->nullable();
            $table->string('thumbnail_alt_text')->nullable();
            $table->text('content');
            $table->boolean('is_published')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->date('publish_date');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
