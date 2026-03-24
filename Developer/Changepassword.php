<?php
include("../Assets/Connection/Connection.php");
session_start();
$selQry="select * from tbl_developer where developer_id = '".$_SESSION['did']."' ";
$result=$Con->query($selQry);
$developerdata=$result->fetch_assoc();
if(isset($_POST['btn_submit']))
{
    $oldpassword=$_POST['txt_oldpassword'];
    $newpassword=$_POST['txt_newpassword'];
    $retypepassword=$_POST['txt_retypepassword'];
    if($developerdata['developer_password']==$oldpassword)

    {
       if($newpassword == $retypepassword)  // Proper comparison
        {
            $upQry="update tbl_developer set developer_password='".$newpassword."' where developer_id='".$_SESSION['did']."' ";
            if($Con->query($upQry))
            {
?>
                <script>
                    alert("Updated succesfully");
                    window.location="myprofile.php";
                </script>
<?php
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Developer Access Code</title>
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
            display: flex;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 15, 18, 0.85);
            z-index: -1;
        }
        
        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background: rgba(15, 15, 18, 0.9);
            border-right: 1px solid rgba(106, 90, 205, 0.3);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px 0;
            box-shadow: 0 0 30px rgba(106, 90, 205, 0.2);
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(106, 90, 205, 0.3);
            margin-bottom: 20px;
        }
        
        .sidebar-header h3 {
            color: var(--neon);
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1.2rem;
            margin: 0;
            text-shadow: 0 0 10px rgba(0, 255, 252, 0.3);
        }
        
        .sidebar-menu {
            padding: 0 15px;
        }
        
        .sidebar-menu a {
            display: block;
            color: var(--secondary);
            padding: 12px 15px;
            margin-bottom: 5px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .sidebar-menu a:hover {
            background: rgba(108, 92, 231, 0.2);
            color: var(--neon);
            transform: translateX(5px);
        }
        
        .sidebar-menu a.active {
            background: linear-gradient(90deg, rgba(108, 92, 231, 0.3), transparent);
            color: var(--neon);
            border-left: 3px solid var(--accent);
        }
        
        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
        
        .password-container {
            max-width: 600px;
            margin: 2rem auto;
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
         .logout-btn {
            background: linear-gradient(135deg, #e84393, #fd79a8);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(232, 67, 147, 0.3);
            width: 90%;
            position: relative;
            overflow: hidden;
        }
         .logout-btn::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255,255,255,0.3),
                rgba(255,255,255,0)
            );
            transform: rotate(30deg);
            animation: shine 3s infinite;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(232, 67, 147, 0.4);
        }
        
        
        
        .password-strength {
            height: 5px;
            background: rgba(255, 255, 255, 0.1);
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
      .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            border-top: 1px solid rgba(108, 92, 231, 0.2);
        }
    
    </style>
</head>
<body>
 <!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
    <h3><i class="fas fa-laptop-code"></i> Developer Panel</h3>


    </div>
    <div class="sidebar-menu">
        <a href="Changepassword.php" class="active"><i class="fas fa-key"></i> Change Password</a>
        <a href="Homepage.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="myprofile.php"><i class="fas fa-user-cog"></i> My Profile</a>
         <div class="sidebar-footer">
        <a href="Logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></div>
    </div>
</div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="password-container">
            <div class="password-header">
                <h2><i class="fas fa-key me-2"></i>Change Developer Access Code</h2>
            </div>
            
            <div class="password-body">
                <form id="form1" name="form1" method="post" action="">
                    <div class="mb-3">
                        <label for="txt_oldpassword" class="form-label">Current Access Code</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" name="txt_oldpassword" id="txt_oldpassword" required />
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="txt_newpassword" class="form-label">New Access Code</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" name="txt_newpassword" id="txt_newpassword" required />
                        </div>
                        <div class="password-strength">
                            <div class="strength-meter" id="strengthMeter"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="txt_retypepassword" class="form-label">Confirm Access Code</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-redo"></i></span>
                            <input type="password" class="form-control" name="txt_retypepassword" id="txt_retypepassword" required />
                        </div>
                    </div>
                    
                    <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-submit">
                        <i class="fas fa-save me-2"></i>Update Access Code
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Password strength indicator
        document.getElementById('txt_newpassword').addEventListener('input', function() {
            const password = this.value;
            const strengthMeter = document.getElementById('strengthMeter');
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
            } else if (strength <= 4) {
                strengthMeter.style.background = 'var(--warning)';
            } else {
                strengthMeter.style.background = 'var(--success)';
            }
        });
    </script>
</body>
</html>