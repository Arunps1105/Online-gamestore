<?php
include("../Assets/Connection/Connection.php");
session_start();
$selQry="select * from tbl_user u inner join tbl_place p on p.place_id=u.place_id inner join tbl_district d on p.district_id=d.district_id where user_id='".$_SESSION['uid']."' ";
$result=$Con->query($selQry);
$userdata=$result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamer Profile</title>
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
        
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: rgba(15, 15, 18, 0.95);
            border-right: 1px solid rgba(106, 90, 205, 0.3);
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
        }
        
        .sidebar-brand {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(106, 90, 205, 0.2);
            margin-bottom: 1rem;
        }
        
        .sidebar-brand h3 {
            color: var(--neon);
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(0, 255, 252, 0.5);
        }
        
        .nav-item {
            padding: 0.5rem 1.5rem;
            margin: 0.25rem 0;
        }
        
        .nav-link {
            color: var(--light);
            border-radius: 5px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .nav-link:hover {
            background: rgba(108, 92, 231, 0.2);
            color: var(--accent);
            transform: translateX(5px);
        }
        
        .nav-link.active {
            background: linear-gradient(90deg, rgba(108, 92, 231, 0.3), transparent);
            color: var(--neon);
            border-left: 3px solid var(--neon);
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
            color: white;
            margin: 1rem auto;
            display: block;
            text-align: center;
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
        
        @keyframes shine {
            0% { transform: rotate(30deg) translate(-10%, -10%); }
            100% { transform: rotate(30deg) translate(100%, 100%); }
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(232, 67, 147, 0.4);
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .profile-container {
            max-width: 900px;
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
            height: 180px;
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
            margin-top: -80px;
            text-align: center;
            z-index: 10;
        }
        
        .profile-pic {
            width: 150px;
            height: 150px;
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
            padding: 2rem;
            position: relative;
        }
        
        .profile-title {
            font-family: 'Rajdhani', sans-serif;
            text-align: center;
            color: var(--neon);
            font-weight: 700;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            font-size: 2rem;
            text-shadow: 0 0 10px rgba(0, 255, 252, 0.5);
        }
        
        .profile-title::after {
            content: '';
            display: block;
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            margin: 15px auto;
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(0, 206, 201, 0.5);
        }
        
        .detail-card {
            background: rgba(30, 30, 36, 0.7);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }
        
        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            border-left: 4px solid var(--accent);
        }
        
        .detail-icon {
            font-size: 1.5rem;
            color: var(--accent);
            margin-right: 1rem;
            text-shadow: 0 0 5px rgba(0, 206, 201, 0.7);
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .detail-value {
            color: var(--light);
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        .action-btns {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .btn-edit {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: var(--dark);
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
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
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 206, 201, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
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
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(162, 155, 254, 0.1);
            color: var(--secondary);
            border: 1px solid rgba(162, 155, 254, 0.3);
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 0 15px rgba(108, 92, 231, 0.5);
            border-color: var(--primary);
        }
        
        .gamer-tag {
            text-align: center;
            margin-top: 1rem;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 600;
            color: var(--accent);
            text-shadow: 0 0 5px rgba(0, 206, 201, 0.5);
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h3>Gamer Hub</h3>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="Homepage.php">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="Myprofile.php">
                    <i class="fas fa-user"></i>
                    <span class="nav-text">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Editprofile.php">
                    <i class="fas fa-user-edit"></i>
                    <span class="nav-text">Edit Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Changepassword.php">
                    <i class="fas fa-key"></i>
                    <span class="nav-text">Change Password</span>
                </a>
            </li>
        </ul>
        
        <div class="mt-auto">
            <a href="Logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-container">
            <div class="profile-header"></div>
            
            <div class="profile-pic-container">
                <img src="../Assets/Files/User/Photo/<?php echo $userdata['user_photo'] ?>" class="profile-pic" alt="Profile Photo">
            </div>
            
            <div class="profile-body">
                <h1 class="profile-title">GAMER PROFILE</h1>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-user-tag detail-icon"></i>
                                <div>
                                    <div class="detail-label">Gamer Name</div>
                                    <div class="detail-value"><?php echo $userdata['user_name'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-envelope detail-icon"></i>
                                <div>
                                    <div class="detail-label">Email</div>
                                    <div class="detail-value"><?php echo $userdata['user_email'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-phone-alt detail-icon"></i>
                                <div>
                                    <div class="detail-label">Contact</div>
                                    <div class="detail-value"><?php echo $userdata['user_contact'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-map-marked-alt detail-icon"></i>
                                <div>
                                    <div class="detail-label">HQ Location</div>
                                    <div class="detail-value"><?php echo $userdata['user_address'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-globe-americas detail-icon"></i>
                                <div>
                                    <div class="detail-label">Region</div>
                                    <div class="detail-value"><?php echo $userdata['district_name'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-gamepad detail-icon"></i>
                                <div>
                                    <div class="detail-label">Home Base</div>
                                    <div class="detail-value"><?php echo $userdata['place_name'] ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="action-btns">
                    <a href="Editprofile.php" class="btn btn-edit">
                        <i class="fas fa-user-edit me-2"></i>Upgrade Profile
                    </a>
                    <a href="Changepassword.php" class="btn btn-change">
                        <i class="fas fa-key me-2"></i>Change Access Code
                    </a>
                </div>
                
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-steam"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-discord"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitch"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-playstation"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-xbox"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>