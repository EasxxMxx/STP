<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE stp_user_otps MODIFY otp VARCHAR(255)');
        DB::statement('ALTER TABLE stp_student_otps MODIFY otp VARCHAR(255)');
        DB::statement('ALTER TABLE stp_school_otps MODIFY otp VARCHAR(255)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE stp_user_otps MODIFY otp INT');
        DB::statement('ALTER TABLE stp_student_otps MODIFY otp INT');
        DB::statement('ALTER TABLE stp_school_otps MODIFY otp INT');
    }
};
