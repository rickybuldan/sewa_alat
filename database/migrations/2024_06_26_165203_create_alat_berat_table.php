<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alat_berat', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('merk');
            $table->string('gambar');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_sewa', 10);
            $table->integer('stok');
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
        Schema::dropIfExists('alat_berat');
    }
};
