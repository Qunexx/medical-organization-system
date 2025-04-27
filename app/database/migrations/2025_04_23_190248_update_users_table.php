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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'first_name');
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->unsignedBigInteger('telegram_id')->nullable();
            $table->unsignedBigInteger('avatar_id')->nullable();
            $table->boolean('access_telegram_notify')->default(false);
            $table->boolean('access_email_notify')->default(false);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('first_name', 'name');
            $table->dropColumn([
                'last_name',
                'middle_name',
                'address_id',
                'phone',
                'birthday',
                'telegram_id',
                'avatar_id',
                'access_telegram_notify',
                'access_email_notify',
                'deleted_at'
            ]);
        });
    }
};  // Correct closure: only ONE '};' at the end
