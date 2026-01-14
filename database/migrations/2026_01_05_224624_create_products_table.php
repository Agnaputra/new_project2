<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori');
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('margin', 5, 2)->comment('Dalam persen');
            $table->decimal('harga_jual', 15, 2);
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(5);
            $table->string('sku')->unique()->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            
            // Index untuk performa query
            $table->index('kategori');
            $table->index('stok');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};