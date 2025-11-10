<!DOCTYPE html>
<html>
<head>
    <title>Congratulations! You've Been Accepted</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #28a745; /* Green color */
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            background-color: #f9f9f9;
            margin-bottom: 10px;
            padding: 10px;
            border-left: 4px solid #007BFF;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Congratulations! You've Been Accepted</h1>
        <p>Dear <?php echo e($studentName); ?>,</p>

        <p>Congratulations! We are pleased to inform you that you have been accepted into the <strong><?php echo e($courseName); ?></strong> program at <strong><?php echo e($schoolName); ?></strong> through StudyPal.</p>

        <p>We were impressed by your application and are excited to welcome you to our community. Below are the details of your Applicant:</p>

        <ul>
            <li><strong>Program:</strong> <?php echo e($courseName); ?></li>
            <li><strong>School:</strong> <?php echo e($schoolName); ?></li>
            <li><strong>Feedback:</strong> <?php echo e($feedback); ?></li>


        </ul>

        <p>We look forward to seeing you soon and wish you all the best as you begin this exciting journey!</p>

        <p>Best regards,<br/>
        <?php echo e($schoolName); ?> Admissions Team</p>

        <p class="footer">This email was sent by StudyPal. If you have any questions, please contact our support team.</p>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\studypal\STP\resources\views/emails/acceptance.blade.php ENDPATH**/ ?>