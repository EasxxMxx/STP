<!DOCTYPE html>
<html>
<head>
    <title>Application Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333333;
            background-color: #f8f9fa;
            padding: 20px;
        }
        h1 {
            color: #FF0000;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            line-height: 1.8;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #777777;
            text-align: center;
        }
        .signature {
            font-weight: bold;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Application Status Update</h1>

        <p>Dear <?php echo e($studentName); ?>,</p>

        <p>We regret to inform you that your application for the <?php echo e($courseName); ?> program at <?php echo e($schoolName); ?> through StudyPal was not successful.</p>

        <p>We understand this may be disappointing news, but we encourage you to continue pursuing your academic goals. We appreciate your interest in our institution and the effort you put into your application.</p>

        <p>Below are the details of your acceptance:</p>

        <ul>
            <li><strong>Program:</strong> <?php echo e($courseName); ?></li>
            <li><strong>School:</strong> <?php echo e($schoolName); ?></li>
            <li><strong>Feedback:</strong> <?php echo e($feedback); ?></li>
        </ul>

        <p>Thank you for considering <?php echo e($schoolName); ?>. We wish you all the best in your future endeavors.</p>

        <p class="signature">Best regards,<br/>
        <?php echo e($schoolName); ?> Admissions Team</p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\studypal\STP\resources\views/emails/rejection.blade.php ENDPATH**/ ?>