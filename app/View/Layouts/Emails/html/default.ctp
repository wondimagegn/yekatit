<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts.Email.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
	<title><?= $this->fetch('title'); ?></title>
</head>
<body style="font-family: sans-serif; background-color: #f9f9f9; padding: 20px;">
	<div style="max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; color: #000;">
		
		<div style="font-size: 14px; line-height: 1.6;">
			<?= $this->fetch('content'); ?>
		</div>

		<!-- Footer Section -->
		<hr style="margin-top: 30px; border: none; border-top: 1px solid #eee;">
		<div style="text-align: center; margin-top: 15px; font-size: 14px; color: #555; line-height: 1.5;">
			<p style="margin: 0;">🌐 Visit us: <a href="<?= PORTAL_URL_HTTPS; ?>" style="color: #0066cc; text-decoration: none;"><?= PORTAL_URL_HTTPS; ?></a> | <a href="<?= UNIVERSITY_WEBSITE; ?>" style="color: #0066cc; text-decoration: none;"><?= UNIVERSITY_WEBSITE; ?></a></p>
			<p style="margin: 5px 0;">📣 Follow Arba Minch University on:</p>
			<p style="margin: 0;">
				Facebook: <a href="<?= UNIVERSITY_FACEBOOK_PAGE; ?>" style="color: #0066cc; text-decoration: none;"><?= UNIVERSITY_FACEBOOK_PAGE_SHORT ?></a> |
				Telegram: <a href="<?= UNIVERSITY_TELEGRAM_CHANNEL; ?>" style="color: #0066cc; text-decoration: none;"><?= UNIVERSITY_TELEGRAM_CHANNEL_SHORT; ?></a> |
				X: <a href="<?= UNIVERSITY_X_PAGE; ?>" style="color: #0066cc; text-decoration: none;"><?= UNIVERSITY_X_PAGE_SHORT; ?></a> |
				YouTube: <a href="<?= UNIVERSITY_YOUTUBE_CHANNEL; ?>" style="color: #0066cc; text-decoration: none;"><?= UNIVERSITY_YOUTUBE_CHANNEL_SHORT; ?></a>
			</p>
			<p style="margin-top: 10px; color: #888;">© <?= date('Y'); ?> <?= Configure::read('CompanyName'); ?>. All rights reserved.</p>
		</div>
	</div>
</body>
</html>