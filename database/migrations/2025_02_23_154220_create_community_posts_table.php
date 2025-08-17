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
    Schema::create('community_posts', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('community_id');
        $table->unsignedBigInteger('user_id');
        $table->text('content');
        $table->timestamps();

        // Foreign keys
        $table->foreign('community_id')->references('id')->on('communities')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_posts');
    }
};
