<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->unsignedBigInteger('added_by')->nullable(); //added by belongs to user with user_id
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->string('summary_image')->nullable();
            $table->decimal('sale_price', 8, 2)->default(0);
            $table->decimal('retail_price', 8, 2)->default(0);
            $table->decimal('shipping_charges', 8, 2)->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('stock_alert_quantity')->default(0);
            $table->string('type')->nullable();
            $table->longText('description')->nullable();
            $table->longText('metadata')->nullable();
            $table->boolean('is_sample')->default(false);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('products');
    }
}
