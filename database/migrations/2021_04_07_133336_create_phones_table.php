<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('phone_category');
            $table->string('mark');
            $table->string('model');
            $table->string('display');
            $table->string('screen_resolution');
            $table->string('screen_type');
            $table->string('communication');
            $table->integer('sim');
            $table->string('cpu');
            $table->integer('cores');
            $table->string('cpu_frequency');
            $table->string('gpu');
            $table->integer('ram');
            $table->integer('rom');
            $table->integer('back_camera');
            $table->string('back_video');
            $table->integer('front_camera');
            $table->string('flash');
            $table->string('battery');
            $table->text('description');
            $table->foreign('product_id')->references('id')->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('all_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('phone_category')->references('id')->on('phone_categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phones');
    }
}
