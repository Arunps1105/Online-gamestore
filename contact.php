<!DOCTYPE html>
<html lang="en">
<head>
    <title>Game Store</title>
    <meta charset="UTF-8">
    <meta name="description" content="Game Warrior Template">
    <meta name="keywords" content="warrior, game, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->   
    <link href="Assets/Template/Main/img/favicon.ico" rel="shortcut icon"/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="Assets/Template/Main/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="Assets/Template/Main/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="Assets/Template/Main/css/owl.carousel.css"/>
    <link rel="stylesheet" href="Assets/Template/Main/css/style.css"/>
    <link rel="stylesheet" href="Assets/Template/Main/css/animate.css"/>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header section -->
    <header class="header-section">
        <div class="container">
            <!-- logo -->
            <a class="site-logo" href="index.php">
                <img src="Assets/Template/Main/img/logo.png" alt="">
            </a>
            <div class="user-panel">
                <a href="guest/Login.php">Login</a>  /  <a href="guest/UserRegistration.php">Register</a>
            </div>
            <!-- responsive -->
            <div class="nav-switch">
                <i class="fa fa-bars"></i>
            </div>
            <!-- site menu -->
            <nav class="main-menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="review.php">Games</a></li>
                    <li><a href="categories.php">Blog</a></li>
                    <li><a href="community.php">Forums</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- Header section end -->


    <!-- Latest news section -->
    <div class="latest-news-section">
        <div class="ln-title">Latest News</div>
        <div class="news-ticker">
            <div class="news-ticker-contant">
                <div class="nt-item"><span class="new">new</span>CyberQuest 3 launches this weekend with global co-op mode.</div>
                <div class="nt-item"><span class="strategy">strategy</span>New tactics guide for "Empire Reign" now available in our blog.</div>
                <div class="nt-item"><span class="racing">racing</span>Speed Rivals Championship kicks off with record-breaking tracks.</div>
            </div>
        </div>
    </div>
    <!-- Latest news section end -->


    <!-- Page info section -->
    <section class="page-info-section set-bg" data-setbg="Assets/Template/Main/img/page-top-bg/5.jpg">
        <div class="pi-content">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-6 text-white">
                        <h2>Contact us</h2>
                        <p>Have questions about our games, tournaments, or community events? Our team is here to help you with anything related to GameVault.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Page info section -->


    <!-- Page section -->
    <section class="page-section spad contact-page">
        <div class="container">
            <div class="map" id="map-canvas"></div>
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="comment-title">Contact us</h4>
                    <p>We value every player in our community. Whether you're reporting a bug, requesting support, or sharing ideas for new games, we're always listening.</p>
                    <div class="row">
                        <div class="col-md-9">
                            <ul class="contact-info-list">
                                <li><div class="cf-left">Address</div><div class="cf-right">soth vazhakulam po</div></li>
                                <li><div class="cf-left">Phone</div><div class="cf-right">+919072966520</div></li>
                                <li><div class="cf-left">E-mail</div><div class="cf-right">polasseryarun123@gmail.com</div></li>
                            </ul>
                        </div>
                    </div>
                    <div class="social-links">
                        <a href="facebook.com"><i class="fa fa-pinterest"></i></a>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-dribbble"></i></a>
                        <a href="#"><i class="fa fa-behance"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="contact-form-warp">
                        <h4 class="comment-title">Leave a Reply</h4>
                        <form id="contactForm" class="comment-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="name" name="name" placeholder="Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" id="email" name="email" placeholder="Email" required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="text" id="subject" name="subject" placeholder="Subject" required>
                                    <textarea id="message" name="message" placeholder="Message" required></textarea>
                                    <button type="submit" class="site-btn btn-sm">Send</button>
                                    <div id="form-message" class="mt-3 alert" style="display: none;"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Page section end -->


    <!-- Footer top section -->
    <section class="footer-top-section">
        <div class="container">
            <div class="footer-top-bg">
                <img src="Assets/Template/Main/img/footer-top-bg.png" alt="">
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="footer-logo text-white">
                        <img src="Assets/Template/Main/img/footer-logo.png" alt="">
                        <p>GameVault is your ultimate destination for premium games, eSports updates, and a vibrant player community.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget mb-5 mb-md-0">
                        <h4 class="fw-title">Latest Posts</h4>
                        <div class="latest-blog">
                            <div class="lb-item">
                                <div class="lb-thumb set-bg" data-setbg="Assets/Template/Main/img/latest-blog/1.jpg"></div>
                                <div class="lb-content">
                                    <div class="lb-date">August 5, 2025</div>
                                    <p>Upcoming multiplayer release features cross-platform play.</p>
                                    <a href="#" class="lb-author">By Admin</a>
                                </div>
                            </div>
                            <div class="lb-item">
                                <div class="lb-thumb set-bg" data-setbg="Assets/Template/Main/img/latest-blog/2.jpg"></div>
                                <div class="lb-content">
                                    <div class="lb-date">August 3, 2025</div>
                                    <p>How to join our eSports tournaments and win rewards.</p>
                                    <a href="#" class="lb-author">By Admin</a>
                                </div>
                            </div>
                            <div class="lb-item">
                                <div class="lb-thumb set-bg" data-setbg="Assets/Template/Main/img/latest-blog/3.jpg"></div>
                                <div class="lb-content">
                                    <div class="lb-date">July 30, 2025</div>
                                    <p>Exclusive sneak peek at next month's top game releases.</p>
                                    <a href="#" class="lb-author">By Admin</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <h4 class="fw-title">Top Comments</h4>
                        <div class="top-comment">
                            <div class="tc-item">
                                <div class="tc-thumb set-bg" data-setbg="Assets/Template/Main/img/authors/1.jpg"></div>
                                <div class="tc-content">
                                    <p><a href="#">James Smith</a> <span>on</span> The co-op mode in CyberQuest 3 is amazing!</p>
                                    <div class="tc-date">August 5, 2025</div>
                                </div>
                            </div>
                            <div class="tc-item">
                                <div class="tc-thumb set-bg" data-setbg="Assets/Template/Main/img/authors/2.jpg"></div>
                                <div class="tc-content">
                                    <p><a href="#">Anna Lee</a> <span>on</span> Loved the latest racing track in Speed Rivals.</p>
                                    <div class="tc-date">August 4, 2025</div>
                                </div>
                            </div>
                            <div class="tc-item">
                                <div class="tc-thumb set-bg" data-setbg="Assets/Template/Main/img/authors/3.jpg"></div>
                                <div class="tc-content">
                                    <p><a href="#">Chris Johnson</a> <span>on</span> Great tournament rewards this season!</p>
                                    <div class="tc-date">August 2, 2025</div>
                                </div>
                            </div>
                            <div class="tc-item">
                                <div class="tc-thumb set-bg" data-setbg="Assets/Template/Main/img/authors/4.jpg"></div>
                                <div class="tc-content">
                                    <p><a href="#">Emily Carter</a> <span>on</span> The new update made gameplay much smoother.</p>
                                    <div class="tc-date">August 1, 2025</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer top section end -->

    
    <!-- Footer section -->
    <footer class="footer-section">
        <div class="container">
            <ul class="footer-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="review.php">Games</a></li>
                <li><a href="categories.php">Blog</a></li>
                <li><a href="community.php">Forums</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <p class="copyright">
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | GameVault is built with <i class="fa fa-heart-o" aria-hidden="true"></i> for gamers worldwide
</p>
        </div>
    </footer>
    <!-- Footer section end -->


    <!--====== Javascripts & Jquery ======-->
    <script src="Assets/Template/Main/js/jquery-3.2.1.min.js"></script>
    <script src="Assets/Template/Main/js/bootstrap.min.js"></script>
    <script src="Assets/Template/Main/js/owl.carousel.min.js"></script>
    <script src="Assets/Template/Main/js/jquery.marquee.min.js"></script>
    <script src="Assets/Template/Main/js/main.js"></script>

    <!-- load for map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWTIlluowDL-X4HbYQt3aDw_oi2JP0Krc&sensor=false"></script>
    <script src="Assets/Template/Main/js/map.js"></script>

    <!-- EmailJS for sending emails -->
