<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('basket_id');
            $table->integer('total');
            $table->boolean('submit');
            $table->boolean('send');
            $table->boolean('delivered');
            $table->foreign('buyer_id')->references('id')->on('buyers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('basket_id')->references('id')->on('basket')
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
        Schema::dropIfExists('purchases');
    }
}
