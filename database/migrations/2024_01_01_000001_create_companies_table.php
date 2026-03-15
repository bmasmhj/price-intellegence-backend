<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name', 100);
            $table->string('full_script', 50);
            $table->string('url', 255);
            $table->dateTime('deletedAt')->nullable();
            $table->integer('status');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->useCurrent();
            $table->dateTime('last_scrapped');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
