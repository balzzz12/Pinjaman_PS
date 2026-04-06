<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('play_stations', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->integer('harga');
            $table->integer('stok');
            $table->string('photo')->nullable();
            $table->string('video')->nullable(); // VIDEO
            $table->text('deskripsi')->nullable(); // DESKRIPSI TAMBAHAN
            $table->enum('status', ['tersedia','disewa'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('play_stations');
    }
};