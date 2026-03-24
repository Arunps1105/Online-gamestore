<?php
include("../Assets/Connection/Connection.php");
session_start();
$selQry="select * from tbl_developer where developer_id='".$_SESSION['did']."' ";
$result=$Con->query($selQry);
$developerdata=$result->fetch_assoc();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Developer Profile</title>
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
        --discount: #ff4757;
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
        display: flex;
        flex-direction: column;
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
        flex-grow: 1;
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
    
    .sidebar-footer {
        padding: 15px;
        border-top: 1px solid rgba(106, 90, 205, 0.3);
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
        
        
    .main-content {
        margin-left: 250px;
        padding: 20px;
        width: calc(100% - 250px);
    }
    
    .profile-container {
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
    
    .profile-container::before {
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
    
    .profile-header {
        height: 120px;
        background: linear-gradient(135deg, rgba(108, 92, 231, 0.2), rgba(0, 206, 201, 0.2));
        position: relative;
        overflow: hidden;
    }
    
    .profile-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') center/cover;
        opacity: 0.1;
        z-index: 0;
    }
    
    .profile-pic-container {
        position: relative;
        margin-top: -60px;
        text-align: center;
        z-index: 10;
    }
    
    .profile-pic {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid var(--dark);
        object-fit: cover;
        box-shadow: 0 0 20px rgba(0, 206, 201, 0.5),
                    inset 0 0 10px rgba(0, 206, 201, 0.3);
        transition: all 0.3s ease;
        background: var(--dark);
    }
    
    .profile-pic:hover {
        transform: scale(1.05);
        box-shadow: 0 0 30px rgba(0, 206, 201, 0.7),
                    inset 0 0 15px rgba(0, 206, 201, 0.4);
    }
    
    .profile-body {
        padding: 1.5rem;
        position: relative;
    }
    
    .profile-title {
        font-family: 'Rajdhani', sans-serif;
        text-align: center;
        color: var(--neon);
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        position: relative;
        font-size: 1.5rem;
        text-shadow: 0 0 10px rgba(0, 255, 252, 0.5);
    }
    
    .profile-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 3px;
        background: linear-gradient(to right, var(--primary), var(--accent));
        margin: 10px auto;
        border-radius: 3px;
        box-shadow: 0 0 10px rgba(0, 206, 201, 0.5);
    }
    
    .detail-card {
        background: rgba(30, 30, 36, 0.7);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        border-left: 4px solid var(--primary);
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(5px);
    }
    
    .detail-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        border-left: 4px solid var(--accent);
    }
    
    .detail-row {
        display: flex;
        align-items: center;
    }
    
    .detail-icon {
        font-size: 1.2rem;
        color: var(--accent);
        margin-right: 1rem;
        text-shadow: 0 0 5px rgba(0, 206, 201, 0.7);
        min-width: 20px;
    }
    
    .detail-label {
        font-weight: 600;
        color: var(--secondary);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.25rem;
    }
    
    .detail-value {
        color: var(--light);
        font-size: 1rem;
        font-weight: 500;
    }
    
    .action-btns {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: var(--dark);
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(108, 92, 231, 0.5);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-edit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(108, 92, 231, 0.7);
        color: var(--dark);
    }
    
    .btn-change {
        background: transparent;
        color: var(--accent);
        border: 2px solid var(--accent);
        padding: 0.6rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 0 15px rgba(0, 206, 201, 0.3);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-change:hover {
        background: rgba(0, 206, 201, 0.1);
        transform: translateY(-3px);
        box-shadow: 0 0 25px rgba(0, 206, 201, 0.5);
        color: var(--accent);
    }
    
    .social-links {
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }
    
    .social-link {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(162, 155, 254, 0.1);
        color: var(--secondary);
        border: 1px solid rgba(162, 155, 254, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .social-link:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 0 15px rgba(108, 92, 231, 0.5);
        border-color: var(--primary);
    }
    
    @media (max-width: 768px) {
        .sidebar {
            width: 70px;
            overflow: hidden;
        }
        
        .sidebar-header h3, .sidebar-menu span {
            display: none;
        }
        
        .sidebar-menu i {
            margin-right: 0;
            font-size: 1.2rem;
        }
        
        .sidebar-menu a {
            padding: 15px;
            text-align: center;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin: 0 auto 10px;
        }
        
        .main-content {
            margin-left: 70px;
        }
    }
    
    @media (max-width: 576px) {
        .profile-container {
            max-width: 95%;
        }
        
        .profile-header {
            height: 100px;
        }
        
        .profile-pic {
            width: 100px;
            height: 100px;
        }
        
        .profile-body {
            padding: 1rem;
        }
        
        .action-btns {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .btn-edit, .btn-change {
            width: 100%;
            text-align: center;
        }
    }
</style>
</head>
<body>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-laptop-code"></i> <span>Developer Panel</span></h3>
        </div>
        
        <div class="sidebar-menu">
            <a href="Homepage.php" >
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="myprofile.php" class="active">
                <i class="fas fa-user-cog"></i>
                <span>My Profile</span>
            </a>
          
        </div>
        
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
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-container">
            <div class="profile-header"></div>
            
            <div class="profile-pic-container">
                <img src="../Assets/Files/Developer/Photo/<?php echo $developerdata['developer_photo'] ?>" class="profile-pic" alt="Developer Photo">
            </div>
            
            <div class="profile-body">
                <h1 class="profile-title">DEVELOPER PROFILE</h1>
                
                <!-- Developer Name -->
                <div class="detail-card">
                    <div class="detail-row">
                        <i class="fas fa-user-tag detail-icon"></i>
                        <div>
                            <div class="detail-label">Developer Name</div>
                            <div class="detail-value"><?php echo $developerdata['developer_name'] ?></div>
                        </div>
                    </div>
                </div>
                
                <!-- Developer Email -->
                <div class="detail-card">
                    <div class="detail-row">
                        <i class="fas fa-envelope detail-icon"></i>
                        <div>
                            <div class="detail-label">Email</div>
                            <div class="detail-value"><?php echo $developerdata['developer_email'] ?></div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-btns">
                    <a href="Editprofile.php" class="btn-edit">
                        <i class="fas fa-user-edit me-2"></i>Edit Profile
                    </a>
                    <a href="Changepassword.php" class="btn-change">
                        <i class="fas fa-key me-2"></i>Change Password
                    </a>
                </div>
                
                <!-- Social Links -->
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-discord"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>