<?php
include("../Assets/Connection/Connection.php");
session_start();
if(isset($_POST["btn_login"]))
{
	$email=$_POST["txt_email"];
	$password=$_POST["txt_pass"];
	
	$selQry="select * from tbl_user where user_email='".$email."' and  user_password ='".$password."'";
	$userrow=$Con->query($selQry);
	
	$selAdmin="select * from tbl_admin where admin_email='".$email."' and  admin_password ='".$password."'";
	$adminRow=$Con->query($selAdmin);
	
	$seldeveloper="select * from tbl_developer where developer_email='".$email."' and  developer_password ='".$password."' and developer_status='1'";
	$developerRow=$Con->query($seldeveloper);
	
	if($userdata=$userrow->fetch_assoc())
	{
		$_SESSION['uid']=$userdata['user_id'];
		$_SESSION['uname']=$userdata['user_name'];
		header("location:../User/Homepage.php");
	}
	else if($adminData=$adminRow->fetch_assoc())
	{
		$_SESSION['aid']=$adminData['admin_id'];
		$_SESSION['aname']=$adminData['admin_name'];
		header("location:../Admin/HomePage.php");
	}
	else if($developerData=$developerRow->fetch_assoc())
	{
		$_SESSION['did']=$developerData['developer_id'];
		$_SESSION['dname']=$developerData['developer_name'];
		header("location:../Developer/HomePage.php");
	}
	else
	{    ?>
		<script>
		alert("Invalid Login");
		window.location="Login.php";
		</script>
        <?php
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameHub - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #6c5ce7;
            --secondary-color: #a29bfe;
            --dark-color: #2d3436;
            --light-color: #f5f6fa;
            --accent-color: #fd79a8;
            --success-color: #00b894;
        }
        body {
            background: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 0;
        }
        .login-container {
            background: rgba(32, 32, 48, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            width: 1000px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeInUp 0.8s ease;
        }
        .game-character {
            background: url('https://images.unsplash.com/photo-1589254065878-42c9da997008?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center;
            background-size: cover;
            position: relative;
            padding: 0;
            overflow: hidden;
        }
        .game-character::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(108, 92, 231, 0.8) 0%, rgba(162, 155, 254, 0.6) 100%);
        }
        .game-logo {
            position: absolute;
            top: 30px;
            left: 30px;
            width: 120px;
            z-index: 2;
        }
        .login-content {
            padding: 60px;
            color: var(--light-color);
        }
        .login-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .login-header p {
            color: var(--secondary-color);
            margin-bottom: 30px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 8px;
            padding: 15px;
            color: white;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.3);
            border: none;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .btn-login {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 8px;
            padding: 15px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.5s ease;
        }
        .btn-login:hover::before {
            left: 100%;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: var(--secondary-color);
        }
        .register-link a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .register-link a:hover {
            color: white;
            text-decoration: underline;
        }
        .social-login {
            margin-top: 30px;
            text-align: center;
        }
        .social-login p {
            color: var(--secondary-color);
            margin-bottom: 15px;
            position: relative;
        }
        .social-login p::before, .social-login p::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }
        .social-login p::before {
            left: 0;
        }
        .social-login p::after {
            right: 0;
        }
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
        }
        .social-icon:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        /* TOP-RIGHT TOGGLE */
        #themeToggle {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 99;
        }

        /* Light theme overrides */
        body.light-theme {
            background: #f1f2f6 !important;
        }
        body.light-theme .login-container {
            background: rgba(255, 255, 255, 0.95);
            color: #2d3436;
        }
        body.light-theme .form-control {
            background: rgba(0, 0, 0, 0.05);
            color: #2d3436;
        }
        body.light-theme .form-control::placeholder {
            color: #888;
        }
        body.light-theme .btn-login {
            background: linear-gradient(45deg, #00cec9, #0984e3);
            color: white;
        }
        @media (max-width: 992px) {
            .game-character {
                display: none;
            }
            .login-container {
                width: 100%;
                max-width: 500px;
            }
            .login-content {
                padding: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="login-container animate__animated animate__fadeIn">
                    <!-- TOP RIGHT THEME TOGGLE BUTTON -->
                    <button id="themeToggle" class="btn btn-light btn-sm" title="Toggle Theme">
                        <i class="fas fa-moon"></i>
                    </button>

                    <div class="row g-0">
                        <div class="col-lg-6 d-none d-lg-flex game-character">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <lottie-player src="https://lottie.host/4ace4c16-90ff-4cdc-936f-7ad7bc602e20/PEPlxfDBQ1.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="login-content">
                                <div class="login-header mb-5">
                                    <h1 class="animate__animated animate__fadeInDown">Welcome to GameHub</h1>
                                    <p class="animate__animated animate__fadeInDown animate__delay-1s">Sign in to access your game library</p>
                                </div>
                                <form method="post" class="animate__animated animate__fadeIn animate__delay-1s">
                                    <div class="mb-4">
                                        <input type="text" id="txt_email" name="txt_email" class="form-control" required placeholder="Email Address">
                                    </div>
                                    <div class="mb-4">
                                        <input type="password" id="txt_pass" name="txt_pass" class="form-control" required placeholder="Password">
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe" style="color: var(--secondary-color);">Remember me</label>
                                        </div>
                                        <a href="ForgetPassword.php" style="color: var(--accent-color); text-decoration: none;">Forgot password?</a>
                                    </div>
                                    <button type="submit" name="btn_login" class="btn btn-login btn-primary">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login
                                    </button>
                                </form>
                                <div class="register-link mt-4 animate__animated animate__fadeIn animate__delay-2s">
                                    <p>Don't have an account? 
                                        <a href="UserRegistration.php">Register as User</a> / 
                                        <a href="developer.php">Register as Developer</a>
                                    </p>
                                </div>
                                <div class="social-login mt-5 animate__animated animate__fadeIn animate__delay-2s">
                                    <p>Or login with</p>
                                    <div class="social-icons">
                                        <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
                                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                                        <a href="#" class="social-icon"><i class="fab fa-steam"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end row -->
                </div>
            </div>
        </div>
    </div>

    <!-- Theme toggle JS -->
    <script>
        const toggleBtn = document.getElementById("themeToggle");
        let darkMode = true;

        toggleBtn.addEventListener("click", () => {
            document.body.classList.toggle("light-theme");
            darkMode = !darkMode;
            toggleBtn.innerHTML = darkMode 
                ? '<i class="fas fa-moon"></i>' 
                : '<i class="fas fa-sun"></i>';
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
