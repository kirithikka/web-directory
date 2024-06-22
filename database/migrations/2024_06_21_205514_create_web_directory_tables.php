<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable(true);
            $table->timestamps();
        });

        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name');
            $table->string('url');
            $table->string('description')->nullable(true);
            $table->softDeletes();
            $table->timestamps();

            // index
            $table->index('user_id');
            $table->index('name');
        });

        Schema::create('category_website', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id');
            $table->bigInteger('website_id');
            $table->softDeletes();
            $table->timestamps();

            // index
            $table->index('category_id');
            $table->index('website_id');
        });

        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('website_id');
            $table->timestamps();

            // index
            $table->index('user_id');
            $table->index('website_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('websites');
        Schema::dropIfExists('categories_websites');
        Schema::dropIfExists('votes');
    }
};
