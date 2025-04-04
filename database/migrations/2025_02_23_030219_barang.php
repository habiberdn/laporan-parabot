<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->integer('harga');
            $table->integer('harga_grosir');
            $table->integer('hpp');
            $table->string('deskripsi');
            $table->string('supplier');
            $table->string('image');
            $table->enum('stok', ['ada', 'kosong'])->default('ada');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
