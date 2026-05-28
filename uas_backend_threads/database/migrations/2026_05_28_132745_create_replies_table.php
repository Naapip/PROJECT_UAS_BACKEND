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
    Schema::create('replies', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke user yang membalas (asumsi tabel users bawaan Laravel sudah ada)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Menghubungkan ke thread utama yang dibalas (asumsi tabel threads sudah ada)
        $table->foreignId('thread_id')->constrained()->onDelete('cascade');
        
        // Self-referencing: jika bernilai null artinya ini balasan utama. 
        // Jika berisi ID reply lain, artinya ini balasan di dalam balasan (nested)
        $table->foreignId('parent_reply_id')->nullable()->constrained('replies')->onDelete('cascade');
        
        $table->text('content');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
