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
        Schema::create('belanjas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama_barang');
            $table->integer('jumlah_pesanan');
            $table->integer('satuan');
            $table->enum('stok', ['ada', 'kosong']);
            $table->string('pemasok');
            $table->string('gambar');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('belanjas');
    }
};
