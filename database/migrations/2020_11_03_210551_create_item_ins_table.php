<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->foreignId('branch_id');
            $table->foreignId('supplier_id');
            $table->date('date');
            $table->string('purchase_number', 20)->nullable();
            $table->double('cost_price')->nullable();
            $table->string('serial_number', 30)->nullable();
            $table->boolean('sold')->nullable();
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
        Schema::dropIfExists('item_ins');
    }
}
