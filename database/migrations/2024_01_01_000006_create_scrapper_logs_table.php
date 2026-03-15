<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scrapper_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->dateTime('started_at');
            $table->dateTime('completed_at');
            $table->integer('status')->comment('0=removed,1=completed,2=processing,3=error');
            $table->text('message');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scrapper_logs');
    }
};
