<?php
session_start();
include("../Assets/Connection/Connection.php");

if(isset($_POST['btn_submit'])){
    $pass=$_POST['txt_pass'];
    $cpass=$_POST['txt_cpass'];
    if($pass==$cpass){
        if(isset($_SESSION['ruid'])){ //User
            $updQry="update tbl_user set user_password='".$pass."' where user_id=".$_SESSION['ruid'];
            if($Con->query($updQry)){
                ?>
                <script>
                    alert("Password Updated")
                    window.location="Logout.php"
                </script>
                <?php
            }
        }
        else if(isset($_SESSION['rsid'])){ //developer
            $updQry="update tbl_developer set developer_password='".$pass."' where developer_id=".$_SESSION['rsid'];
            if($Con->query($updQry)){
                ?>
                <script>
                    alert("Password Updated")
                    window.location="Logout.php"
                </script>
                <?php
            }
        }
        else{
            ?>
            <script>
                alert('Something went wrong')
                window.location="Logout.php"
            </script>
            <?php
        }
    } else {
        $error = "Passwords do not match!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
            --darker: #0a0a0c;
            --light: #e2e2e2;
            --neon: #00fffc;
            --danger: #ff4757;
            --warning: #ffa502;
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
        
        .password-container {
            width: 100%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
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
            background: linear-gradient(135deg, var(--primary), var(--accent));
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .password-header h2 {
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
            z-index: 2;
        }
        
        .password-body {
            padding: 2rem;
            position: relative;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(108, 92, 231, 0.3);
            color: var(--dark);
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 1);
            border-color: var(--accent);
            color: var(--dark);
            box-shadow: 0 0 0 0.25rem rgba(0, 206, 201, 0.25);
        }
        
        .input-group-text {
            background: rgba(108, 92, 231, 0.1);
            border: 2px solid rgba(108, 92, 231, 0.3);
            color: var(--primary);
        }
        
        .btn-submit {
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
            margin-top: 20px;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.7);
            color: white;
        }
        
        .password-strength {
            height: 5px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
            margin-top: 5px;
            overflow: hidden;
        }
        
        .strength-meter {
            height: 100%;
            width: 0%;
            background: var(--danger);
            transition: all 0.3s ease;
        }
        
        .password-criteria {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .error-message {
            color: var(--danger);
            font-size: 0.9rem;
            margin-top: 5px;
            display: none;
        }
        
        .toggle-password {
            cursor: pointer;
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="password-container">
        <div class="password-header">
            <h2><i class="fas fa-key me-2"></i>Reset Password</h2>
        </div>
        
        <div class="password-body">
            <p class="text-muted mb-4">Please enter your new password below.</p>
            
            <?php if(isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
            <?php endif; ?>
            
            <form id="passwordForm" name="form1" method="post" action="">
                <div class="mb-3">
                    <label for="txt_pass" class="form-label">New Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="txt_pass" id="txt_pass" required />
                        <span class="input-group-text toggle-password" id="togglePass">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="password-strength">
                        <div class="strength-meter" id="strengthMeter"></div>
                    </div>
                    <div class="password-criteria">
                        Must be at least 8 characters with uppercase, lowercase, number, and special character.
                    </div>
                    <div class="error-message" id="passError"></div>
                </div>
                
                <div class="mb-4">
                    <label for="txt_cpass" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" name="txt_cpass" id="txt_cpass" required />
                        <span class="input-group-text toggle-password" id="toggleCPass">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="error-message" id="cpassError"></div>
                </div>
                
                <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-submit">
                    <i class="fas fa-save me-2"></i>Change Password
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Password strength indicator
        document.getElementById('txt_pass').addEventListener('input', function() {
            const password = this.value;
            const strengthMeter = document.getElementById('strengthMeter');
            const passError = document.getElementById('passError');
            let strength = 0;
            
            if (password.length > 0) strength += 1;
            if (password.length >= 8) strength += 1;
            if (/[A-Z]/.test(password)) strength += 1;
            if (/[0-9]/.test(password)) strength += 1;
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            const width = (strength / 5) * 100;
            strengthMeter.style.width = width + '%';
            
            if (strength <= 2) {
                strengthMeter.style.background = 'var(--danger)';
                passError.textContent = 'Password is weak';
                passError.style.display = 'block';
            } else if (strength <= 4) {
                strengthMeter.style.background = 'var(--warning)';
                passError.textContent = 'Password is medium';
                passError.style.display = 'block';
            } else {
                strengthMeter.style.background = 'var(--success)';
                passError.style.display = 'none';
            }
        });
        
        // Confirm password validation
        document.getElementById('txt_cpass').addEventListener('input', function() {
            const password = document.getElementById('txt_pass').value;
            const confirmPassword = this.value;
            const cpassError = document.getElementById('cpassError');
            
            if (confirmPassword !== password) {
                cpassError.textContent = 'Passwords do not match';
                cpassError.style.display = 'block';
            } else {
                cpassError.style.display = 'none';
            }
        });
        
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(function(element) {
            element.addEventListener('click', function() {
                const inputId = this.id === 'togglePass' ? 'txt_pass' : 'txt_cpass';
                const input = document.getElementById(inputId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
        
        // Form validation
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const password = document.getElementById('txt_pass').value;
            const confirmPassword = document.getElementById('txt_cpass').value;
            const passError = document.getElementById('passError');
            const cpassError = document.getElementById('cpassError');
            let isValid = true;
            
            // Validate password strength
            if (password.length < 8) {
                passError.textContent = 'Password must be at least 8 characters';
                passError.style.display = 'block';
                isValid = false;
            }
            
            // Validate password match
            if (password !== confirmPassword) {
                cpassError.textContent = 'Passwords do not match';
                cpassError.style.display = 'block';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>