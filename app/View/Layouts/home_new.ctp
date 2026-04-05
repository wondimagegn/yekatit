<!doctype html>
<html class="no-js" lang="en">

<head>
    <!-- META CHARS -->
    <?= $this->Html->charset(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?= Configure::read('ApplicationMetaDescription'); ?>" />
    <meta name="keywords" content="<?= Configure::read('ApplicationMetaKeywords'); ?>">
    <meta name="author" content="<?= Configure::read('ApplicationMetaAuthor'); ?>">

    <!-- Refresh the page every  15 MINUTES (in seconds) and redirect back to login -->
    <meta http-equiv="refresh" content="900;url=/users/login">

    <title>Login<?= ' - '. Configure::read('ApplicationTitleExtra'); ?></title>

    <!-- Bootstrap & Font Awesome -->
    <link href="/bootstrap-5.3.7-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/fontawesome-6.5.0/css/all.min.css" rel="stylesheet" />

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

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            padding-bottom: 20px;
        }
        
        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }
        
        body.dark-mode .navbar,
        body.dark-mode footer {
            background-color: #1f1f1f !important;
            color: #eee;
            border-color: #444;
        }
        
        body.dark-mode .overlay-right,
        body.dark-mode .featured-item {
            background-color: #2c2c2c;
            color: #e0e0e0;
        }
        
        body.dark-mode .featured-item:hover {
            box-shadow: 0 0 12px rgba(255,255,255,0.15);
        }
        
        body.dark-mode {
            color: #e0e0e0;
        }

        body.dark-mode .navbar a,
        body.dark-mode .navbar .dropdown-menu a,
        body.dark-mode a,
        body.dark-mode h3,
        body.dark-mode h5,
        body.dark-mode h6 {
            color: #f1f1f1 !important;
        }

        body.dark-mode .dropdown-menu {
            background-color: #2a2a2a;
        }

        body.dark-mode .dropdown-menu a:hover {
            background-color: #3a3a3a;
            color: #ffffff !important;
        }

        body.dark-mode .btn-success,
        body.dark-mode .form-control {
            background-color: #3a3a3a;
            color: #fff;
            border-color: #555;
        }

        body.dark-mode .form-control::placeholder {
            color: #bbb;
        }

        .navbar-brand img {
            object-fit: contain;
        }

        .carousel-container {
            position: relative;
            height: 50vh;
            overflow: hidden;
        }

        .carousel-item img {
            width: 100vw;
            height: 100vh;
            object-fit: cover;         /* crop and fill */
            object-position: center;   /* center the focal point */
            filter: brightness(80%);
            opacity: 0.85;
        }

        .overlay-left {
            position: absolute;
            top: 15%;
            left: 10%;
            color: white;
            max-width: 45%;
            z-index: 10;
        }

        .overlay-right {
            position: absolute;
            top: 10%;
            right: 10%;
            z-index: 10;
            /* width: 340px; */
            width: 400px;
            background: rgba(255, 255, 255, 0.15);           /* transparent white */
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);         /* soft shadow */
            backdrop-filter: blur(1px);                         /* frost effect */
            -webkit-backdrop-filter: blur(1px);                 /* Safari support */
            border: 1px solid rgba(255, 255, 255, 0.2);       /* subtle border */
            transition: all 0.3s ease;
        }

        .navbar .dropdown-menu .dropdown-item:hover {
            background-color: #0d6efd !important; /* Bootstrap Primary Blue */
            color: #fff !important; /* Ensures contrast */
        }

        @media (max-width: 768px) {
            .overlay-right,
            .overlay-left {
                position: absolute;          /* Keep it over the carousel */
                width: 90%;
                left: 5%;
                right: 5%;
                top: auto;
                bottom: 5%;
                z-index: 10;
                padding: 1rem;
                text-align: left;
                transform: translateY(0);
            }

            .overlay-left {
                top: 5%;
                max-width: 100%;
            }

            .overlay-right {
                top: auto;
                bottom: 5%;
                background-color: rgba(255, 255, 255, 0.85);
                background: rgba(255, 255, 255, 0.15);            /* transparent white */
                border-radius: 0.75rem;
                padding: 2rem;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);         /* soft shadow */
                backdrop-filter: blur(1px);                         /* frost effect */
                -webkit-backdrop-filter: blur(1px);                 /* Safari support */
                border: 1px solid rgba(255, 255, 255, 0.2);       /* subtle border */
                transition: all 0.3s ease;
            }

            .carousel-container {
                height: 100vh; /* maintain height for background */
            }

            .featured-grid .featured-item {
                max-width: none;
                flex: 0 0 45%;
                margin: 1%;
            }

            .featured-grid .row {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

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

            .navbar .dropdown-menu {
                background-color: transparent !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0.25rem 0 !important;
            }

            .navbar .dropdown-menu .dropdown-item {
                padding: 0.5rem 1rem;
                background: none !important;
            }

            .toast-container {
                padding: 0.5rem 1rem !important; /* px-3 equivalent */
                justify-content: center !important;
                pointer-events: none; /* Prevent toast container from hijacking taps */
            }

            .toast-container .toast {
                pointer-events: auto; /* Re-enable interaction only on the toast */
            }
        }

        .featured-grid {
            padding: 2rem;
        }

        .featured-grid .row {
            row-gap: 1rem;
            column-gap: 1rem;
            justify-content: center;
        }

        .featured-item {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
            padding: 1rem;
            max-width: 220px;
            margin: auto;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .featured-item:hover {
            transform: scale(1.05);
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
        }
        
        .toast {
            background-color: rgba(0, 0, 0, 0.85);
            border-radius: 0.5rem;
            overflow: hidden;
            min-width: 300px;
            max-width: 480px;
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

        /* .blink-badge {
            display: inline-block;
            animation: blink 1s infinite;
            font-size: 0.75rem;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        } */

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .blink-badge {
            animation: pulse 1.2s infinite ease-in-out;
        }

    </style>
    <script type="text/javascript">
        history.pushState(null, null, location.href);
        window.addEventListener('popstate', () => {
            history.pushState(null, null, location.href);
            window.location.href = '/users/login';
            window.location.reload(); 
        });
    </script>
</head>

<body>

    <!-- Toast -->
    <!-- `top-0 start-50 translate-middle-x` = center or `top-0 end-0` = default -->
    <div class="position-fixed top-0 start-50 translate-middle-x d-flex justify-content-end toast-container p-5" style="z-index: 1055;">
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
                <div id="toastProgressBar" style="height: 4px; width: 100%; background: #fff;"></div>
            </div>
        </div>
    </div>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top px-3">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav">


                <li class="nav-item dropdown dropstart">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Extras</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= MOODLE_SITE_URL; ?>" target="_blank">eLearning Portal</a></li>
                        <li><a class="dropdown-item" href="<?= UNIVERSITY_WEBSITE; ?>" target="_blank"> Website</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Announcements</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/pages/announcement">Latest News</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Calendar</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="/pages/academic_calender">Academic Calendar</a></li>
                        <?php //'<li><a class="dropdown-item" href="#">Exam Schedule</a></li>'; ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Admission</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/pages/admission">Apply Online</a></li>
                        <li><a class="dropdown-item" href="/pages/online_admission_tracking">Track Status</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Transcript</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/pages/official_transcript_request">Request Transcript</a></li>
                        <li><a class="dropdown-item" href="/pages/official_request_tracking">Track Request Status</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Alumni</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/alumni/member_registration">Register</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

    <!-- Carousel -->
    <div class="carousel-container">
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
        } ?>

        <div id="bgCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="8000">
            <div class="carousel-inner">
                <?php 
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
        </div>

        <!-- Overlays -->
        <div class="overlay-left">
            <img src="/img/<?= Configure::read('logo'); ?>" alt="logo" class="img-fluid mb-3" style="max-width: 144px;" />
            <h3 class="fw-bold"><?= Configure::read('CompanyName'); ?> | Office of the Registrar</h3>
            <h5 class="color-white " style="line-height: 27px;"></h5>
            <p>This is our registrar portal for students, academic staffs and alumni to access different registrar services offered by the office of the university registrar.</p>
        </div>

        <div class="overlay-right">
            <!-- Login Box -->
             
            <?php echo $this->Flash->render(); ?>
            <?php echo $this->Session->flash(); ?>
            <?php //echo $this->Toast->renderToastScript(); ?>

            <?= $content_for_layout; ?>
        </div>
    </div>

    <!-- Feature Grid -->
    <div class="container featured-grid">
        <div class="row text-center">
            <div class="col-6 col-md-4 col-lg-3 mb-4 featured-item">
                <a href="/pages/academic_calender" class="text-decoration-none text-dark">
                    <i class="fas fa-calendar-alt fa-2x mb-2" data-bs-toggle="tooltip" title="View academic calendar for the current academic year"></i>
                    <h6>Academic<br />Calendar</h6>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4 featured-item">
                <a href="/pages/announcement" class="text-decoration-none text-dark">
                    <i class="fas fa-bullhorn fa-2x mb-2" data-bs-toggle="tooltip" title="Read registrar announcements"></i>
                    <h6>Registrar<br />Announcements</h6>
                </a>
            </div>
            <?php
            /* '<div class="col-6 col-md-4 col-lg-3 mb-4 featured-item">
                <a href="/pages/official_transcript_request" class="text-decoration-none text-dark">
                    <i class="fas fa-file-alt fa-2x mb-2" data-bs-toggle="tooltip" title="Apply for official transcript online"></i>
                    <h6>Request Official<br />Transcript</h6>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4 featured-item">
                <a href="/pages/official_request_tracking" class="text-decoration-none text-dark">
                    <i class="fas fa-search fa-2x mb-2" data-bs-toggle="tooltip" title="Track official transcript status applied online"></i>
                    <h6>Check Official<br />Transcript Status</h6>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4 featured-item">
                <a href="/pages/admission" class="text-decoration-none text-dark">
                    <i class="fas fa-cloud-upload-alt fa-2x mb-2" data-bs-toggle="tooltip" title="Apply for university admission online"></i>
                    <h6>Online<br />Admission</h6>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4 featured-item">
                <a href="/pages/online_admission_tracking" class="text-decoration-none text-dark">
                    <i class="fas fa-search fa-2x mb-2" data-bs-toggle="tooltip" title="Track your admission application status"></i>
                    <h6>Online Admission<br />Tracking</h6>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4 featured-item">
                <a href="/alumni/member_registration" class="text-decoration-none text-dark">
                    <i class="fas fa-user-graduate fa-2x mb-2" data-bs-toggle="tooltip" title="Register as an alumni member"></i>
                    <h6>Alumni<br />Registration</h6>
                </a>
            </div>'; */ ?>
            <div class="col-6 col-md-4 col-lg-3 mb-4 featured-item">
                <a href="/pages/check_graduate" class="text-decoration-none text-dark">
                    <i class="fas fa-shield-alt fa-2x mb-2" data-bs-toggle="tooltip" title="Verify graduation status and detect forgery"></i>
                    <h6>Verify Graduation<br />Status</h6>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4 featured-item">
                <a href="<?= MOODLE_SITE_URL; ?>" class="text-decoration-none text-dark" target="_blank">
                    <i class="fas fa-laptop-code fa-2x mb-2" data-bs-toggle="tooltip" title="Access digital learning resources and courses from
                     Elearning Portal"></i>
                    <h6>Y12HMC eLearning<br />Portal</h6>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <small>Copyright &copy; <?= Configure::read('Calendar.applicationStartYear') . ' - ' . date('Y'); ?> <?= Configure::read('CopyRightCompany'); ?></small>
    </footer>

    <!-- Bootstrap JS & Tooltip Init -->
    <script type='text/javascript' src="/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            
            tooltipTriggerList.forEach(function (el) {
                new bootstrap.Tooltip(el);
            });

            const loginBtn = document.getElementById('loginButton');
            const text1 = document.getElementById('Text1');
            const text2 = document.getElementById('Text2');

            const usernameMinLength = <?= (is_numeric(MINIMUM_USERNAME_LENGTH) && MINIMUM_USERNAME_LENGTH >= 3 ? MINIMUM_USERNAME_LENGTH : 3); ?>;
            const passwordMinLength = <?= (is_numeric(GENERATE_PASSWORD_LENGTH) && GENERATE_PASSWORD_LENGTH >= 5 ? GENERATE_PASSWORD_LENGTH : 5); ?>;


            function validateMinLength(input, fieldName, minLength = 3) {
                const value = input.value.trim();
                const isValid = value.length >= minLength;

                input.classList.remove('is-valid', 'is-invalid');
                input.classList.add(isValid ? '' : 'is-invalid');

                if (!isValid) {
                    showToast(`${fieldName} is too short.`, 'error', 3000);
                }

                return isValid;
            }

            if (loginBtn && text1 && text2) {

                loginBtn.addEventListener('click', function (e) {
                    //const validText1 = validateMinLength(text1, 'Username', usernameMinLength);
                    const validText2 = validateMinLength(text2, 'Password', passwordMinLength);
                    if (/* !validText1 ||  */!validText2) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });

                // Live correction for each input
                ['input', 'blur'].forEach(event => {
                    text1.addEventListener(event, () => {
                        if (text1.value.trim().length >= usernameMinLength) {
                            text1.classList.remove('is-invalid');
                            //text1.classList.add('is-valid');
                        }
                    });

                    text2.addEventListener(event, () => {
                        if (text2.value.trim().length >=  passwordMinLength) {
                            text2.classList.remove('is-invalid');
                            //text2.classList.add('is-valid');
                        }
                    });
                });
            }
        });

        // save theme in localStorage, This line ensures the theme is always light. For now, we keep it light for all users.
        /* localStorage.setItem('theme', 'light');
        
        const toggle = document.getElementById('themeToggle');
        const prefersDark = window.matchMedia('(prefers-color-scheme: light)').matches;
        const storedTheme = localStorage.getItem('theme');

        if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
            // This line ensures the theme is always light.
            //document.body.classList.add('dark-mode');
        } */

        /* toggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            toggle.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
        }); */

        function showToast(message, type = 'info', delay = 5000) {
            const toastEl = document.getElementById('dynamicToast');
            const messageEl = document.getElementById('toastMessage');
            const iconEl = document.getElementById('toastIcon');
            const progressBar = document.getElementById('toastProgressBar');

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

            // Animate the progress bar
            setTimeout(() => {
                progressBar.style.transition = `width ${delay}ms linear`;
                progressBar.style.width = '0%';
            }, 100);
        }
    </script>
</body>
</html>