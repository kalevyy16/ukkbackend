<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('birth_date')->nullable()->after('password');
            $table->string('phone')->nullable()->after('birth_date');
            $table->string('profile_photo')->nullable()->after('phone');
            $table->string('address')->nullable()->after('profile_photo');
            $table->string('job')->nullable()->after('address');
            $table->boolean('onboarding_completed')->default(false)->after('job');
            $table->string('saving_mode')->nullable()->after('onboarding_completed');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'birth_date', 'phone', 'profile_photo',
                'address', 'job', 'onboarding_completed', 'saving_mode',
            ]);
        });
    }
};