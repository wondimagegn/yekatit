<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= Configure::read('ApplicationShortName') . ' ' . Configure::read('ApplicationVersionShort'); ?> | <?php echo __d('cake', 'Forbidden'); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .error-container {
            max-width: 600px;
            margin: 10% auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 2em;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            color: #d9534f;
            margin-bottom: 1em;
        }
        p.error {
            font-size: 1.1em;
            color: #333;
        }
        @media (max-width: 600px) {
            .error-container {
                margin: 20% 1em;
                padding: 1.5em;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h2><?php echo __d('cake', 'Forbidden'); ?></h2>
        <p class="error">
            <strong><?= __d('cake', 'Error'); ?>: </strong>
            <?= __d('cake', isset($message) && !empty($message) ? $message : 'You are not authorized to access this page.'); ?>
        </p>
    </div>
</body>
</html>
<?php
//exit(); // exit processing anything afterwards
// if in debug mode, show exception_stack_trace
if (Configure::read('debug') > 0) {
	echo $this->element('exception_stack_trace');
} else {
    exit(); // exit processing anything afterwards
} ?>
