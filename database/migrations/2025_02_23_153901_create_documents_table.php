<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('documents', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('room_id');
        $table->unsignedBigInteger('uploaded_by');
        $table->string('file_name');
        $table->string('file_path');
        $table->timestamps();

        // Foreign keys
        $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
