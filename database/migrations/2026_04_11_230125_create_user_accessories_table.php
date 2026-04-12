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
    Schema::create('user_accessories', function (Blueprint $table) {
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('accessory_id')->constrained()->onDelete('cascade');
        $table->boolean('is_equipped')->default(false);
        $table->timestamp('acquired_at')->useCurrent();
        $table->primary(['user_id', 'accessory_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_accessories');
    }
};
