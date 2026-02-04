<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Applicant Received</title>
    <!-- Google Sans isn't available via Google Fonts; we use it as primary font with safe fallbacks -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700&display=swap" rel="stylesheet">
    <style>
        .button {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            background-color: #B71A18;
            color: white !important;
            border: 1px solid #B71A18;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        /* Reused header styles */
        .apply_course_header {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f2f2f2;
        }
        .header_left, .header_right {
            width: 50%;
            vertical-align: middle;
        }
        .logo_img {
            height: 40px;
            width: auto;
            display: block;
        }
        .tagline_text {
            font-family: 'Google Sans', Arial, sans-serif;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
            line-height: 1.4;
            text-align: right;
        }
        .tagline_red { color: #B71A18; }
        .tagline_black { color: #000000; }
        /* Card + details styles (reused from applyCourseEmail) */
        .details_card {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: none;
        }
        /* School email specific applicant details card */
        .school_applicant_details_card {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
        }
        .details_title {
            font-family: 'Google Sans', Arial, sans-serif;
            font-weight: 600;
            font-size: 20px;
            color: #000000;
            margin: 0 0 4px 0;
        }
        .details_subtitle {
            font-family: 'Google Sans', Arial, sans-serif;
            font-weight: 400;
            font-size: 13px;
            color: #6b6b6b;
            margin: 0 0 16px 0;
        }
        .details_table {
            width: 100%;
            border-collapse: collapse;
        }
        .details_table td {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            font-family: 'Google Sans', Arial, sans-serif;
            font-size: 15px;
            color: #000000;
        }
        .details_label {
            color: #6b6b6b;
            width: 40%;
        }
        /* Hero styles for school email */
        .hero_outer_card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        .hero_table {
            width: 100%;
            border-collapse: collapse;
        }
        .hero_left {
            width: 55%;
            padding: 30px 30px 30px 30px;
            background: linear-gradient(135deg, #C62828, #B71A18);
        }
        .hero_right {
            width: 45%;
            padding: 0;
        }
        .hero_image_wrapper {
            width: 100%;
            height: 100%;
            background-image: url('https://backendstudypal.studypal.my/storage/assets/newApplicant.webp');
            background-size: cover;
            background-position: center;
        }
        .hero_title {
            font-family: 'Google Sans', Arial, sans-serif;
            font-weight: 700;
            font-size: 22px;
            color: #ffffff;
            margin: 0 0 12px 0;
        }
        .hero_text {
            font-family: 'Google Sans', Arial, sans-serif;
            font-weight: 400;
            font-size: 14px;
            color: #ffffff;
            margin: 0;
            line-height: 1.6;
        }
    </style>
</head>
<body style="font-family: 'Google Sans', Arial, sans-serif; line-height: 1.6; color: #000000; background-color: #f2f2f2; margin: 0; padding: 0;">
    <table style="width: 100%; max-width: 600px; margin: 0 auto; border-collapse: collapse; background-color: #f2f2f2;">
        <!-- Header Section: apply_course_header -->
        <tr>
            <td class="apply_course_header" style="background-color: #f2f2f2;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <!-- Left Container (50%): StudyPal Logo -->
                        <td class="header_left" style="width: 50%; padding-bottom: 10px; vertical-align: middle;">
                            <img src="https://backendstudypal.studypal.my/storage/assets/studypal.png" alt="StudyPal Logo" class="logo_img" style="height: 40px; width: auto; display: block;">
                        </td>
                        <!-- Right Container (50%): Tagline -->
                        <td class="header_right" style="width: 50%; vertical-align: middle; text-align: right;">
                            <div class="tagline_text" style="font-family: 'Google Sans', Arial, sans-serif; font-weight: bold; font-size: 14px; letter-spacing: 1px; line-height: 1.4; text-align: right;">
                                <span class="tagline_red" style="color: #B71A18;">RECEIVE.</span>
                                <span class="tagline_black" style="color: #000000;"> REVIEW.</span>
                                <span class="tagline_red" style="color: #B71A18;"> RECRUIT.</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Content Wrapper: Hero + Application Details + Bottom Instruction -->
        <tr>
            <td style="padding: 0 0 20px 0;">
                <div style="background-color: #ffffff; border-radius: 16px; padding: 24px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">

                    <!-- Hero Image Section -->
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 0; height: 470px; background-image: url('https://backendstudypal.studypal.my/storage/assets/newApplicant.webp'); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 16px;">
                                &nbsp;
                            </td>
                        </tr>
                    </table>

                    <!-- Intro Text -->
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="height: 40px; line-height: 18px; font-size: 1px;">&nbsp;</td>
                        </tr>
                    </table>
                    <div style="padding: 10px 6px 18px 6px;">
                        <p style="font-family: 'Google Sans', Arial, sans-serif; font-weight: 400; font-size: 16px; color: #000000; margin: 0; text-align: center; line-height: 1.6;">
                            Dear <span style="font-weight: 700;"><?php echo e($institute_name); ?></span>,<br>
                            A new student has applied for one of your courses through our platform. Please review the application details below.
                        </p>
                    </div>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="height: 40px; line-height: 18px; font-size: 1px;">&nbsp;</td>
                        </tr>
                    </table>

                    <!-- Application Details (reused structure from applyCourseEmail) -->
                    <div class="school_applicant_details_card" style="margin-bottom: 16px;">
                    <h3 class="details_title">Applicant Details</h3>
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
                        <tr>
                            <td class="details_subtitle" style="text-align: left; padding: 0; border: none;">Applied on <?php echo e($application_date); ?></td>
                            <td style="text-align: right; padding: 0; border: none;">
                                <a href="<?php echo e($actionUrl); ?>" class="button" target="_blank" style="padding: 6px 30px; font-size: 13px; border-radius: 50px; background-color: #B71A18; border: 1px solid #B71A18; color: #ffffff !important; text-decoration: none; display: inline-block; margin-top: 0;">
                                    View Detailed Application
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 10px 0 0 0; border-bottom: 1px solid #f0f0f0;"></td>
                        </tr>
                    </table>
                    <table class="details_table">
                        <tr>
                            <td class="details_label" style="text-align: left;">Applicant Name</td>
                            <td style="text-align: right; font-weight: 500;"><?php echo e($student_name); ?></td>
                        </tr>
                        <tr>
                            <td class="details_label" style="text-align: left;">Email Address</td>
                            <td style="text-align: right; font-weight: 500;">
                                <?php echo e(str_repeat('*', strlen($student_email) - strpos($student_email, '@')) . substr($student_email, strpos($student_email, '@'))); ?>

                            </td>
                        </tr>
                        <tr>
                            <td class="details_label" style="text-align: left;">Phone Number</td>
                            <td style="text-align: right; font-weight: 500;">
                                <?php echo e('+' . str_repeat('*', strlen($student_phone) - 5) . substr($student_phone, -5)); ?>

                            </td>
                        </tr>
                        <tr>
                            <td class="details_label" style="text-align: left;">Course Applied For</td>
                            <td style="text-align: right; font-weight: 500;"><?php echo e($course_name); ?></td>
                        </tr>
                    </table>
                    </div>

                    <!-- Bottom Instruction Text -->
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="height: 18px; line-height: 18px; font-size: 1px;">&nbsp;</td>
                        </tr>
                    </table>
                    <div style="padding: 14px 4px 18px 4px;">
                        <p style="font-family: 'Google Sans'; font-weight: 400; font-size: 16px; color: #000000; margin: 0; text-align: center;">
                            Please review the application at your earliest convenience. You can access the full application and any supporting documents through your
                            <a href="<?php echo e($actionUrl); ?>" style="color: #B71A18; text-decoration: underline;">Studypal Dashboard</a>.
                        </p>
                    </div>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="height: 18px; line-height: 18px; font-size: 1px;">&nbsp;</td>
                        </tr>
                    </table>

                </div>
            </td>
        </tr>

        <!-- Email Footer Section (reused from welcomeEmail.blade.php) -->
        <tr>
            <td style="padding: 40px 20px 0 20px; background-color: #f2f2f2;"> 
                <!-- Help Information -->
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                    <tr>
                        <td style="text-align: center; padding: 0;">
                            <h3 style="font-family: 'Google Sans', Arial, sans-serif; font-weight: 600; font-size: 18px; color: #000000; margin: 0 0 15px 0;">
                                Need Help?
                            </h3>
                            <p style="font-family: 'Google Sans', Arial, sans-serif; font-weight: 400; font-size: 14px; color: #636363; margin: 5px 0;">
                                Email: <a href="mailto:imediamyy@gmail.com" style="color: #B71A18; text-decoration: underline;">imediamyy@gmail.com</a>
                            </p>
                            <p style="font-family: 'Google Sans', Arial, sans-serif; font-weight: 400; font-size: 14px; color: #636363; margin: 5px 0;">
                                Phone: <a href="tel:+60135538976" style="color: #636363; text-decoration: none;">+6013 5538976</a>
                            </p>
                        </td>
                    </tr>
                </table>
                
                <!-- Social Media Icons -->
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                    <tr>
                        <td style="text-align: center; padding: 0;">
                            <a href="https://studypal.my" style="display: inline-block; margin: 0 15px; text-decoration: none;">
                                <img src="https://backendstudypal.studypal.my/storage/assets/website.png" alt="Website" style="width: 32px; height: 32px; display: block;">
                            </a>
                            <a href="https://www.facebook.com/studypal.my" style="display: inline-block; margin: 0 15px; text-decoration: none;">
                                <img src="https://backendstudypal.studypal.my/storage/assets/facebook.png" alt="Facebook" style="width: 32px; height: 32px; display: block;">
                            </a>
                            <a href="https://www.instagram.com/studypal.my?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" style="display: inline-block; margin: 0 15px; text-decoration: none;">
                                <img src="https://backendstudypal.studypal.my/storage/assets/instagram.png" alt="Instagram" style="width: 32px; height: 32px; display: block;">
                            </a>
                        </td>
                    </tr>
                </table>
                
                <!-- Footer Text -->
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="text-align: center; padding: 20px;">
                            <p style="font-family: 'Google Sans', Arial, sans-serif; font-weight: 400; font-size: 12px; color: #636363; margin: 5px 0;">
                                © <?php echo e(date('Y')); ?> Studypal. All rights reserved.
                            </p>
                            <p style="font-family: 'Google Sans', Arial, sans-serif; font-weight: 400; font-size: 12px; color: #636363; margin: 5px 0;">
                                Lot 3493, No. 13 2nd Floor, Jalan Piasau, Piasau Commercial, 98000 Miri, Sarawak
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\xamppp\htdocs\studypal1\STP\resources\views/emails/schoolEmail.blade.php ENDPATH**/ ?>