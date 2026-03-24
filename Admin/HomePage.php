<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gamestore::Admin Dashboard</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Rajdhani (Gaming Font) -->
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        :root {
            /* Enhanced Color Palette */
            --primary-color: #8a63ff; /* Vibrant purple */
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
            --glow-primary: 0 0 15px rgba(138, 99, 255, 0.6);
            --glow-accent: 0 0 15px rgba(0, 249, 255, 0.4);
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
        }
        
        body {
            background: 
                radial-gradient(circle at 10% 20%, rgba(138, 99, 255, 0.1) 0%, transparent 25%),
                radial-gradient(circle at 90% 80%, rgba(0, 249, 255, 0.1) 0%, transparent 25%),
                var(--dark-bg);
            color: var(--text-light);
            font-family: 'Rajdhani', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
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
        
        /* Dark Mode Toggle */
        .dark-mode-toggle {
            position: fixed;
            bottom: 100px;
            right: 30px;
            z-index: 1000;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
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
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar p-3">
        <div class="d-flex align-items-center mb-4">
            <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_vybwn7df.json" background="transparent" speed="1" style="width: 50px; height: 50px;" loop autoplay></lottie-player>
            <span class="logo ms-2"><span class="logo-text">Game<span>Hub</span></span></span>
        </div>
        
        <div class="welcome-card p-3 mb-4 text-white animate__animated animate__fadeIn">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="mb-0">Welcome back,</h6>
                    <h4 class="mb-0 fw-bold"><?php echo $_SESSION['aname']?></h4>
                </div>
                <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_5tkzkblw.json" background="transparent" speed="1" style="width: 60px; height: 60px;" loop autoplay></lottie-player>
            </div>
        </div>
        
        <hr class="bg-secondary opacity-25">
        
        <ul class="nav flex-column">
             
            <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft " href="District.php">
                    <i class="fas fa-map-marked-alt "></i>
                    <span class="nav-text">District</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft " href="Place.php">
                    <i class="fas fa-location-dot"></i>
                    <span class="nav-text">Place</span>
                </a>
            </li>
 
             
            <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft " href="Genre.php">
                    <i class="fas fa-tags"></i>
                    <span class="nav-text">Genre</span>
                </a>
            </li>
             
            </li>
            <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft " href="DeveloperVerification.php">
                    <i class="fas fa-user-check"></i>
                    <span class="nav-text">Developer Verification</span>
                </a>
            </li>

                    <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft " href="Viewcomplaint.php">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span class="nav-text">View Complaint</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft " href="Viewfeedback.php">
                    <i class="fas fa-comment-dots"></i>
                    <span class="nav-text">View Feedback</span>
                </a>
            </li>
             <li class="nav-item">
    <a class="nav-link animate__animated animate__fadeInLeft" href="Viewgame.php">
        <i class="fas fa-gamepad"></i>
        <span class="nav-text">View Game</span>
    </a>
</li>
  <li class="nav-item">
               <a class="nav-link animate__animated animate__fadeInLeft"href="Category.php">
                    <i class="fas fa-layer-group me-2"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link animate__animated animate__fadeInLeft" href="Subcategory.php">
                    <i class="fas fa-tag me-2"></i>
                    <span>Subcategories</span>
                </a>
            </li>
           
         
        <div class="position-absolute bottom-0 start-0 p-3 w-100">
           <a href="Logout.php" class="btn logout-btn d-block text-center animate__animated animate__fadeInUp animate__delay-1s">
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
                    <h2 class="fw-bold text-white mb-2">Dashboard Overview</h2>
                    <p class="text-muted opacity-75">Manage your game store administration</p>
                </div>
            </div>
            
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card p-4 text-center animate__animated animate__fadeIn  glass-card">
                        <i class="fas fa-users card-icon"></i>
                        <h5 class="mb-3">User Management</h5>
                        <p class="text-muted mb-3">Manage all registered users</p>
                        <a href="UserList.php" class="btn btn-sm btn-primary px-4">Go to Users</a>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card p-4 text-center animate__animated animate__fadeIn  glass-card">
                        <i class="fas fa-gamepad card-icon"></i>
                        <h5 class="mb-3">Game Catalog</h5>
                        <p class="text-muted mb-3">View and manage games</p>
                        <a href="Viewgame.php" class="btn btn-sm btn-primary px-4">View Games</a>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card p-4 text-center animate__animated animate__fadeIn  glass-card">
                        <i class="fas fa-user-check card-icon"></i>
                        <h5 class="mb-3">Developer Verification</h5>
                        <p class="text-muted mb-3">Approve new developers</p>
                        <a href="DeveloperVerification.php" class="btn btn-sm btn-primary px-4">Verify Developers</a>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card p-4 text-center animate__animated animate__fadeIn   glass-card">
                        <i class="fas fa-comments card-icon"></i>
                        <h5 class="mb-3">Feedbacks</h5>
                        <p class="text-muted mb-3">view feedback</p>
                        <a href="Viewfeedback.php" class="btn btn-sm btn-primary px-4">Feedbacks</a>
                    </div>
                </div>
             
                  <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card p-4 text-center animate__animated animate__fadeIn   glass-card">
                     	<i class="fas fa-tools card-icon"></i>
                        <h5 class="mb-3">Solved complaintlist</h5>
                        <p class="text-muted mb-3">View  Solved complaintlist</p>
                        <a href="Solvedcomplaintlist.php" class="btn btn-sm btn-primary px-4">Solved complaintlist  </a>
                    </div>
                </div>
                    
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card p-4 text-center animate__animated animate__fadeIn  glass-card">
                        <i class="fas fa-cog card-icon pulse-animation"></i>
                        <h5 class="mb-3">System Settings</h5>
                        <p class="text-muted mb-3">Configure categories and more</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="Category.php" class="btn btn-sm btn-outline-primary">Categories</a>
                            <a href="Subcategory.php" class="btn btn-sm btn-outline-primary">Subcategories</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-12">
                    <div class="dashboard-card p-4 glass-card">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="fw-bold mb-3">Quick Stats</h4>
                                <p class="text-muted mb-4 opacity-75">Recent activities and overview</p>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="stat-card">
                                        <small class="text-primary opacity-85">New Users</small>
                                        <h3 class="mb-0 fw-bold mt-2">24</h3>
                                        <div class="progress-ring">
                                            <svg width="80" height="80">
                                                <circle stroke="rgba(255,255,255,0.1)" stroke-width="6" fill="transparent" r="35" cx="40" cy="40"/>
                                                <circle class="progress-circle" stroke="var(--success-color)" stroke-width="6" stroke-dasharray="220" stroke-dashoffset="66" r="35" cx="40" cy="40"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-card">
                                        <small class="text-success opacity-85">Games Added</small>
                                        <h3 class="mb-0 fw-bold mt-2">12</h3>
                                        <div class="progress-ring">
                                            <svg width="80" height="80">
                                                <circle stroke="rgba(255,255,255,0.1)" stroke-width="6" fill="transparent" r="35" cx="40" cy="40"/>
                                                <circle class="progress-circle" stroke="var(--primary-color)" stroke-width="6" stroke-dasharray="220" stroke-dashoffset="110" r="35" cx="40" cy="40"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-card">
                                        <small class="text-warning opacity-85">Pending Verifications</small>
                                        <h3 class="mb-0 fw-bold mt-2">5</h3>
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
            
            <!-- New System Health Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="dashboard-card p-4 glass-card">
                        <h4 class="fw-bold mb-4">System Health</h4>
                        <div class="row">
                            <div class="col-md-3 col-6 mb-4">
                                <div class="text-center">
                                    <div class="progress-ring mb-2">
                                        <svg width="100" height="100">
                                            <circle stroke="rgba(255,255,255,0.1)" stroke-width="8" fill="transparent" r="45" cx="50" cy="50"/>
                                            <circle class="progress-circle" stroke="var(--success-color)" stroke-width="8" stroke-dasharray="283" stroke-dashoffset="28" r="45" cx="50" cy="50"/>
                                        </svg>
                                    </div>
                                    <h5 class="mb-1">Server Load</h5>
                                    <p class="text-muted mb-0">90% Healthy</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-4">
                                <div class="text-center">
                                    <div class="progress-ring mb-2">
                                        <svg width="100" height="100">
                                            <circle stroke="rgba(255,255,255,0.1)" stroke-width="8" fill="transparent" r="45" cx="50" cy="50"/>
                                            <circle class="progress-circle" stroke="var(--primary-color)" stroke-width="8" stroke-dasharray="283" stroke-dashoffset="85" r="45" cx="50" cy="50"/>
                                        </svg>
                                    </div>
                                    <h5 class="mb-1">Database</h5>
                                    <p class="text-muted mb-0">70% Capacity</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-4">
                                <div class="text-center">
                                    <div class="progress-ring mb-2">
                                        <svg width="100" height="100">
                                            <circle stroke="rgba(255,255,255,0.1)" stroke-width="8" fill="transparent" r="45" cx="50" cy="50"/>
                                            <circle class="progress-circle" stroke="var(--accent-color)" stroke-width="8" stroke-dasharray="283" stroke-dashoffset="57" r="45" cx="50" cy="50"/>
                                        </svg>
                                    </div>
                                    <h5 class="mb-1">API Response</h5>
                                    <p class="text-muted mb-0">80% Faster</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-4">
                                <div class="text-center">
                                    <div class="progress-ring mb-2">
                                        <svg width="100" height="100">
                                            <circle stroke="rgba(255,255,255,0.1)" stroke-width="8" fill="transparent" r="45" cx="50" cy="50"/>
                                            <circle class="progress-circle" stroke="var(--warning-color)" stroke-width="8" stroke-dasharray="283" stroke-dashoffset="113" r="45" cx="50" cy="50"/>
                                        </svg>
                                    </div>
                                    <h5 class="mb-1">Uptime</h5>
                                    <p class="text-muted mb-0">60% Stable</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
     
    
    
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Enhanced animation trigger on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.dashboard-card');
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
                });
            });
            
            // Dark mode toggle functionality
            const darkModeSwitch = document.getElementById('darkModeSwitch');
            darkModeSwitch.addEventListener('change', function() {
                document.body.classList.toggle('light-mode', !this.checked);
            });
            
            // Fab button click handler
            document.querySelector('.fab').addEventListener('click', function() {
                alert('Quick action triggered!');
            });
            
            // Animate progress rings
            const progressCircles = document.querySelectorAll('.progress-circle');
            progressCircles.forEach(circle => {
                const dashoffset = circle.getAttribute('stroke-dashoffset');
                circle.style.strokeDashoffset = dashoffset;
            });
        });
    </script>
</body>
</html>