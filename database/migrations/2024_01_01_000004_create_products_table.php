<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id')->nullable();
            $table->string('product_id', 100)->nullable();
            $table->integer('user_product_id')->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('sku', 100)->nullable();
            $table->string('barcode', 100)->nullable();
            $table->string('name', 255)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('rrp_price', 10, 2)->nullable();
            $table->decimal('concession_card_price', 10, 2)->nullable();
            $table->decimal('private_price', 10, 2)->nullable();
            $table->decimal('price_change_percent', 5, 2)->nullable();
            $table->string('price_direction', 10)->nullable();
            $table->text('url')->nullable();
            $table->string('brand', 100)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('sub_category', 50)->default('');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->useCurrent();
            $table->integer('status')->default(1)->comment('1=completed,2=processing');
            $table->dateTime('deleted_at')->nullable();
            $table->integer('request_id')->default(0);
            $table->text('payload')->default('');
            $table->text('params')->default('');
            $table->text('query_url')->default('');
            $table->text('headers')->default('');

            $table->unique(['company_id', 'product_id'], 'unique_company_product');
            $table->index('user_product_id');

            $table->foreign('user_product_id')->references('id')->on('user_products');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
