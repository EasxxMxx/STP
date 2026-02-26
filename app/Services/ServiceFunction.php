<?php

namespace App\Services;

use App\Models\stp_school_otp;
use App\Models\stp_student_otp;
use App\Models\stp_user_otp;
use Illuminate\Support\Str;
use App\Mail\OtpMail;
use App\Mail\SendSchoolEmail;
use App\Mail\SendAcceptanceEmail;
use App\Mail\SendRejectEmail;
use App\Mail\SendReminder;
use App\Mail\SendEnquiryEmail;
use App\Mail\ReplyEnquiryEmail;
use App\Mail\SendInterestedCourseCategoryEmail;
use App\Mail\AdminCourseCategoryInterested;
use App\Mail\SendCustomSchoolApplicationAdmin;
use App\Mail\SendWelcomeEmail;
use App\Mail\SendApplyCourseEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ServiceFunction
{
    public function generateOtpAndSendEmail($id, $type, $email)
    {
        $current_time = now()->setTimezone('Asia/Kuala_Lumpur')->addMinutes(5)->format('Y-m-d H:i:s');
        $otp = rand(100000, 999999);
        switch ($type) {
            case "student":
                $createOtp = stp_student_otp::create([
                    'student_id' => $id,
                    'otp' => $otp,
                    'otp_expired_time' => $current_time
                ]);
                break;
            case "school":
                $createOtp = stp_school_otp::create([
                    'school_id' => $id,
                    'otp' => $otp,
                    'otp_expired_time' => $current_time
                ]);
                break;
            case "admin":
                $createOtp = stp_user_otp::create([
                    'user_id' => $id,
                    'otp' => $otp,
                    'otp_expired_time' => $current_time
                ]);
                break;
        }
        Mail::to($email)->send(new OtpMail($otp));
    }


    public function sendEnquiryEmail($fullName, $email, $contact, $emailSubject, $messageContent)
    {

        Mail::to('admin@studypal.my')->send(new SendEnquiryEmail($emailSubject, $fullName, $email, $contact, $messageContent));
    }

    public function replyEnquiryEmail($subject, $email, $messageContent)
    {
        Mail::to($email)->send(new ReplyEnquiryEmail($subject, $messageContent));
    }

    public function sendAppliedCourseEmail($school, $course, $student, $newApplicantId)
    {
        try {
            $institute_email = $school->school_email;
            $data = [
                'institute_name' => $school->school_name,
                'course_name' => $course->course_name,
                'student_name' => $student->student_userName,
                'student_email' => $student->student_email,
                'student_phone' => $student->student_countryCode . " " . $student->student_contactNo,
                'application_date' => now()->format('Y-m-d H:i:s'),
                'actionUrl' => "https://studypal.my/school/ApplicantDetail/" . $newApplicantId // Concatenate the student ID
            ];

            Mail::to($institute_email)->send(new SendSchoolEmail($data));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Internal Server Error",
                'error' => $e->getMessage()
            ]);
        }
    }

    public function notifyAdminCustomSchoolApplication($school, $course, $student)
    {
        try {
            $personInChargeEmail = $school->person_inChargeEmail;
            $data = [
                'institute_name' => $school->school_name,
                'course_name' => $course->course_name,
                'student_name' => $student->student_userName,
                'student_email' => $student->student_email,
                'student_phone' => $student->student_countryCode . " " . $student->student_contactNo,
                'application_date' => now()->format('Y-m-d H:i:s'),
            ];
            Mail::to($personInChargeEmail)->send(new SendCustomSchoolApplicationAdmin($data));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Internal Server Error",
                'error' => $e->getMessage()
            ]);
        }
    }

    public function sendStudentEmail($studentName, $courseName, $schoolName, $studentEmail, $status, $feedback)
    {
        try {
            $data = [
                'studentName' => $studentName,
                'courseName' => $courseName,
                'schoolName' => $schoolName,
                'feedback' => $feedback
            ];
            if ($status == 4) {
                Mail::to($studentEmail)->send(new SendAcceptanceEmail($data));
            } else {
                Mail::to($studentEmail)->send(new SendRejectEmail($data));
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Internal Server Error",
                'error' => $e->getMessage()
            ]);
        }
    }

    public function sendReminder($schoolEmail, $studentName, $courseName, $schoolName, $newApplicantId)
    {
        try {
            $data = [
                'courseName' => $courseName,
                'studentName' => $studentName,
                'schoolName' => $schoolName,
                // 'reviewLink' => "http://192.168.0.70:5173/schoolPortalLogin"
                'reviewLink' => "https://studypal.my/school/ApplicantDetail/" . $newApplicantId // Concatenate the student ID

            ];
            Mail::to($schoolEmail)->send(new SendReminder($data));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function sendInterestedCourseCategoryEmail($email, $schoolName, $data, $totalCourse)
    {
        Mail::to($email)->send(new SendInterestedCourseCategoryEmail($schoolName, $data, $totalCourse));
    }

    public function adminCourseCategoryInterested($category, $totalNumber, $schoolEmail, $schoolName)
    {
        Mail::to($schoolEmail)->send(new AdminCourseCategoryInterested($category, $totalNumber, $schoolName));
    }

    public function sendWelcomeEmail($studentName, $studentEmail)
    {
        try {
            // Validate email address
            if (empty($studentEmail) || !filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
                Log::error("Invalid email address for welcome email: {$studentEmail}");
                return false;
            }

            Log::info("Attempting to send welcome email to: {$studentEmail} for student: {$studentName}");
            
            $data = [
                'student_name' => $studentName,
                'student_email' => $studentEmail,
            ];

            // Send email synchronously to ensure it's sent immediately
            Mail::to($studentEmail)->send(new SendWelcomeEmail($data));
            
            Log::info("Welcome email sent successfully to: {$studentEmail} for student: {$studentName}");
            Log::info("Mail driver: " . config('mail.default'));
            Log::info("Mail from: " . config('mail.from.address'));
            
            return true;
        } catch (\Exception $e) {
            // Log the error but don't fail registration if email fails
            Log::error('Failed to send welcome email: ' . $e->getMessage());
            Log::error('Welcome email error stack: ' . $e->getTraceAsString());
            Log::error('Mail configuration - MAILER: ' . config('mail.default'));
            Log::error('Mail configuration - FROM: ' . config('mail.from.address'));
            Log::error('Mail configuration - HOST: ' . config('mail.mailers.smtp.host'));
            return false;
        }
    }

    public function sendCourseApplicationConfirmation($student, $course, $submittedAt)
    {
        try {
            $data = [
                'student_name' => $student->student_userName,
                'course_name' => $course->course_name,
                'school_name' => $course->school->school_name,
                'submitted_at' => $submittedAt->format('F j, Y'),
                'actionUrl' => 'https://studypal.my/studentDashboard'
            ];

            Mail::to($student->student_email)->send(new SendApplyCourseEmail($data));
        } catch (\Exception $e) {
            // Log only; don't block the application flow if email fails
            Log::error('Failed to send course application confirmation: ' . $e->getMessage());
        }
    }

    /**
     * Send OTP via SMS
     * This is a placeholder function - replace with actual SMS service implementation
     * 
     * @param string $phoneNumber Full phone number with country code (e.g., +60123456789)
     * @param int $otp The OTP code to send
     * @return bool
     */
    public function sendOtpSms($phoneNumber, $otp)
    {
        try {
            // TODO: Replace with actual SMS service (e.g., Twilio, Nexmo, etc.)
            // For now, just log the OTP for development purposes
            Log::info("SMS OTP for {$phoneNumber}: {$otp}");
            
            // Example implementation with HTTP client (uncomment and configure when ready):
            /*
            $response = Http::post('YOUR_SMS_API_ENDPOINT', [
                'phone' => $phoneNumber,
                'message' => "Your StudyPal OTP is: {$otp}. Valid for 5 minutes.",
                'api_key' => env('SMS_API_KEY')
            ]);
            
            return $response->successful();
            */
            
            // For development, return true
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send SMS OTP: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send OTP via Email for registration
     * 
     * @param string $email The recipient email address
     * @param int $otp The OTP code to send
     * @param string $purpose The purpose of the OTP (e.g., 'registration', 'password_reset')
     * @return bool
     */
    public function sendOtpEmail($email, $otp, $purpose = 'registration')
    {
        try {
            Mail::to($email)->send(new OtpMail($otp, $purpose));
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send OTP email: ' . $e->getMessage());
            return false;
        }
    }
}
