<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 45);
            $table->string('name_ar', 45)->nullable();
            $table->string('info')->nullable();
            $table->integer('price');
            $table->integer('quantity');
            $table->enum('color', ['Black', 'White', 'Gray', 'NavyBlue', 'Pink', 'Orange']);
            $table->string('image');
            $table->string('album');
            $table->integer('discount')->nullable();
            $table->integer('old_price')->nullable();
            $table->softDeletes();

            $table->foreignId('user_id');

            $table->foreignId('type_id');
            $table->foreign('type_id')->on('types')->references('id')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
