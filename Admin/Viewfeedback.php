<?php
include("../Assets/Connection/Connection.php");
session_start();
$selQry = "select * from tbl_feedback";
$result = $Con->query($selQry);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameHub::Feedback Management</title>
    
    <!-- Bootstrap 5 Dark Theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet">
    
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
            --primary: #8a63ff;
            --primary-light: #a78bff;
            --primary-dark: #6e4ce6;
            --accent: #00f9ff;
            --accent-light: #5dfbff;
            --danger: #ff4d6d;
            --warning: #ffcc00;
            --success: #00ffaa;
            --dark-1: #0a0a12;
            --dark-2: #07070e;
            --dark-3: #131320;
            --dark-4: #1a1a2e;
            --light-1: #f0f0ff;
            --light-2: #ffffff;
            --sidebar-width: 280px;
            --glow-primary: 0 0 15px rgba(138, 99, 255, 0.6);
            --glow-accent: 0 0 15px rgba(0, 249, 255, 0.4);
        }
        
        body {
            background: 
                radial-gradient(circle at 10% 20%, rgba(138, 99, 255, 0.1) 0%, transparent 25%),
                radial-gradient(circle at 90% 80%, rgba(0, 249, 255, 0.1) 0%, transparent 25%),
                var(--dark-1);
            color: var(--light-1);
            font-family: 'Rajdhani', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Premium Glass Cards */
        .glass-card {
            background: rgba(19, 19, 32, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(138, 99, 255, 0.15);
            border-radius: 16px;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.3),
                var(--glow-primary);
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .glass-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(138, 99, 255, 0.1),
                rgba(0, 249, 255, 0.05)
            );
            transform: rotate(30deg);
            animation: shine 8s infinite linear;
            z-index: -1;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 12px 40px rgba(0, 0, 0, 0.4),
                var(--glow-primary),
                var(--glow-accent);
        }
        
        /* Feedback Cards */
        .feedback-card {
            background: rgba(26, 26, 46, 0.7);
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }
        
        .feedback-card:hover {
            background: rgba(38, 38, 64, 0.8);
            transform: translateX(5px);
        }
        
        /* Table Styling */
        .table-custom {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(138, 99, 255, 0.05);
            --bs-table-hover-bg: rgba(138, 99, 255, 0.1);
            color: var(--light-1);
        }
        
        .table-custom thead th {
            border-bottom: 2px solid var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 10, 18, 0.9);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
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
        
        /* Empty State */
        .empty-state {
            min-height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, #0f0c29, #302b63);
            min-height: 100vh;
            box-shadow: 
                5px 0 30px rgba(138, 99, 255, 0.3),
                inset -2px 0 10px rgba(0, 249, 255, 0.1);
            position: fixed;
            width: var(--sidebar-width);
            z-index: 1000;
            border-right: 1px solid rgba(138, 99, 255, 0.2);
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
        }
        
        /* Animations */
        @keyframes shine {
            0% { left: -100%; top: -100%; }
            100% { left: 100%; top: 100%; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
                overflow: hidden;
            }
            
            .sidebar .nav-text {
                display: none;
            }
            
            .main-content {
                margin-left: 80px;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Animation -->
    <div class="loading-overlay" id="loadingOverlay">
        <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_usmfx6bp.json" 
            background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay>
        </lottie-player>
        <h3 class="mt-4 text-white">Loading Feedback</h3>
    </div>
    
    <!-- Sidebar Navigation -->
    <div class="sidebar p-3">
        <div class="d-flex align-items-center mb-4">
            <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_vybwn7df.json" 
                background="transparent" speed="1" style="width: 50px; height: 50px;" loop autoplay>
            </lottie-player>
            <span class="logo ms-2 text-white fw-bold">Game<span class="text-accent">Hub</span></span>
        </div>
        
        <div class="glass-card p-3 mb-4 text-white">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <h6 class="mb-0">Welcome back,</h6>
                    <h4 class="mb-0 fw-bold"><?php echo $_SESSION['aname']?></h4>
                </div>
                <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_5tkzkblw.json" 
                    background="transparent" speed="1" style="width: 60px; height: 60px;" loop autoplay>
                </lottie-player>
            </div>
        </div>
        
        <hr class="bg-secondary opacity-25">
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="HomePage.php">
                    <i class="fas fa-user-shield me-2"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="ViewFeedback.php">
                    <i class="fas fa-comment-alt me-2"></i>
                    <span> Customer Feedback </span>
                </a>
            </li>
            <!-- Additional menu items would go here -->
        </ul>
        
        <div class="position-absolute bottom-0 start-0 p-3 w-100">
            <a href="Logout.php" class="btn logout-btn d-block text-center animate__animated animate__fadeInUp animate__delay-1s">
                <i class="fas fa-sign-out-alt me-2"></i>
                <span class="nav-text">Logout</span>
            </a>
        </div>
    </div>
    
    <!-- Main Content Area -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col">
                    <h1 class="fw-bold text-white mb-2">
                        <i class="fas fa-comment-alt me-3"></i>
                        Customer Feedback
                    </h1>
                    <p class="text-muted">View and manage customer feedback submissions</p>
                </div>
                <div class="col-auto">
                    <lottie-player src="https://lottie.host/b089d391-7340-4549-839f-64b6c81e7ad3/sNCYV6EhoW.json" 
                        background="transparent" speed="1" style="width: 80px; height: 80px;" loop autoplay>
                    </lottie-player>
                </div>
            </div>
            
            <!-- Feedback Table Card -->
            <div class="glass-card animate__animated animate__fadeInUp">
                <div class="card-header bg-primary text-white border-0">
                    <h3 class="mb-0">
                        <i class="fas fa-list-ul me-2"></i>
                        Feedback List
                    </h3>
                </div>
                <div class="card-body">
                    <?php if($result->num_rows == 0): ?>
                        <div class="empty-state text-center py-5">
                            <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_kcsr6fcp.json" 
                                background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay>
                            </lottie-player>
                            <h4 class="mt-3 text-white">No feedback yet</h4>
                            <p class="text-muted">Customer feedback will appear here when submitted</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-custom table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th width="10%">#</th>
                                        <th>Feedback Content</th>
                                        <th width="20%">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 0;
                                    while($row = $result->fetch_assoc()):
                                        $i++;
                                    ?>
                                    <tr class="feedback-card">
                                        <td class="fw-bold"><?php echo $i; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-comment-dots text-primary me-3"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <?php echo $row["feedback_content"]; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar-alt text-warning me-2"></i>
                                            <?php echo $row["feedback_date"]; ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="glass-card p-3 text-center animate__animated animate__fadeInLeft">
                        <h5 class="text-muted mb-3">Total Feedback</h5>
                        <h2 class="text-primary mb-1"><?php echo $result->num_rows; ?></h2>
                        <lottie-player src="https://lottie.host/ebcf9762-b975-4b40-bf9c-6bd56d0f9e28/y2EFLm77nM.json" 
                            background="transparent" speed="1" style="width: 80px; height: 80px; margin: 0 auto;" loop autoplay>
                        </lottie-player>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card p-3 text-center animate__animated animate__fadeInUp">
                        <h5 class="text-muted mb-3">This Month</h5>
                        <h2 class="text-warning mb-2"><?php echo rand(3, $result->num_rows); ?></h2>
                        <lottie-player src="https://lottie.host/6c09af14-7e56-47bc-9c2a-f447d5b22ddf/g0oMbAeQnG.json" 
                            background="transparent" speed="1" style="width: 80px; height: 80px; margin: 0 auto;" loop autoplay>
                        </lottie-player>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-card p-3 text-center animate__animated animate__fadeInRight">
                        <h5 class="text-muted mb-3">Avg. Rating</h5>
                        <h2 class="text-success mb-0">4.2 <small>/ 5</small></h2>
                        <lottie-player src="https://lottie.host/5d83b895-6690-4301-bb4f-ea37974fcabf/Fwzjh0IlXT.json" 
                            background="transparent" speed="1" style="width: 80px; height: 80px; margin: 0 auto;" loop autoplay>
                        </lottie-player>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Loading animation
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loadingOverlay').style.opacity = '0';
                setTimeout(function() {
                    document.getElementById('loadingOverlay').style.display = 'none';
                }, 500);
            }, 1500);
        });
        
        // Animation trigger on scroll
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on scroll
            const animateOnScroll = () => {
                const cards = document.querySelectorAll('.glass-card');
                cards.forEach(card => {
                    const cardPosition = card.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.2;
                    
                    if(cardPosition < screenPosition) {
                        card.classList.add('animate__fadeInUp');
                    }
                });
            };
            
            // Initial check
            animateOnScroll();
            
            // Check on scroll
            window.addEventListener('scroll', animateOnScroll);
        });
    </script>
</body>
</html>