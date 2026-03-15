<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('price', 10, 0);
            $table->decimal('rrp_price', 10, 0);
            $table->decimal('concession_card_price', 10, 0);
            $table->decimal('private_price', 10, 0);
            $table->decimal('price_change_percent', 10, 0);
            $table->string('price_direction', 10);
            $table->dateTime('created_at')->nullable();

            $table->foreign('product_id', 'fk_procut_key')
                ->references('id')->on('products')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_history');
    }
};
