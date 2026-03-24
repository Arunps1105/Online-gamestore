
<?php
session_start();
include("../Assets/Connection/Connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameStore Pro - Developer Dashboard</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Gaming Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=Oxanium:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            /* Enhanced Color Palette */
            --primary-color: #3f75d2ff; /* Vibrant purple */
            --secondary-color: #c7a8ff;
            --accent-color: #00f9ff; /* Cyan */
            --dark-bg: #0a0a12; /* Deep space blue */
            --darker-bg: #07070e;
            --card-bg: #131320;
            --text-light: #f0f0ff;
            --text-lighter: #ffffff;
            --success-color: #00ffaa;
            --warning-color: #ffcc00;
            --danger-color: #ff4d6d;
            
            /* New Gradients */
            --main-gradient: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            --card-gradient: linear-gradient(145deg, #1a1a2e, #16213e);
            --sidebar-gradient: linear-gradient(180deg, #0f0c29, #302b63);
            
            /* Glow Effects */
            --glow-primary: 0 0 15px rgba(99, 255, 143, 0.6);
            --glow-accent: 0 0 15px rgba(0, 110, 255, 0.4);
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
        }
        
        body {
            background: 
                radial-gradient(circle at 10% 20%, rgba(138, 99, 255, 0.1) 0%, transparent 25%),
                radial-gradient(circle at 90% 80%, rgba(0, 249, 255, 0.1) 0%, transparent 25%),
                var(--dark-bg);
            color: var(--text-light);
            font-family: 'Oxanium', 'Rajdhani', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Premium Dark Sidebar */
        .sidebar {
            background: var(--sidebar-gradient);
            min-height: 100vh;
            box-shadow: 
                5px 0 30px rgba(138, 99, 255, 0.3),
                inset -2px 0 10px rgba(0, 249, 255, 0.1);
            position: fixed;
            width: var(--sidebar-width);
            transition: all 0.3s ease;
            z-index: 1000;
            border-right: 1px solid rgba(138, 99, 255, 0.2);
            backdrop-filter: blur(5px);
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        .nav-link {
            color: var(--text-light);
            border-radius: 8px;
            margin: 0.25rem 0;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-weight: 600;
            opacity: 0.9;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 3px;
            height: 100%;
            background: var(--accent-color);
            transform: scaleY(0);
            transition: transform 0.3s ease;
            transform-origin: bottom;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(138, 99, 255, 0.15);
            color: white;
            transform: translateX(5px);
            opacity: 1;
        }
        
        .nav-link.active {
            background-color: rgba(138, 99, 255, 0.25);
        }
        
        .nav-link.active::before {
            transform: scaleY(1);
        }
        
        .nav-link i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
            transition: all 0.3s ease;
            color: var(--accent-color);
        }
        
        /* Neon Welcome Card */
        .welcome-card {
            background: var(--main-gradient);
            border: none;
            border-radius: 12px;
            box-shadow: 
                0 0 20px rgba(138, 99, 255, 0.7),
                inset 0 0 10px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            position: relative;
        }
        
        .welcome-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255,255,255,0.1),
                rgba(255,255,255,0)
            );
            transform: rotate(30deg);
            animation: shine 6s infinite;
        }
        
        /* Enhanced Cards with 3D Effect */
        .dashboard-card {
            background: var(--card-gradient);
            border: 1px solid rgba(138, 99, 255, 0.2);
            border-radius: 12px;
            box-shadow: 
                0 10px 20px rgba(0, 0, 0, 0.3),
                var(--glow-primary);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            height: 100%;
            transform-style: preserve-3d;
            backdrop-filter: blur(5px);
        }
        
        .dashboard-card:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 
                0 15px 30px rgba(0, 0, 0, 0.4),
                var(--glow-primary),
                var(--glow-accent);
        }
        
        .card-icon {
            font-size: 2.5rem;
            color: var(--accent-color);
            margin-bottom: 15px;
            transition: all 0.3s ease;
            text-shadow: 0 0 10px rgba(0, 249, 255, 0.5);
        }
        
        .dashboard-card:hover .card-icon {
            transform: scale(1.2);
            color: var(--text-lighter);
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #e84393, #fd79a8);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(232, 67, 147, 0.3);
            width: 100%;
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
        
        .logo {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--text-lighter);
            letter-spacing: 1px;
            text-transform: uppercase;
            text-shadow: 0 0 10px rgba(138, 99, 255, 0.7);
            transition: all 0.3s ease;
            font-family: 'Rajdhani', sans-serif;
        }
        
        .logo:hover {
            text-shadow: 0 0 15px rgba(138, 99, 255, 0.9);
            transform: scale(1.05);
        }
        
        .logo span {
            color: var(--accent-color);
            font-weight: 800;
            text-shadow: 0 0 10px rgba(0, 249, 255, 0.7);
        }
        
        /* Modern scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(var(--primary-color), var(--accent-color));
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
        
        /* Glass morphism effect */
        .glass-card {
            background: rgba(30, 30, 48, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(138, 99, 255, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .glass-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, 
                      #ff00cc, #7b5cff, #00f0ff, #7b5cff);
            background-size: 400%;
            z-index: -1;
            border-radius: 14px;
            animation: borderGlow 8s linear infinite;
            opacity: 0.7;
        }
        
        /* Stats cards */
        .stat-card {
            background: rgba(10, 10, 25, 0.6);
            border-radius: 10px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            border-left: 3px solid var(--accent-color);
            box-shadow: 
                inset 5px 0 15px rgba(0, 249, 255, 0.1),
                0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .stat-card:hover {
            background: rgba(138, 99, 255, 0.1);
            transform: translateY(-3px);
            box-shadow: 
                inset 5px 0 15px rgba(0, 249, 255, 0.2),
                0 8px 20px rgba(0, 0, 0, 0.3);
        }
        
        /* Progress rings */
        .progress-ring {
            position: relative;
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
        }
        
        .progress-ring circle {
            transition: stroke-dashoffset 0.5s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
        
        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: var(--main-gradient);
            border-radius: 50%;
            box-shadow: 
                0 5px 20px rgba(138, 99, 255, 0.5),
                0 0 10px rgba(0, 249, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .fab:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 
                0 8px 25px rgba(138, 99, 255, 0.7),
                0 0 15px rgba(0, 249, 255, 0.7);
        }
        
        /* Animations */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0) rotate(0.5deg); }
            50% { transform: translateY(-10px) rotate(-0.5deg); }
        }
        
        @keyframes shine {
            0% { left: -100%; top: -100%; }
            100% { left: 100%; top: 100%; }
        }
        
        @keyframes borderGlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes pulseBackground {
            0% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        
        /* Developer Stats */
        .developer-stats {
            background: rgba(20, 20, 40, 0.7);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(138, 99, 255, 0.3);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(138, 99, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--accent-color);
        }
        
        .stat-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-lighter);
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: var(--secondary-color);
            opacity: 0.8;
        }
        
        /* Game Card Grid */
        .game-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .game-card {
            background: rgba(25, 25, 45, 0.7);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(138, 99, 255, 0.2);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(138, 99, 255, 0.3);
            border-color: var(--accent-color);
        }
        
        .game-card-img {
            height: 160px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .game-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 1rem;
        }
        
        .game-card-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: white;
        }
        
        .game-card-rating {
            color: var(--warning-color);
            font-size: 0.9rem;
        }
        
        .game-card-body {
            padding: 1rem;
        }
        
        .game-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
                overflow: hidden;
                backdrop-filter: blur(10px);
            }
            
            .sidebar .nav-text {
                display: none;
            }
            
            .sidebar .nav-link i {
                margin-right: 0;
                font-size: 1.3rem;
            }
            
            .main-content {
                margin-left: var(--sidebar-collapsed-width);
            }
            
            .logo-text {
                display: none;
            }
            
            .welcome-card {
                padding: 1rem;
            }
            
            .welcome-card h4 {
                font-size: 1rem;
            }
            
            .game-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }
        }
        
        @media (max-width: 768px) {
            .game-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar p-3">
        <div class="d-flex align-items-center mb-4">
            <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_vybwn7df.json" background="transparent" speed="1" style="width: 50px; height: 50px;" loop autoplay></lottie-player>
            <span class="logo ms-2"><span class="logo-text">Game<span>Store</span></span></span>
        </div>
        
        <div class="welcome-card p-3 mb-4 text-white animate__animated animate__fadeIn">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="mb-0">Welcome back,</h6>
                    <h4 class="mb-0 fw-bold"><?php echo $_SESSION['dname'] ?></h4>
                </div>
                <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_5tkzkblw.json" background="transparent" speed="1" style="width: 60px; height: 60px;" loop autoplay></lottie-player>
            </div>
        </div>
        
        <hr class="bg-secondary opacity-25">
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active animate__animated animate__fadeInLeft" href="Myprofile.php">
                  <i class="fas fa-user-circle"></i> 
                    <span class="nav-text">Developer Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft " href="Changepassword.php">
                    <i class="fas fa-key"></i>
                    <span class="nav-text">Change Password</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft" href="Communitys.php">
              <i class="fas fa-comments"></i>  
                    <span class="nav-text">View Communitys</span>
                </a>
            </li>
              
             <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft " href="Community.php">
                   <i class="fas fa-globe"></i>  
                    <span class="nav-text">Create Community</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft " href="Editprofile.php">
                    <i class="fas fa-user-edit"></i>
                    <span class="nav-text">Edit Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft " href="Mygames.php">
                    <i class="fas fa-gamepad"></i>
                    <span class="nav-text">My Games</span>
                </a>
            </li>
              <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft " href="Game.php">
                   <i class="fas fa-plus-circle"></i> 
                    <span class="nav-text">Upload Games</span>
                </a>
            </li>
        </ul>
        
        <div class="position-absolute bottom-0 start-0 p-3 w-100">
            <a href="../guest/Login.php" class="btn logout-btn d-block text-center animate__animated animate__fadeInUp animate__delay-2s">
                <i class="fas fa-sign-out-alt me-2"></i>
                <span class="nav-text">Logout</span>
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col">
                    <h2 class="fw-bold text-white mb-2">Developer Dashboard</h2>
                    <p class="text-muted opacity-75">Manage your games and developer profile</p>
                </div>
            </div>
            
            <!-- Developer Stats -->
            <div class="developer-stats glass-card animate__animated animate__fadeIn">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-gamepad"></i>
                            </div>
                            <div>
                                <div class="stat-value">12</div>
                                <div class="stat-label">Games Published</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div>
                                <div class="stat-value">4.8</div>
                                <div class="stat-label">Average Rating</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-download"></i>
                            </div>
                            <div>
                                <div class="stat-value">24.5K</div>
                                <div class="stat-label">Total Downloads</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <div class="stat-value">3</div>
                                <div class="stat-label">Active Communities</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card p-4 text-center animate__animated animate__fadeIn glass-card">
                        <i class="fas fa-user-crown card-icon"></i>
                        <h5 class="mb-3">Developer Profile</h5>
                        <p class="text-muted mb-3">View and manage your developer profile</p>
                        <a href="Myprofile.php" class="btn btn-sm btn-primary px-4">View Profile</a>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card p-4 text-center animate__animated animate__fadeIn  glass-card">
                        <i class="fas fa-key card-icon"></i>
                        <h5 class="mb-3">Security</h5>
                        <p class="text-muted mb-3">Change your password</p>
                        <a href="Changepassword.php" class="btn btn-sm btn-primary px-4">Change Password</a>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card p-4 text-center animate__animated animate__fadeIn  glass-card">
                        <i class="fas fa-users card-icon"></i>
                        <h5 class="mb-3">Communities</h5>
                        <p class="text-muted mb-3">Join developer communities</p>
                        <a href="Communitys.php" class="btn btn-sm btn-primary px-4">Join Now</a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Games Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold text-white">Your Recent Games</h4>
                        <a href="Viewgame.php" class="btn btn-sm btn-outline-primary">View All Games</a>
                    </div>
                    
                    <div class="game-grid">
                        <!-- Game Card 1 -->
                        <div class="game-card animate__animated animate__fadeIn">
                            <div class="game-card-img" style="background-image: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')">
                                <div class="game-card-overlay">
                                    <h5 class="game-card-title">Cyber Adventure</h5>
                                    <div class="game-card-rating">
                                        <i class="fas fa-star"></i> 4.7
                                    </div>
                                </div>
                            </div>
                            <div class="game-card-body">
                                <p class="text-muted mb-2">Action/Adventure</p>
                                <div class="d-flex justify-content-between">
                                    <span class="badge bg-primary">New Update</span>
                                    <span class="text-success">1.2M downloads</span>
                                </div>
                            </div>
                            <div class="game-card-footer">
                                <span class="text-muted">Last updated: 2 days ago</span>
                                <button class="btn btn-sm btn-outline-primary">Manage</button>
                            </div>
                        </div>
                        
                        <!-- Game Card 2 -->
                        <div class="game-card animate__animated animate__fadeIn animate__delay-1s">
                            <div class="game-card-img" style="background-image: url('https://images.unsplash.com/photo-1551103782-8ab07afd45c1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80')">
                                <div class="game-card-overlay">
                                    <h5 class="game-card-title">Space Odyssey</h5>
                                    <div class="game-card-rating">
                                        <i class="fas fa-star"></i> 4.9
                                    </div>
                                </div>
                            </div>
                            <div class="game-card-body">
                                <p class="text-muted mb-2">Strategy/Sci-Fi</p>
                                <div class="d-flex justify-content-between">
                                    <span class="badge bg-success">Featured</span>
                                    <span class="text-success">3.5M downloads</span>
                                </div>
                            </div>
                            <div class="game-card-footer">
                                <span class="text-muted">Last updated: 1 week ago</span>
                                <button class="btn btn-sm btn-outline-primary">Manage</button>
                            </div>
                        </div>
                        
                        <!-- Game Card 3 -->
                        <div class="game-card animate__animated animate__fadeIn animate__delay-2s">
                            <div class="game-card-img" style="background-image: url('https://images.unsplash.com/photo-1511512578047-dfb367046420?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80')">
                                <div class="game-card-overlay">
                                    <h5 class="game-card-title">Pixel Quest</h5>
                                    <div class="game-card-rating">
                                        <i class="fas fa-star"></i> 4.5
                                    </div>
                                </div>
                            </div>
                            <div class="game-card-body">
                                <p class="text-muted mb-2">RPG/Pixel</p>
                                <div class="d-flex justify-content-between">
                                    <span class="badge bg-warning">Update Pending</span>
                                    <span class="text-success">850K downloads</span>
                                </div>
                            </div>
                            <div class="game-card-footer">
                                <span class="text-muted">Last updated: 3 weeks ago</span>
                                <button class="btn btn-sm btn-outline-primary">Manage</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Performance Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="dashboard-card p-4 glass-card">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="fw-bold mb-3">Performance Overview</h4>
                                <p class="text-muted mb-4 opacity-75">Your game statistics and performance metrics</p>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="stat-card">
                                        <small class="text-primary opacity-85">Daily Active Users</small>
                                        <h3 class="mb-0 fw-bold mt-2">24K</h3>
                                        <div class="progress-ring">
                                            <svg width="80" height="80">
                                                <circle stroke="rgba(255,255,255,0.1)" stroke-width="6" fill="transparent" r="35" cx="40" cy="40"/>
                                                <circle class="progress-circle" stroke="var(--success-color)" stroke-width="6" stroke-dasharray="220" stroke-dashoffset="66" r="35" cx="40" cy="40"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-card">
                                        <small class="text-success opacity-85">Retention Rate</small>
                                        <h3 class="mb-0 fw-bold mt-2">72%</h3>
                                        <div class="progress-ring">
                                            <svg width="80" height="80">
                                                <circle stroke="rgba(255,255,255,0.1)" stroke-width="6" fill="transparent" r="35" cx="40" cy="40"/>
                                                <circle class="progress-circle" stroke="var(--primary-color)" stroke-width="6" stroke-dasharray="220" stroke-dashoffset="110" r="35" cx="40" cy="40"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-card">
                                        <small class="text-warning opacity-85">New Downloads</small>
                                        <h3 class="mb-0 fw-bold mt-2">1.2K</h3>
                                        <div class="progress-ring">
                                            <svg width="80" height="80">
                                                <circle stroke="rgba(255,255,255,0.1)" stroke-width="6" fill="transparent" r="35" cx="40" cy="40"/>
                                                <circle class="progress-circle" stroke="var(--warning-color)" stroke-width="6" stroke-dasharray="220" stroke-dashoffset="165" r="35" cx="40" cy="40"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <lottie-player 
                                    src="https://assets8.lottiefiles.com/packages/lf20_puciaact.json" 
                                    background="transparent" 
                                    speed="1" 
                                    style="width: 100%; height: 300px;" 
                                    loop 
                                    autoplay
                                    class="floating">
                                </lottie-player>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating Action Button -->
    <div class="fab animate__animated animate__fadeInUp animate__delay-1s" data-bs-toggle="tooltip" data-bs-placement="left" title="Add New Game">
        <i class="fas fa-plus"></i>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Enhanced animation trigger on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.dashboard-card, .game-card');
            const navLinks = document.querySelectorAll('.nav-link');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate__fadeInUp');
                    }
                });
            }, { threshold: 0.1 });
            
            cards.forEach(card => {
                observer.observe(card);
            });
            
            // Add active class to current page link
            const currentPage = window.location.pathname.split('/').pop();
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.classList.add('active');
                }
                
                link.addEventListener('click', function() {
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');