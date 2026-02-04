<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyPal Newsletter</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #F5F4EF; -webkit-font-smoothing: antialiased;">
    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #F5F4EF;">
        <tr>
            <td align="center" style="padding: 24px 16px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" style="max-width: 600px; width: 100%;">
                    
                    <tr>
                        <td style="background-color: #F5F4EF; padding: 16px 0;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="width: 50%; padding-bottom: 10px; vertical-align: middle;">
                                        <img src="https://backendstudypal.studypal.my/storage/assets/studypal.png" alt="StudyPal Logo" style="height: 40px; width: auto; display: block;">
                                    </td>
                                    <td style="width: 50%; vertical-align: middle; text-align: right;">
                                        <p style="margin: 0; font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 14px; letter-spacing: 1px; line-height: 1.4; text-align: right; color: #B71A18;">DISCOVER. APPLY. CONNECT.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 20px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #FFFFFF; border: 1px solid #EEEEEE; border-radius: 12px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 0; background-image: url('https://backendstudypal.studypal.my/storage/assets/newsLetter.webp'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 480px; vertical-align: bottom;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="height: 100%;">
                                            <tr>
                                                <td style="vertical-align: bottom; padding: 0 0 40px 24px;">
                                                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="width: 70%; max-width: 340px;">
                                                        <tr>
                                                            <td style="background-color: #ffffff; padding: 24px 28px; border-radius: 12px;">
                                                                <p style="margin: 0 0 8px 0; font-size: 12px; font-weight: 600; color: #666666; letter-spacing: 0.5px; text-transform: uppercase;"><?php echo e(isset($sendDate) && $sendDate ? \Carbon\Carbon::parse($sendDate)->format('F Y') : now()->format('F Y')); ?> Edition</p>
                                                                <p style="margin: 0 0 8px 0; font-size: 24px; font-weight: bold; color: #B71A18; font-family: Arial, Helvetica, sans-serif;">Studypal Newsletter</p>
                                                                <p style="margin: 0; font-size: 15px; color: #666666; font-family: Arial, Helvetica, sans-serif;">Latest guides &amp; updates</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-bottom: 20px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #FFFFFF; border: 1px solid #EEEEEE; border-radius: 12px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 16px 16px 8px 16px;">
                                        <p style="margin: 0; font-size: 18px; font-weight: bold; color: #111111; text-align: center;">Latest Articles</p>
                                    </td>
                                </tr>
                                <?php if(!empty($latestArticle)): ?>
                                    <tr>
                                        <td style="padding: 0;">
                                            
                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td style="height: 6px; background-color: #B71A18; line-height: 0; font-size: 0;">&nbsp;</td></tr></table>
                                            <?php if(!empty($latestArticle['image'])): ?>
                                                <a href="<?php echo e($latestArticle['link']); ?>" style="text-decoration: none; display: block;">
                                                    <img src="<?php echo e($latestArticle['image']); ?>" alt="<?php echo e($latestArticle['title']); ?>" width="600" style="width: 100%; max-width: 600px; height: auto; display: block; vertical-align: top;">
                                                </a>
                                            <?php endif; ?>
                                            
                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td style="height: 6px; background-color: #B71A18; line-height: 0; font-size: 0;">&nbsp;</td></tr></table>
                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td style="padding: 16px 16px 8px 16px;">
                                                        <?php if(!empty($latestArticle['category']) || !empty($latestArticle['author'])): ?>
                                                            <p style="margin: 0 0 10px 0; font-size: 13px; color: #111111;">
                                                                <?php if(!empty($latestArticle['category'])): ?>
                                                                    <span style="color: #666666; text-decoration: none; border-bottom: 1px solid #B71A18;"><?php echo e($latestArticle['category']); ?></span>
                                                                <?php endif; ?>
                                                                <?php if(!empty($latestArticle['category']) && !empty($latestArticle['author'])): ?> <span style="color: #666666;"> / </span> <?php endif; ?>
                                                                <?php if(!empty($latestArticle['author'])): ?>
                                                                    <span style="color: #666666; text-decoration: none; border-bottom: 1px solid #B71A18;">by <?php echo e($latestArticle['author']); ?></span>
                                                                <?php endif; ?>
                                                            </p>
                                                        <?php endif; ?>
                                                        <p style="margin: 0 0 10px 0; font-size: 17px; font-weight: bold; color: #111111; line-height: 1.35;">
                                                            <a href="<?php echo e($latestArticle['link']); ?>" style="color: #111111; text-decoration: none;"><?php echo e($latestArticle['title']); ?></a>
                                                        </p>
                                                        <?php if(!empty($latestArticle['excerpt'])): ?>
                                                            <p style="margin: 0 0 14px 0; font-size: 14px; color: #666666; line-height: 1.5;"><?php echo e($latestArticle['excerpt']); ?></p>
                                                        <?php endif; ?>
                                                        <a href="<?php echo e($latestArticle['link']); ?>" style="display: inline-block; padding: 10px 14px; background-color: #B71A18; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px;">Read More</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>
                                        <td style="padding: 24px 16px; color: #666666; font-size: 14px;">No articles available right now.</td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-bottom: 20px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #FFFFFF; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
                                <tr>
                                    <td style="padding: 24px 20px 16px 20px;">
                                        <p style="margin: 0 0 20px 0; font-size: 20px; font-weight: bold; color: #111111; text-align: center;">Upcoming Intakes</p>
                                        <?php if(!empty($intakes) && count($intakes) > 0): ?>
                                            <?php $__currentLoopData = $intakes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $intake): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($index > 0): ?>
                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td style="height: 14px; line-height: 0; font-size: 0;">&nbsp;</td></tr></table>
                                            <?php endif; ?>
                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #F5F5F5; border-radius: 10px; border: 1px solid #EEEEEE;">
                                                <tr>
                                                    <td style="padding: 16px;">
                                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tr>
                                                                <td style="width: 33%; vertical-align: middle; text-align: center; padding-right: 20px;">
                                                                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" style="background-color: #FFFFFF; border-radius: 10px; padding: 12px;">
                                                                        <tr>
                                                                            <td style="text-align: center;">
                                                                                <?php if(!empty($intake['logo_url'])): ?>
                                                                                    <img src="<?php echo e($intake['logo_url']); ?>" alt="" width="72" height="72" style="width: 72px; height: 72px; max-width: 72px; border-radius: 6px; display: inline-block;">
                                                                                <?php else: ?>
                                                                                    <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center"><tr><td style="width: 72px; height: 72px; border-radius: 6px; background-color: #EEEEEE; line-height: 0; font-size: 0;">&nbsp;</td></tr></table>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                                <td style="width: 67%; vertical-align: middle;">
                                                                    <p style="margin: 0 0 6px 0; font-size: 16px; font-weight: bold; color: #111111;"><?php echo e($intake['university_name'] ?? 'University'); ?></p>
                                                                    <p style="margin: 0 0 12px 0; font-size: 14px; color: #B71A18;"><?php echo e($intake['intake_info'] ?? ''); ?></p>
                                                                    <a href="<?php echo e($intake['link'] ?? ($websiteUrl ?? 'http://localhost:5174') . '/institute'); ?>" style="display: inline-block; padding: 10px 18px; background-color: #B71A18; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px;">View Courses</a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td style="padding: 24px 16px; color: #666666; font-size: 14px; text-align: center;">No intakes listed for this month yet.</td>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-bottom: 20px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #FFFFFF; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
                                <tr>
                                    <td style="padding: 24px 20px;">
                                        <p style="margin: 0 0 20px 0; font-size: 20px; font-weight: bold; color: #111111; text-align: center;">Recommended Reads</p>
                                        <?php if(!empty($recommendedArticles) && count($recommendedArticles) > 0): ?>
                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <?php $__currentLoopData = $recommendedArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $art): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($index > 0): ?>
                                                <tr>
                                                    <td style="padding: 16px 0 0 0; border-top: 1px solid #EEEEEE; line-height: 0; font-size: 0;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 16px 0 0 0;">&nbsp;</td>
                                                </tr>
                                                <?php endif; ?>
                                                <tr>
                                                    <td style="padding: 0 0 16px 0;">
                                                        <p style="margin: 0 0 4px 0; font-size: 15px; font-weight: bold; color: #111111; line-height: 1.4;">
                                                            <a href="<?php echo e($art['link']); ?>" style="color: #111111; text-decoration: none;"><?php echo e($art['title']); ?></a>
                                                        </p>
                                                        <p style="margin: 0; font-size: 13px; color: #999999;">— by <?php echo e($art['author'] ?? 'Studypal'); ?></p>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </table>
                                        <?php else: ?>
                                            <p style="margin: 0; color: #666666; font-size: 14px; text-align: center;">No recommended reads available right now.</p>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px 20px 0 20px; background-color: #F5F4EF;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 40px;">
                                <tr>
                                    <td style="text-align: center; padding: 0;">
                                        <a href="<?php echo e($articlesListUrl ?? 'http://localhost:5174/articles'); ?>" style="display: inline-block; width: 80%; max-width: 400px; background-color: #000000; color: #ffffff; text-decoration: none; padding: 15px 30px; border-radius: 50px; font-family: Arial, Helvetica, sans-serif; font-weight: 400; font-size: 16px; text-align: center;">Explore More Articles</a>
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 30px;">
                                <tr>
                                    <td style="text-align: center; padding: 0;">
                                        <h3 style="font-family: Arial, Helvetica, sans-serif; font-weight: 600; font-size: 18px; color: #000000; margin: 0 0 15px 0;">Need Help?</h3>
                                        <p style="font-family: Arial, Helvetica, sans-serif; font-weight: 400; font-size: 14px; color: #636363; margin: 5px 0;">Email: <a href="mailto:imediamyy@gmail.com" style="color: #B71A18; text-decoration: underline;">imediamyy@gmail.com</a></p>
                                        <p style="font-family: Arial, Helvetica, sans-serif; font-weight: 400; font-size: 14px; color: #636363; margin: 5px 0;">Phone: <a href="tel:+60135538976" style="color: #636363; text-decoration: none;">+6013 5538976</a></p>
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-bottom: 30px;">
                                <tr>
                                    <td style="text-align: center; padding: 0;">
                                        <a href="https://studypal.my" style="display: inline-block; margin: 0 15px; text-decoration: none;"><img src="https://backendstudypal.studypal.my/storage/assets/website.png" alt="Website" width="32" height="32" style="width: 32px; height: 32px; display: block;"></a>
                                        <a href="<?php echo e($facebookUrl ?? 'https://www.facebook.com/studypal.my'); ?>" style="display: inline-block; margin: 0 15px; text-decoration: none;"><img src="https://backendstudypal.studypal.my/storage/assets/facebook.png" alt="Facebook" width="32" height="32" style="width: 32px; height: 32px; display: block;"></a>
                                        <a href="<?php echo e($instagramUrl ?? 'https://www.instagram.com/studypal.my'); ?>" style="display: inline-block; margin: 0 15px; text-decoration: none;"><img src="https://backendstudypal.studypal.my/storage/assets/instagram.png" alt="Instagram" width="32" height="32" style="width: 32px; height: 32px; display: block;"></a>
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td style="text-align: center; padding: 20px;">
                                        <p style="font-family: Arial, Helvetica, sans-serif; font-weight: 400; font-size: 12px; color: #636363; margin: 5px 0;">You received this email because you subscribed to StudyPal updates.</p>
                                        <?php if(!empty($unsubscribeUrl)): ?>
                                            <p style="font-family: Arial, Helvetica, sans-serif; font-weight: 400; font-size: 12px; color: #636363; margin: 5px 0;"><a href="<?php echo e($unsubscribeUrl); ?>" style="color: #B71A18; text-decoration: underline;">Unsubscribe</a></p>
                                        <?php endif; ?>
                                        <p style="font-family: Arial, Helvetica, sans-serif; font-weight: 400; font-size: 12px; color: #636363; margin: 5px 0;">© <?php echo e(date('Y')); ?> Studypal. All rights reserved.</p>
                                        <p style="font-family: Arial, Helvetica, sans-serif; font-weight: 400; font-size: 12px; color: #636363; margin: 5px 0;">Lot 3493, No. 13 2nd Floor, Jalan Piasau, Piasau Commercial, 98000 Miri, Sarawak</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH C:\xamppp\htdocs\studypal1\STP\resources\views/emails/newsletter.blade.php ENDPATH**/ ?>