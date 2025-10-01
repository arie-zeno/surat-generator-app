<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_surat'); // Nama asli file
            $table->string('nama_file');   // Nama file di storage
            $table->string('file');          // Path di storage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
