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
    Schema::create('reported_replies', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke ID reply yang dilaporkan
        $table->foreignId('reply_id')->constrained()->onDelete('cascade');
        $table->string('reason'); // Alasan pelaporan, misal: "Spam", "Hate Speech"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reported_replies');
    }
};