<script src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>
<script>
    // Initialize EmailJS with your Public Key
    emailjs.init("mLcnYWFxn4YUfbqNT");

    document.getElementById('contactForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const form = event.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const messageDiv = document.getElementById('form-message');
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sending...';
        messageDiv.style.display = 'none';

        // Prepare the email data
       const emailData = {
    from_name: form.name.value,
    from_email: form.email.value,
    subject: form.subject.value,
    message: form.message.value,
    reply_to: form.email.value
};


        // Send email using EmailJS
        emailjs.send('service_4y77fdf', 'template_42cq51t', emailData)
            .then(function(response) {
                console.log('SUCCESS!', response);
                messageDiv.innerHTML = '<i class="fa fa-check-circle"></i> Message sent successfully!';
                messageDiv.className = 'mt-3 alert alert-success';
                messageDiv.style.display = 'block';
                form.reset();
                
                // Hide message after 5 seconds
                setTimeout(function() {
                    messageDiv.style.display = 'none';
                }, 5000);
            })
            .catch(function(error) {
                console.error('FAILED...', error);
                messageDiv.innerHTML = `
                    <i class="fa fa-exclamation-triangle"></i> 
                    Error: ${error.text || 'Failed to send message'}<br>
                    <small>Please email us directly at project1105a@gmail.com</small>
                `;
                messageDiv.className = 'mt-3 alert alert-danger';
                messageDiv.style.display = 'block';
            })
            .finally(function() {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Send';
            });
    });
</script>
</body>
</html>