<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to StudyPal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .button {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white !important;
            border: 1px solid #4CAF50;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        /* Email-safe styles */
        .registered_email_header {
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
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
            line-height: 1.4;
            text-align: right;
        }
        .tagline_red {
            color: #B71A18;
        }
        .tagline_black {
            color: #000000;
        }
        .welcome_container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 20px;
        }
        .welcome_image_container {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            width: 100%;
        }
        .welcome_image {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 12px;
        }
        .welcome_text_overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 0 0 12px 12px;
        }
        .welcome_title {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            font-weight: bold;
            font-size: 24px;
            color: #B71A18;
            margin: 0 0 8px 0;
        }
        .welcome_subtitle {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            font-weight: 400;
            font-size: 16px;
            color: #000000;
            margin: 0;
        }
        /* Prevent text truncation in email clients */
        .welcome_text_overlay * {
            max-height: none !important;
            overflow: visible !important;
            text-overflow: clip !important;
            white-space: normal !important;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f2f2f2; margin: 0; padding: 0;">
    <table style="width: 100%; max-width: 600px; margin: 0 auto; border-collapse: collapse; background-color: #f2f2f2;">
        <!-- Header Section: registered_email_header -->
        <tr>
            <td class="registered_email_header" style="background-color: #f2f2f2;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <!-- Left Container (50%): StudyPal Logo -->
                        <td class="header_left" style="width: 50%; padding-bottom: 10px; vertical-align: middle;">
                            <img src="https://backendstudypal.studypal.my/storage/assets/studypal.png" alt="StudyPal Logo" class="logo_img" style="height: 40px; width: auto; display: block;">
                        </td>
                        <!-- Right Container (50%): Tagline -->
                        <td class="header_right" style="width: 50%; vertical-align: middle; text-align: right;">
                            <div class="tagline_text" style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: bold; font-size: 14px; letter-spacing: 1px; line-height: 1.4; text-align: right;">
                                <span class="tagline_red" style="color: #B71A18;">DISCOVER.</span>
                                <span class="tagline_black" style="color: #000000;"> APPLY.</span>
                                <span class="tagline_red" style="color: #B71A18;"> CONNECT</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Welcome Section -->
        <tr>
            <td class="welcome_container" style="padding: 0; background-image: url('https://backendstudypal.studypal.my/storage/assets/welcome.webp'); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 12px; height: 500px; position: relative;">
                <!-- Text Content Inside Container -->
                <table style="width: 100%; border-collapse: collapse; height: 100%;">
                    <tr>
                        <td style="vertical-align: bottom; padding: 0; padding-bottom: 50px;">
                            <table style="width: 70%; border-collapse: collapse;">
                                <tr>
                                    <td class="welcome_text_overlay" style="background: #ffffff; padding: 40px; border-radius: 12px;">
                                        <h2 class="welcome_title" style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: bold; font-size: 24px; color: #B71A18; margin: 0 0 8px 0; overflow: visible; word-wrap: break-word;">
                                            Welcome, <?php echo e($student_name); ?>!
                                        </h2>
                                        <p class="welcome_subtitle" style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 16px; color: #000000; margin: 0; white-space: normal; overflow: visible;">
                                            Your account is ready to go
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Spacer row for section spacing -->
        <tr>
            <td style="height: 40px; line-height: 40px; font-size: 1px;">&nbsp;</td>
        </tr>
        <!-- What's waiting for you Section -->
        <tr>
            <td style="padding: 40px 20px; background-color: #ffffff; border-radius: 12px;">
                <!-- Section Title -->
                <h2 style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 28px; color: #000000; text-align: left; margin: 0 0 30px 0; padding: 0;">
                    What's waiting for you
                </h2>
                
                <!-- Row 1 -->
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <tr>
                        <!-- Row 1 - Left Container (50%) with vertical split -->
                        <td style="width: 50%; padding-right: 10px; vertical-align: top;">
                            <table style="width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 12px; overflow: hidden;">
                                <!-- Top container (60% height) -->
                                <tr>
                                    <td style="height: 60%; padding: 0; line-height: 0; background-image: url('https://backendstudypal.studypal.my/storage/assets/waiting1.webp'); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 12px;">
                                        <a href="https://studypal.my/courses" style="display: block; height: 150px; border-radius: 12px; text-decoration: none;"></a>
                                    </td>
                                </tr>
                                <!-- Bottom container (40% height) -->
                                <tr>
                                    <td style="height: 40%; padding: 20px; background-color: #ffffff;">
                                        <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: bold; font-size: 16px; color: #B71A18; margin: 0;">
                                            <a href="https://studypal.my/courses" style="color: #B71A18; text-decoration: none;">Explore Thousands of Courses</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <!-- Row 1 - Right Container (50%) single -->
                        <td style="width: 50%; padding-left: 10px; vertical-align: top; background-color: #000000; border-radius: 12px; padding: 30px;">
                            <table style="width: 100%; border-collapse: collapse; height: 200px;">
                                <tr>
                                    <td style="vertical-align: top; padding: 0;">
                                        <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 16px; color: #ffffff; margin: 0;">
                                            Browse programs from top universities across Australia, New Zealand, and beyond.
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 100%;">
                                    <td style="padding: 0; height: 100%;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0; text-align: right; vertical-align: bottom;">
                                        <a href="https://studypal.my/courses" style="color: #ffffff; text-decoration: none; font-size: 24px; line-height: 1;">→</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <!-- Row 2 -->
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <tr>
                        <!-- Row 2 - Left Container (50%) single -->
                        <td style="width: 50%; padding-right: 10px; vertical-align: top; background-color: #000000; border-radius: 12px; padding: 30px;">
                            <table style="width: 100%; border-collapse: collapse; height: 200px;">
                                <tr>
                                    <td style="vertical-align: top; padding: 0;">
                                        <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 16px; color: #ffffff; margin: 0;">
                                            Submit applications to universities across the globe quickly and easily through one platform.
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 100%;">
                                    <td style="padding: 0; height: 100%;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0; text-align: right; vertical-align: bottom;">
                                        <a href="https://studypal.my/institute" style="color: #ffffff; text-decoration: none; font-size: 24px; line-height: 1;">→</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <!-- Row 2 - Right Container (50%) with vertical split -->
                        <td style="width: 50%; padding-left: 10px; vertical-align: top;">
                            <table style="width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 12px; overflow: hidden;">
                                <!-- Top container (60% height) -->
                                <tr>
                                    <td style="height: 60%; padding: 0; line-height: 0; background-image: url('https://backendstudypal.studypal.my/storage/assets/waiting2.webp'); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 12px;">
                                        <a href="https://studypal.my/institute" style="display: block; height: 150px; border-radius: 12px; text-decoration: none;"></a>
                                    </td>
                                </tr>
                                <!-- Bottom container (40% height) -->
                                <tr>
                                    <td style="height: 40%; padding: 20px; background-color: #ffffff;">
                                        <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: bold; font-size: 16px; color: #B71A18; margin: 0;">
                                            <a href="https://studypal.my/institute" style="color: #B71A18; text-decoration: none;">Discover & Apply to Multiple Schools</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <!-- Row 3 -->
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <!-- Row 3 - Left Container (50%) with vertical split -->
                        <td style="width: 50%; padding-right: 10px; vertical-align: top;">
                            <table style="width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 12px; overflow: hidden;">
                                <!-- Top container (60% height) -->
                                <tr>
                                    <td style="height: 60%; padding: 0; line-height: 0; background-image: url('https://backendstudypal.studypal.my/storage/assets/waiting3.webp'); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 12px;">
                                        <a href="https://studypal.my/studentStudyPath" style="display: block; height: 150px; border-radius: 12px; text-decoration: none;"></a>
                                    </td>
                                </tr>
                                <!-- Bottom container (40% height) -->
                                <tr>
                                    <td style="height: 40%; padding: 20px; background-color: #ffffff;">
                                        <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: bold; font-size: 16px; color: #B71A18; margin: 0;">
                                            <a href="https://studypal.my/studentStudyPath" style="color: #B71A18; text-decoration: none;">Find Your Path</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <!-- Row 3 - Right Container (50%) single -->
                        <td style="width: 50%; padding-left: 10px; vertical-align: top; background-color: #000000; border-radius: 12px; padding: 30px;">
                            <table style="width: 100%; border-collapse: collapse; height: 200px;">
                                <tr>
                                    <td style="vertical-align: top; padding: 0;">
                                        <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 16px; color: #ffffff; margin: 0;">
                                            Take our career assessment to discover which courses align with your personality and interests.
                                        </p>
                                    </td>
                                </tr>
                                <tr style="height: 100%;">
                                    <td style="padding: 0; height: 100%;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0; text-align: right; vertical-align: bottom;">
                                        <a href="https://studypal.my/studentStudyPath" style="color: #ffffff; text-decoration: none; font-size: 24px; line-height: 1;">→</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- Email Footer Section -->
        <tr>
            <td style="padding: 40px 20px 0 20px; background-color: #f2f2f2;">
                <!-- Primary CTA Button -->
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 40px;">
                    <tr>
                        <td style="text-align: center; padding: 0;">
                            <a href="https://studypal.my/courses" style="display: inline-block; width: 80%; max-width: 400px; background-color: #000000; color: #ffffff; text-decoration: none; padding: 15px 30px; border-radius: 50px; font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 16px; text-align: center;">
                                Explore Courses Now
                            </a>
                        </td>
                    </tr>
                </table>
                
                <!-- Help Information -->
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                    <tr>
                        <td style="text-align: center; padding: 0;">
                            <h3 style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 600; font-size: 18px; color: #000000; margin: 0 0 15px 0;">
                                Need Help?
                            </h3>
                            <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 14px; color: #636363; margin: 5px 0;">
                                Email: <a href="mailto:imediamyy@gmail.com" style="color: #B71A18; text-decoration: underline;">imediamyy@gmail.com</a>
                            </p>
                            <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 14px; color: #636363; margin: 5px 0;">
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
                    <tr>
                        <td style="text-align: center; padding: 20px;">
                            <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 12px; color: #636363; margin: 5px 0;">
                                © <?php echo e(date('Y')); ?> Studypal. All rights reserved.
                            </p>
                            <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 12px; color: #636363; margin: 5px 0;">
                                Lot 3493, No. 13 2nd Floor, Jalan Piasau, Piasau Commercial, 98000 Miri, Sarawak
                            </p>
                        </td>
                    </tr>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\studypal\STP\resources\views/emails/welcomeEmail.blade.php ENDPATH**/ ?>