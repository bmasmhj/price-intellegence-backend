<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('barcode', 100)->nullable()->unique();
            $table->decimal('cost_price', 10, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_products');
    }
};
