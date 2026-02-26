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
        Schema::table('stp_students', function (Blueprint $table) {
            $table->integer('otp')->nullable()->after('student_status');
            $table->datetime('otp_expired_time')->nullable()->after('otp');
            $table->integer('otp_status')->default(0)->after('otp_expired_time'); // 0 = not verified, 1 = verified
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stp_students', function (Blueprint $table) {
            $table->dropColumn(['otp', 'otp_expired_time', 'otp_status']);
        });
    }
};
