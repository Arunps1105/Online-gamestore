<?php
session_start();
include("../Assets/Connection/Connection.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Assets/phpMail/src/Exception.php';
require '../Assets/phpMail/src/PHPMailer.php';
require '../Assets/phpMail/src/SMTP.php';

function generateOTP($length = 6) {
    $digits = '0123456789';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $digits[rand(0, strlen($digits) - 1)];
    }
    return $otp;
}

function otpEmail($email,$otp){
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'project1105a@gmail.com'; // Your gmail
    $mail->Password = 'negn zotr hkff xdxh'; // Your gmail app password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
  
    $mail->setFrom('project1105a@gmail.com'); // Your gmail
  
    $mail->addAddress($email);
  
    $mail->isHTML(true);
    $message = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 5px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .footer {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Your OTP Code
        </div>
        <p>Hello,</p>
        <p>Here is your One-Time Password (OTP) for verification:</p>
        <h2 style="font-size: 36px; color: #333;">' . $otp . '</h2>
        <p>This OTP is valid for the next 5 minutes. Please use it to complete your verification process.</p>
        <p>If you did not request this OTP, please ignore this email or contact support if you have concerns.</p>
        <p>Best regards,<br>Company Name</p>
        <div class="footer">
            This is an automated message. Please do not reply.
        </div>
    </div>
</body>
</html>
';
    $mail->Subject = "Reset your password";  //Your Subject goes here
    $mail->Body = $message; //Mail Body goes here
  if($mail->send())
  {
    ?>
<script>
    alert("Email Send")
    window.location="OTP_validator.php";
</script>
    <?php
  }
  else
  {
    ?>
<script>
    alert("Email Failed")
</script>
    <?php
  }
}

if(isset($_POST['btn_submit'])){
    $email=$_POST['txt_email'];
    $selUser="select * from tbl_user where user_email='".$email."'";	
	$Seldeveloper="select * from tbl_developer where developer_email='".$email."'";
	$resUser=$Con->query($selUser);
    $resdeveloper=$Con->query($Seldeveloper);
	
    $otp = generateOTP();
    $_SESSION['otp'] = $otp;
    if($userData=$resUser->fetch_assoc())
	{
		$_SESSION['ruid'] = $userData['user_id'];
		otpEmail($email,$otp);
	}
	else if($developerData=$resdeveloper->fetch_assoc())
	{
		$_SESSION['rsid'] = $developerData['developer_id'];
		otpEmail($email,$otp);
	}
	
	else{
	?>
    	<script>
		alert("Account Doesn't Exists")
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
    <title>Password Reset</title>
    <!-- Bootstrap Dark CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;600;700&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6c5ce7;
            --secondary: #a29bfe;
            --accent: #00cec9;
            --dark: #0f0f12;
            --darker: #0a0a0c;
            --light: #e2e2e2;
            --neon: #00fffc;
            --danger: #ff4757;
            --warning: #ffa502;
            --success: #2ed573;
        }
        
        body {
            font-family: 'Oxanium', sans-serif;
            background: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            color: var(--light);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            position: relative;
        }
        
        
        .password-container {
            max-width: 600px;
            margin: 5rem auto;
            background: rgba(15, 15, 18, 0.9);
            border-radius: 15px;
            border: 1px solid rgba(106, 90, 205, 0.3);
            box-shadow: 0 0 30px rgba(106, 90, 205, 0.2),
                        0 0 60px rgba(106, 90, 205, 0.1),
                        inset 0 0 10px rgba(106, 90, 205, 0.2);
            overflow: hidden;
            position: relative;
        }
        
        .password-container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary), var(--accent), var(--primary));
            z-index: -1;
            border-radius: 16px;
            animation: borderGlow 8s linear infinite;
            background-size: 400%;
            opacity: 0.7;
        }
        
        @keyframes borderGlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .password-header {
            height: 120px;
            background: linear-gradient(135deg, rgba(108, 92, 231, 0.2), rgba(0, 206, 201, 0.2));
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .password-header h2 {
            font-family: 'Rajdhani', sans-serif;
            color: var(--neon);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(0, 255, 252, 0.5);
            margin: 0;
            z-index: 2;
        }
        
        .password-body {
            padding: 2rem;
            position: relative;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .form-control {
            background: rgba(30, 30, 36, 0.7);
            border: 1px solid rgba(106, 90, 205, 0.3);
            color: var(--light);
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }
        
        .form-control:focus {
            background: rgba(40, 40, 48, 0.8);
            border-color: var(--accent);
            color: var(--light);
            box-shadow: 0 0 0 0.25rem rgba(0, 206, 201, 0.25);
        }
        
        .input-group-text {
            background: rgba(108, 92, 231, 0.2);
            border: 1px solid rgba(106, 90, 205, 0.3);
            color: var(--accent);
            text-shadow: 0 0 5px rgba(0, 206, 201, 0.7);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: var(--dark);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
            margin-top: 20px;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.7);
            color: var(--dark);
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--secondary);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: var(--neon);
        }
    </style>
</head>
<body>
    <div class="password-container">
        <div class="password-header">
            <h2><i class="fas fa-key me-2"></i>Password Reset</h2>
        </div>
        
        <div class="password-body">
            <form id="form1" name="form1" method="post" action="">
                <div class="mb-4">
                    <label for="txt_email" class="form-label">Enter Your Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" name="txt_email" id="txt_email" required placeholder="Enter your registered email address" />
                    </div>
                    <div class="form-text text-secondary mt-2">
                        Enter your email address and we'll send you an OTP to reset your password.
                    </div>
                </div>
                
                <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-submit">
                    <i class="fas fa-paper-plane me-2"></i>Send Reset Code
                </button>
                
                <a href="login.php" class="back-link">
                    <i class="fas fa-arrow-left me-1"></i> Back to Login
                </a>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>