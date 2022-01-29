<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
           $table->id();
           $table->string('purchase_id');
           $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
           $table->unsignedBigInteger('item_id');
           $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
           $table->integer('quantity');
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
        Schema::dropIfExists('histories');
    }
}
