<?php
include("../Assets/Connection/Connection.php");
session_start();

if(isset($_POST['btn_submit'])){
    if($_SESSION['otp']==$_POST['txt_otp']){
       ?>
       <script>
        alert('OTP Validated')
        window.location="ResetPassword.php"
        </script>
       <?php
    }
    else{
        ?>
        <script>
            alert('OTP Incorrect')
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
    <title>Validate OTP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6c5ce7;
            --secondary: #a29bfe;
            --accent: #00cec9;
            --dark: #0f0f12;
            --light: #e2e2e2;
            --neon: #00fffc;
            --danger: #ff4757;
            --success: #2ed573;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, rgba(108, 92, 231, 0.2), rgba(0, 206, 201, 0.2)), url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            color: var(--dark);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .otp-container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            position: relative;
        }
        
        .otp-container::before {
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
        
        .otp-header {
            height: 120px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .otp-header h2 {
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            z-index: 2;
        }
        
        .otp-body {
            padding: 2rem;
            position: relative;
        }
        
        .otp-icon {
            text-align: center;
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .otp-input-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        
        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border: 2px solid rgba(108, 92, 231, 0.3);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }
        
        .otp-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(0, 206, 201, 0.25);
            outline: none;
        }
        
        .btn-validate {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
        }
        
        .btn-validate:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.7);
            color: white;
        }
        
        .resend-option {
            text-align: center;
            margin-top: 1.5rem;
            color: #6c757d;
        }
        
        .resend-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }
        
        .resend-link:hover {
            color: var(--accent);
            text-decoration: underline;
        }
        
        .countdown {
            color: var(--primary);
            font-weight: bold;
        }
        
        @media (max-width: 576px) {
            .otp-input {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
            
            .otp-container {
                margin: 0 15px;
            }
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <div class="otp-header">
            <h2><i class="fas fa-shield-alt me-2"></i>OTP Verification</h2>
        </div>
        
        <div class="otp-body">
            <div class="otp-icon">
                <i class="fas fa-lock"></i>
            </div>
            
            <p class="instruction">Enter the 6-digit verification code sent to your email</p>
            
            <form id="otpForm" method="POST" action="">
                <div class="mb-3">
                    <label for="otp" class="form-label">Verification Code</label>
                    <div class="otp-input-group">
                        <input type="text" class="otp-input" name="digit1" id="digit1" maxlength="1" onkeyup="moveToNext(this, 'digit2')" required>
                        <input type="text" class="otp-input" name="digit2" id="digit2" maxlength="1" onkeyup="moveToNext(this, 'digit3')" required>
                        <input type="text" class="otp-input" name="digit3" id="digit3" maxlength="1" onkeyup="moveToNext(this, 'digit4')" required>
                        <input type="text" class="otp-input" name="digit4" id="digit4" maxlength="1" onkeyup="moveToNext(this, 'digit5')" required>
                        <input type="text" class="otp-input" name="digit5" id="digit5" maxlength="1" onkeyup="moveToNext(this, 'digit6')" required>
                        <input type="text" class="otp-input" name="digit6" id="digit6" maxlength="1" onkeyup="moveToNext(this, '')" required>
                    </div>
                    <input type="hidden" name="txt_otp" id="txt_otp">
                </div>
                
                <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-validate">
                    <i class="fas fa-check-circle me-2"></i>Verify Code
                </button>
            </form>
            
            <div class="resend-option">
                <p>Didn't receive the code? <span id="countdown" class="countdown">02:00</span></p>
                <a href="#" class="resend-link" id="resendLink" style="display:none;">Resend Code</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Combine OTP digits into a single hidden field
        function combineOTP() {
            const digit1 = document.getElementById('digit1').value;
            const digit2 = document.getElementById('digit2').value;
            const digit3 = document.getElementById('digit3').value;
            const digit4 = document.getElementById('digit4').value;
            const digit5 = document.getElementById('digit5').value;
            const digit6 = document.getElementById('digit6').value;
            
            document.getElementById('txt_otp').value = digit1 + digit2 + digit3 + digit4 + digit5 + digit6;
        }
        
        // Move to next input field
        function moveToNext(current, nextFieldID) {
            if (current.value.length >= current.maxLength) {
                if (nextFieldID !== '') {
                    document.getElementById(nextFieldID).focus();
                }
            }
            
            combineOTP();
        }
        
        // Countdown timer for resend option
        let timeLeft = 120; // 2 minutes in seconds
        const countdownElement = document.getElementById('countdown');
        const resendLink = document.getElementById('resendLink');
        
        function updateCountdown() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            
            countdownElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft > 0) {
                timeLeft--;
                setTimeout(updateCountdown, 1000);
            } else {
                countdownElement.style.display = 'none';
                resendLink.style.display = 'inline';
            }
        }
        
        // Start the countdown when page loads
        window.onload = function() {
            updateCountdown();
            
            // Auto-focus on first input
            document.getElementById('digit1').focus();
        };
        
        // Allow only numbers in OTP fields
        document.querySelectorAll('.otp-input').forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text');
                const digits = pastedData.replace(/[^0-9]/g, '').split('');
                
                if (digits.length === 6) {
                    document.getElementById('digit1').value = digits[0] || '';
                    document.getElementById('digit2').value = digits[1] || '';
                    document.getElementById('digit3').value = digits[2] || '';
                    document.getElementById('digit4').value = digits[3] || '';
                    document.getElementById('digit5').value = digits[4] || '';
                    document.getElementById('digit6').value = digits[5] || '';
                    document.getElementById('digit6').focus();
                    combineOTP();
                }
            });
        });
        
        // Form submission
        document.getElementById('otpForm').addEventListener('submit', function() {
            combineOTP();
        });
    </script>
</body>
</html>