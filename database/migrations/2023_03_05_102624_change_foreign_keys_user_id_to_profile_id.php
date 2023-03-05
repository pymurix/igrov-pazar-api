<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\User::class);
            $table->dropColumn('user_id');
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')
                ->references('id')
                ->on('user_profiles');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\User::class);
            $table->dropColumn('user_id');
            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')
                ->references('id')
                ->on('user_profiles');
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Profile::class);
            $table->dropColumn('profile_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Profile::class);
            $table->dropColumn('profile_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }
};
