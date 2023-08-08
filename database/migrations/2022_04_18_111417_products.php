<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
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
            $table->string('image')->nullable();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->longText('des_ar');
            $table->longText('des_en')->nullable();
            $table->float('price');
            $table->float('price_discount')->default(0);
            $table->float('dealer_price')->nullable()->default(0);
            $table->integer('stock')->default(1);
            $table->float('pay_count')->default(0);
            $table->float('rate')->default(0);
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
}
