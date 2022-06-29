<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('order_number')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('sub_total', 8, 2)->nullable();
            $table->decimal('shipping_charges', 8, 2)->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->longText('shipping_details')->nullable();
            $table->longText('billing_details')->nullable();
            $table->boolean('billing_same_as_shipping')->default(false);
            $table->longText('description')->nullable();
            $table->longText('payment_details')->nullable();
            $table->string('status')->default('new');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
