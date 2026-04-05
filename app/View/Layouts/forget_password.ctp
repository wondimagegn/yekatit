<!doctype html>
<html class="no-js" lang="en">

<head>
    <!-- META CHARS -->
    <?= $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?= Configure::read('ApplicationMetaDescription'); ?>" />
    <meta name="keywords" content="<?= Configure::read('ApplicationMetaKeywords'); ?>">
    <meta name="author" content="<?= Configure::read('ApplicationMetaAuthor'); ?>">

    <!-- Refresh the page every  5 MINUTES (in seconds) -->
    <meta http-equiv="refresh" content="120;url=/users/login">

    <title>Forgot Password?<?= ' - '. Configure::read('ApplicationTitleExtra'); ?></title>

    <!-- Bootstrap & Font Awesome -->
    <link href="/bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/fontawesome-6.5.0/css/all.min.css" rel="stylesheet" />

    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
        }

        .carousel-container {
            position: relative;
            height: 100vh;
            width: 100%;
        }

        .carousel-inner,
        .carousel-item,
        .carousel-item img {
            height: 100%;
            width: 100%;
        }

        .carousel-item img {
            object-fit: cover;
            object-position: center;
            filter: brightness(80%);
            opacity: 0.85;
        }

        .forgot-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            max-width: 420px;
            width: 90%;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(1px);
            -webkit-backdrop-filter: blur(1px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.75rem;
            box-shadow: 0 0 25px rgba(0,0,0,0.3);
            color: #fff;
            text-align: center;
            transition: padding 0.3s ease;
        }

        .forgot-box.compact {
            padding: 1.5rem;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .input-group-text i {
            font-size: 1rem;
        }

        .login-button {
            margin-top: 1.25rem;
        }

        .toast {
            background-color: rgba(0, 0, 0, 0.85);
            border-radius: 0.5rem;
            overflow: hidden;
            min-width: 300px;
            max-width: 620px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        .toast-content {
            display: flex;
            align-items: center;
        }

        .toast-icon i {
            font-size: 1.5rem;
        }

        .toast-message {
            font-size: 0.95rem;
            text-align: justify;
        }

        .toast-progress {
            height: 4px;
            background: rgba(255,255,255,0.2);
        }
        
        #dynamicToast {
            background-color: rgba(0, 0, 0, 0.85);
            border-radius: 0.5rem;
            overflow: hidden;
            width: 100%;
            max-width: 620px;     /* Controls overall width */
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        #toastProgressBar {
            background: #fff;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #ffffff;
            color: #333;
            text-align: right;
            border-top: 1px solid #ddd;
            z-index: 999;

            /* Glassmorphism effect for footer */
			background: rgba(255, 255, 255, 0.15);
			backdrop-filter: blur(1px);
			-webkit-backdrop-filter: blur(1px);
			border-top: 1px solid rgba(255, 255, 255, 0.25);
			color: #fff;
        }

        @media (max-width: 768px) {
            .position-fixed.top-0.start-50.translate-middle-x {
                width: 90%;
                left: 0;
                transform: none;
                justify-content: center !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            #dynamicToast {
                width: 100% !important;
                max-width: 100% !important;
            }
        }
    </style>
    <script type="text/javascript">
        history.pushState(null, null, location.href);
        window.addEventListener('popstate', () => {
            history.pushState(null, null, location.href);
            window.location.href = '/users/forget';
            window.location.reload(); 
        });
    </script>

    <!-- favicons -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon-96x96.png" sizes="96x96" type="image/png">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="apple-touch-icon-precomposed" href="/apple-touch-icon-precomposed.png">

    <!-- Web App Manifest -->
    <link rel="manifest" href="/site.webmanifest">

    <!-- Theme color for browsers -->
    <meta name="theme-color" content="#ffffff">
</head>

<body>
    <div class="carousel-container">
        <div class="carousel-inner carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="8000">
            <?php
            $dir = new DirectoryIterator(WWW_ROOT . 'img/login-background1');
            $images = [];
            
            // Gather all valid image filenames
            if (!empty($dir)) {
                foreach ($dir as $fileinfo) {
                    if (!$fileinfo->isDot() && $fileinfo->isFile()) {
                        $images[] = $fileinfo->getFilename();
                    }
                }
            }
            
            if (!empty($images)) {
                // Shuffle the image order to randomize the first one
                shuffle($images); 

                foreach ($images as $index => $imgName) { ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="/img/login-background1/<?= h($imgName) ?>" class="d-block w-100" alt="<?= h($imgName) ?>">
                    </div>
                    <?php 
                } 
            } else { ?>
                <div class="carousel-item active">
                    <img src="/img/login-background/1-1366-768.jpg" class="d-block w-100" alt="Background Image" />
                </div>
                <?php
            } ?>
        </div>

        <!-- Forgot Password Form Box -->
        <div class="forgot-box" id="forgotBox">
            <?php echo $this->Flash->render(); ?>
            <?php echo $this->Session->flash(); ?>
            <?php //echo $this->Toast->renderToastScript(); ?>

            <?= $content_for_layout; ?>
        </div>
    </div>

    <!-- Toast Component -->
    <div class="position-fixed top-0 start-50 translate-middle-x d-flex justify-content-end p-5" style="z-index: 1055;">
        <div id="dynamicToast" class="toast text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-content d-flex align-items-center justify-content-between px-3 py-2">
                <div class="toast-icon">
                    <i class="fas fa-info-circle me-3 fs-5" id="toastIcon"></i>
                </div>
                <div class="toast-message flex-grow-1 text-center">
                    <span id="toastMessage">Placeholder</span>
                </div>
                <button type="button" class="btn-close btn-close-white ms-3" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-progress w-100">
                <div id="toastProgressBar" style="height: 4px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <small>Copyright &copy; <?= Configure::read('Calendar.applicationStartYear') . ' - ' . date('Y'); ?> <?= Configure::read('CopyRightCompany'); ?></small>
    </footer>

    <!-- Bootstrap JS & Tooltip Init -->
    <script type='text/javascript' src="/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

    <!-- Validation + Toast Logic -->
    <script>
        function showToast(message, type = 'info', delay = 5000) {
            const toastEl = document.getElementById('dynamicToast');
            const messageEl = document.getElementById('toastMessage');
            const iconEl = document.getElementById('toastIcon');
            const progressBar = document.getElementById('toastProgressBar');
            const passiveAlert = document.getElementById('passiveAlert');
            const forgotBox = document.getElementById('forgotBox');

            toastEl.className = 'toast text-white border-0';
            iconEl.className = 'fas me-3 fs-5';
            progressBar.style.width = '100%';
            progressBar.style.transition = 'none';

            switch (type) {
                case 'success':
                    toastEl.classList.add('bg-success');
                    iconEl.classList.add('fa-check-circle');
                    break;
                case 'error':
                    toastEl.classList.add('bg-danger');
                    iconEl.classList.add('fa-times-circle');
                    break;
                case 'warning':
                    toastEl.classList.add('bg-warning', 'text-dark');
                    iconEl.classList.add('fa-exclamation-triangle');
                    break;
                default:
                    toastEl.classList.add('bg-info');
                    iconEl.classList.add('fa-info-circle');
            }

            messageEl.textContent = message;
            new bootstrap.Toast(toastEl, { delay: delay, autohide: true }).show();

            // Disable all buttons with .btn class
            const allButtons = document.querySelectorAll('.btn');
            //allButtons.forEach(btn => btn.disabled = true);

            allButtons.forEach(btn => {
                if (btn.tagName === 'A') {                          // links with .btn class
                    btn.classList.add('disabled');                  // Bootstrap styling
                    btn.setAttribute('aria-disabled', 'true');      // Accessibility hint
                    btn.style.pointerEvents = 'none';               // Prevent clicks
                } else {
                    btn.disabled = true;                            // Real button
                }
            });

            // Re-enable disabled buttons after the defined delay
            setTimeout(() => {
                //allButtons.forEach(btn => btn.disabled = false);
                allButtons.forEach(btn => {
                    if (btn.tagName === 'A') {
                        btn.classList.remove('disabled');
                        btn.removeAttribute('aria-disabled');
                        btn.style.pointerEvents = '';
                    } else {
                        btn.disabled = false;
                    }
                });
            }, delay);

            setTimeout(() => {
                progressBar.style.transition = `width ${delay}ms linear`;
                progressBar.style.width = '0%';
            }, 100);

            if (passiveAlert && passiveAlert.classList.contains('show')) {
                passiveAlert.classList.remove('show');
                passiveAlert.classList.add('d-none');
            }

            if (forgotBox && !forgotBox.classList.contains('compact')) {
                forgotBox.classList.add('compact');
            }
        }

        function shrinkForgotBox() {
            document.getElementById('forgotBox')?.classList.add('compact');
        }

        document.getElementById('forgotForm').addEventListener('submit', function (e) {
            e.preventDefault();
            
            const email = document.getElementById('userEmail').value.trim();
            const code = document.getElementById('securityCode').value.trim();
            const passiveAlert = document.getElementById('passiveAlert');
            const forgotBox = document.getElementById('forgotBox');

            const mathText = document.querySelector('.math-challenge')?.innerText || '';
            const sanitized = mathText.replace(/[^\d+\-*/() ]/g, '');

            let expectedAnswer;
            try {
                expectedAnswer = eval(sanitized);
            } catch (err) {
                showToast('Math captcha is invalid.', 'error');
                return;
            }

            if (!email || !email.includes('@') || !email.includes('.')) {
                showToast('Please enter a valid email address.', 'error');
                return;
            }

            if (parseInt(code) !== expectedAnswer) {
                showToast('Incorrect security code. Please try again.', 'warning');
                return;
            }

            if (isCooldownActive()) {
                showToast('You have sent a password rest request moments ago. Please check your email or wait for 5 minutes before requesting again.', 'info', 15000);
                return;
            }

            // Save cooldown flag
            localStorage.setItem('forgotSubmitTime', Date.now().toString());

            document.getElementById('forgotForm').submit();

        });
        
        function isCooldownActive() {
            const lastSubmit = localStorage.getItem('forgotSubmitTime');
            if (!lastSubmit) return false;
            return Date.now() - parseInt(lastSubmit) < 5 * 60 * 1000; // 5 minutes
        }

    </script>
</body>
</html>