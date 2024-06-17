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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index()->unique();
            $table->string('name');
            $table->string('vendor', 50);
            $table->string('size', 25)->nullable();
            $table->decimal('average_weight')->nullable();
            $table->string('insert', 50)->nullable();
            $table->string('sample', 10)->nullable();
            $table->string('picture_path')->nullable();
            $table->unsignedBigInteger('catalog_id');
            $table->foreign('catalog_id')->references('id')->on('catalogs');
            $table->boolean('new');
            $table->string('p_group', 25);
            $table->integer('rest')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
