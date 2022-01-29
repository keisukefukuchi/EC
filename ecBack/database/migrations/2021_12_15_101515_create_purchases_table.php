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
            $table->string('id')->primary();
            $table->unsignedBigInteger('purchaser_id');
            $table->foreign('purchaser_id')->references('id')->on('purchasers')->onDelete('cascade');
            $table->integer('amount');
            $table->string('destination');
            $table->integer('total');
            $table->integer('used_point');
            $table->integer('get_point');
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
        Schema::dropIfExists('purchases');
    }
}