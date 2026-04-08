<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->enum('lokasi', [
                'ruang_kelas','toilet','kantin','perpustakaan',
                'laboratorium','lapangan','mushola','parkiran',
                'koridor','lainnya'
            ]);
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('photo')->nullable();
            $table->enum('status', ['menunggu','proses','selesai'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirations');
    }
};
