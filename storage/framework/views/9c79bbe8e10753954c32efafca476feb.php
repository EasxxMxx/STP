<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter - StudyPal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
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
        .apply_course_header {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f2f2f2;
        }
        .header_left, .header_right { width: 50%; vertical-align: middle; }
        .logo_img { height: 40px; width: auto; display: block; }
        .tagline_text {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
            line-height: 1.4;
            text-align: right;
        }
        .tagline_red { color: #B71A18; }
        .tagline_black { color: #000000; }
        .apply_container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 0;
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
        .details_card {
            background: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: none;
        }
        .details_title {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            font-weight: 600;
            font-size: 20px;
            color: #000000;
            margin: 0 0 4px 0;
        }
        .details_subtitle {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            font-weight: 400;
            font-size: 13px;
            color: #6b6b6b;
            margin: 0 0 16px 0;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f2f2f2; margin: 0; padding: 0;">
    <table style="width: 100%; max-width: 600px; margin: 0 auto; border-collapse: collapse; background-color: #f2f2f2;">
        <!-- Header: same as applyCourseEmail -->
        <tr>
            <td class="apply_course_header" style="background-color: #f2f2f2;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td class="header_left" style="width: 50%; padding-bottom: 10px; vertical-align: middle;">
                            <img src="https://backendstudypal.studypal.my/storage/assets/studypal.png" alt="StudyPal Logo" class="logo_img" style="height: 40px; width: auto; display: block;">
                        </td>
                        <td class="header_right" style="width: 50%; vertical-align: middle; text-align: right;">
                            <div class="tagline_text" style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: bold; font-size: 14px; letter-spacing: 1px; line-height: 1.4; text-align: right;">
                                <span class="tagline_red" style="color: #B71A18;">DISCOVER.</span>
                                <span class="tagline_black" style="color: #000000;"> APPLY.</span>
                                <span class="tagline_red" style="color: #B71A18;"> CONNECT.</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Hero: newsletter image + overlay (same logic as applyCourseEmail hero) -->
        <tr>
            <td class="apply_container" style="padding: 0; background-image: url('https://backendstudypal.studypal.my/storage/assets/newsLetter.webp'); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 12px 12px 0 0; height: 360px; position: relative; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <table style="width: 100%; border-collapse: collapse; height: 100%;">
                    <tr>
                        <td style="vertical-align: bottom; padding: 0; padding-bottom: 40px;">
                            <table style="width: 70%; border-collapse: collapse;">
                                <tr>
                                    <td class="welcome_text_overlay" style="background: #ffffff; padding: 28px; border-radius: 12px;">
                                        <h2 class="welcome_title" style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: bold; font-size: 24px; color: #B71A18; margin: 0 0 8px 0;">
                                            StudyPal Newsletter
                                        </h2>
                                        <p class="welcome_subtitle" style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 16px; color: #000000; margin: 0;">
                                            Latest Guides &amp; Updates
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Intro text block -->
        <tr>
            <td style="background: #ffffff; border-radius: 0 0 12px 12px; padding: 30px; text-align: center; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);">
                <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 16px; color: #000000; margin: 0;">
                    Subscribe with your Gmail to get our monthly newsletter: latest articles, upcoming intakes, and recommended reads.
                </p>
            </td>
        </tr>

        <tr><td style="height: 30px; line-height: 30px; font-size: 1px;">&nbsp;</td></tr>

        <!-- What you get (same card style as applyCourseEmail) -->
        <tr>
            <td style="padding: 0 0 20px 0;">
                <div class="details_card">
                    <h3 class="details_title">What you get</h3>
                    <p class="details_subtitle" style="margin-bottom: 20px;">Monthly edition delivered to your inbox.</p>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-size: 15px; color: #000000;">Latest Articles</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-size: 15px; color: #000000;">Upcoming Intake</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-size: 15px; color: #000000;">Recommended Reads</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

        <tr><td style="height: 30px; line-height: 30px; font-size: 1px;">&nbsp;</td></tr>

        <!-- CTA: Subscribe (same button style as applyCourseEmail) -->
        <tr>
            <td style="padding: 0 0 20px 0;">
                <div class="details_card" style="text-align: center;">
                    <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 16px; color: #000000; margin: 0 0 20px 0;">Subscribe on our website to start receiving the newsletter.</p>
                    <a href="https://studypal.my" class="button" style="padding: 12px 24px; font-size: 16px; border-radius: 50px; background-color: #B71A18; border: 1px solid #B71A18; color: #ffffff !important; text-decoration: none; display: inline-block;">Go to StudyPal</a>
                </div>
            </td>
        </tr>

        <!-- Footer: same as applyCourseEmail -->
        <tr>
            <td style="padding: 40px 20px 0 20px; background-color: #f2f2f2;">
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 40px;">
                    <tr>
                        <td style="text-align: center; padding: 0;">
                            <a href="https://studypal.my/courses" style="display: inline-block; width: 80%; max-width: 400px; background-color: #000000; color: #ffffff; text-decoration: none; padding: 15px 30px; border-radius: 50px; font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 16px; text-align: center;">
                                Explore More Courses
                            </a>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                    <tr>
                        <td style="text-align: center; padding: 0;">
                            <h3 style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 600; font-size: 18px; color: #000000; margin: 0 0 15px 0;">Need Help?</h3>
                            <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 14px; color: #636363; margin: 5px 0;">
                                Email: <a href="mailto:imediamyy@gmail.com" style="color: #B71A18; text-decoration: underline;">imediamyy@gmail.com</a>
                            </p>
                            <p style="font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-weight: 400; font-size: 14px; color: #636363; margin: 5px 0;">
                                Phone: <a href="tel:+60135538976" style="color: #636363; text-decoration: none;">+6013 5538976</a>
                            </p>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                    <tr>
                        <td style="text-align: center; padding: 0;">
                            <a href="https://studypal.my" style="display: inline-block; margin: 0 15px; text-decoration: none;">
                                <img src="https://backendstudypal.studypal.my/storage/assets/website.png" alt="Website" style="width: 32px; height: 32px; display: block;">
                            </a>
                            <a href="https://www.facebook.com/studypal.my" style="display: inline-block; margin: 0 15px; text-decoration: none;">
                                <img src="https://backendstudypal.studypal.my/storage/assets/facebook.png" alt="Facebook" style="width: 32px; height: 32px; display: block;">
                            </a>
                            <a href="https://www.instagram.com/studypal.my" style="display: inline-block; margin: 0 15px; text-decoration: none;">
                                <img src="https://backendstudypal.studypal.my/storage/assets/instagram.png" alt="Instagram" style="width: 32px; height: 32px; display: block;">
                            </a>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%; border-collapse: collapse;">
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
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\xamppp\htdocs\studypal1\STP\resources\views/newsletter.blade.php ENDPATH**/ ?>