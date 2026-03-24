<?php
include("../Assets/Connection/Connection.php");
session_start();
$selQry="select * from tbl_user where user_id = '".$_SESSION['uid']."' ";
$result=$Con->query($selQry);
$userdata=$result->fetch_assoc();

if(isset($_POST['btn_submit']))
{
    $name=$_POST['txt_name'];
    $email=$_POST['txt_email'];
    $contact=$_POST['txt_contact'];
    $address=$_POST['txt_address'];
    $upQry="update tbl_user set user_name='".$name."',user_email='".$email."',user_contact='".$contact."',user_address='".$address."' where user_id='".$_SESSION['uid']."' ";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gamer Profile</title>
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
            padding: 20px;
            position: relative;
            padding-left: 250px; /* Added for sidebar */
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
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: rgba(20, 20, 25, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(108, 92, 231, 0.2);
            z-index: 1000;
            padding: 20px 0;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(108, 92, 231, 0.2);
            margin-bottom: 20px;
        }
        
        .sidebar-brand {
            color: var(--neon);
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .sidebar-brand i {
            margin-right: 10px;
            font-size: 1.8rem;
        }
        
        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-nav li {
            position: relative;
        }
        
        .sidebar-nav li a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--light);
            text-decoration: none;
            transition: all 0.3s ease;
            font-family: 'Oxanium', sans-serif;
            font-weight: 600;
        }
        
        .sidebar-nav li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            color: var(--secondary);
        }
        
        .sidebar-nav li a:hover {
            background: rgba(108, 92, 231, 0.2);
            color: var(--neon);
        }
        
        .sidebar-nav li a:hover i {
            color: var(--neon);
        }
        
        .sidebar-nav li.active a {
            background: rgba(108, 92, 231, 0.3);
            color: var(--neon);
        }
        
        .sidebar-nav li.active a i {
            color: var(--neon);
        }
        
        .sidebar-nav li a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 3px;
            height: 100%;
            background: var(--neon);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .sidebar-nav li a:hover::before,
        .sidebar-nav li.active a::before {
            opacity: 1;
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            border-top: 1px solid rgba(108, 92, 231, 0.2);
        }
        
        .profile-edit-container {
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
        
        .profile-edit-container::before {
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
        
        .profile-edit-header {
            height: 120px;
            background: linear-gradient(135deg, rgba(108, 92, 231, 0.2), rgba(0, 206, 201, 0.2));
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .profile-edit-header h2 {
            font-family: 'Rajdhani', sans-serif;
            color: var(--neon);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(0, 255, 252, 0.5);
            margin: 0;
            z-index: 2;
        }
        
        .profile-edit-body {
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
        
        
        /* Mobile sidebar toggle button */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
            background: rgba(108, 92, 231, 0.8);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            body {
                padding-left: 0;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .profile-edit-container {
                margin-top: 70px;
            }
        }
        
        @media (max-width: 576px) {
            .profile-edit-container {
                margin: 70px 15px 15px;
            }
            
            .profile-edit-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                <i class="fas fa-gamepad"></i>
                <span>GameHub</span>
            </a>
        </div>
        <ul class="sidebar-nav">
            <li>
                <a href="Homepage.php">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="myprofile.php" class="active">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>
            
            <!-- Add more navigation items as needed -->
        </ul>
        <div class="sidebar-footer">
            <ul class="sidebar-nav">
                <li class="nav-item">
                    <div class="position-absolute bottom-0 start-0 p-3 w-100">
                    <a class="nav-link logout-btn" href="Logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Mobile sidebar toggle button (hidden on desktop) -->
    <button class="sidebar-toggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="profile-edit-container">
        <div class="profile-edit-header">
            <h2><i class="fas fa-user-edit me-2"></i>Edit Gamer Profile</h2>
        </div>
        
        <div class="profile-edit-body">
            <form id="form1" name="form1" method="post" action="">
                <div class="mb-3">
                    <label for="txt_name" class="form-label">Gamer Tag</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        <input type="text" class="form-control" name="txt_name" id="txt_name" 
                               title="Name Allows Only Alphabets, Spaces and First Letter Must Be Capital Letter" 
                               pattern="^[A-Z]+[a-zA-Z ]*$" required="required" 
                               value="<?php echo $userdata['user_name'] ?>">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="txt_email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" name="txt_email" id="txt_email" 
                               required="required" value="<?php echo $userdata['user_email'] ?>">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="txt_contact" class="form-label">Contact</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                        <input type="text" class="form-control" name="txt_contact" id="txt_contact" 
                               title="Phone number with 7-9 and remaining 9 digits with 0-9" 
                               required="required" value="<?php echo $userdata['user_contact'] ?>">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="txt_address" class="form-label">HQ Location</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                        <input type="text" class="form-control" name="txt_address" id="txt_address" 
                               required="required" value="<?php echo $userdata['user_address'] ?>">
                    </div>
                </div>
                
                <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-submit">
                    <i class="fas fa-save me-2"></i>Update Profile
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>