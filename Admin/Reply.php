<?php 
include("../Assets/Connection/Connection.php");
session_start();

if (isset($_POST['btn_submit'])) {
    $reply = $_POST['txt_reply'];
    $cid = $_GET['cid'];
      
    $upqry = "update tbl_complaint set complaint_reply = '".$reply."' , complaint_status=1 where complaint_id = '".$cid."'";
    if($Con->query($upqry))
        {
            ?>
            <script>
            alert("Reply Submitted!");
            window.location="Viewcomplaint.php";
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
    <title>GameStore::Complaint Reply</title>
    <!-- Bootstrap Dark CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            --error: #ff4757;
            --success: #00ff7f;
        }
        
        body {
            font-family: 'Oxanium', sans-serif;
            background: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            color: var(--light);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            padding-left: 250px;
            transition: padding-left 0.3s ease;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 15, 18, 0.9);
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
            backdrop-filter: blur(8px);
            border-right: 1px solid rgba(108, 92, 231, 0.3);
            padding: 20px 0;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }
        
        .sidebar-header {
            text-align: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(108, 92, 231, 0.3);
        }
        
        .sidebar-title {
            color: var(--neon);
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .nav-item {
            margin: 5px 0;
        }
        
        .nav-link {
            color: var(--secondary);
            padding: 12px 25px;
            border-radius: 0 30px 30px 0;
            margin: 0 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background: linear-gradient(90deg, rgba(108, 92, 231, 0.2), transparent);
            border-left: 3px solid var(--neon);
        }
        
        .nav-link:hover i, .nav-link.active i {
            color: var(--neon);
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
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            text-align: center;
            border-top: 1px solid rgba(108, 92, 231, 0.3);
        }
        
        .sidebar-toggle {
            position: fixed;
            left: 260px;
            top: 20px;
            background: rgba(30, 30, 36, 0.8);
            border: none;
            color: var(--neon);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1001;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 255, 252, 0.3);
        }
        
        .sidebar-toggle:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(0, 255, 252, 0.5);
        }
        
        .sidebar-collapsed {
            padding-left: 80px;
        }
        
        .sidebar-collapsed .sidebar {
            width: 80px;
            overflow: hidden;
        }
        
        .sidebar-collapsed .sidebar-header,
        .sidebar-collapsed .sidebar-footer,
        .sidebar-collapsed .nav-text {
            display: none;
        }
        
        .sidebar-collapsed .nav-link {
            justify-content: center;
            padding: 12px 0;
            margin: 5px 0;
            border-radius: 0;
        }
        
        .sidebar-collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.3rem;
        }
        
        .sidebar-collapsed .sidebar-toggle {
            left: 90px;
        }
        
        .portal-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
        }
        
        .portal-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .portal-title {
            font-family: 'Rajdhani', sans-serif;
            color: var(--neon);
            font-weight: 700;
            font-size: 3.5rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 0 0 20px rgba(0, 255, 252, 0.5);
            margin-bottom: 1rem;
        }
        
        .portal-subtitle {
            color: var(--secondary);
            font-size: 1.2rem;
            letter-spacing: 1px;
        }
        
        .game-card {
            background: rgba(30, 30, 36, 0.8);
            border: 1px solid rgba(106, 90, 205, 0.4);
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(8px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(108, 92, 231, 0.4);
            border-color: var(--accent);
        }
        
        .card-title {
            color: var(--neon);
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .card-title i {
            margin-right: 12px;
            font-size: 1.8rem;
        }
        
        .form-control {
            background-color: rgba(15, 15, 18, 0.8);
            border: 1px solid var(--primary);
            color: var(--light);
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background-color: rgba(15, 15, 18, 0.9);
            color: var(--light);
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(0, 206, 201, 0.25);
        }
        
        textarea.form-control {
            min-height: 150px;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            color: white;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 12px 30px;
            border-radius: 50px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.4);
            position: relative;
            overflow: hidden;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.6);
        }
        
        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        
        .btn-submit:hover::before {
            left: 100%;
        }
        
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
                display: flex;
                left: 20px;
            }
            
            .portal-container {
                padding: 1rem;
            }
            
            .portal-title {
                font-size: 2.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .portal-title {
                font-size: 2rem;
            }
            
            .game-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">Game Portal</h3>
        </div>
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="Homepage.php">
                        <i class="fas fa-home"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Feedback.php">
                        <i class="fas fa-comment-alt"></i>
                        <span class="nav-text">Feedback</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="Viewcomplaint.php">
                        <i class="fas fa-exclamation-circle"></i>
                        <span class="nav-text">Complaints</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link logout-btn" href="Logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <small class="text-muted">Game Portal v1.0</small>
        </div>
    </div>
    
    <button class="sidebar-toggle d-lg-none">
        <i class="fas fa-bars"></i>
    </button>

    <div class="portal-container">
        <div class="portal-header">
            <h1 class="portal-title">Complaint Response</h1>
            <p class="portal-subtitle">Submit your reply to the user's complaint</p>
        </div>

        <div class="game-card">
            <h3 class="card-title"><i class="fas fa-reply"></i> Submit Response</h3>
            <form id="form1" name="form1" method="post" action="">
                <div class="mb-4">
                    <label for="txt_reply" class="form-label">Your Response</label>
                    <textarea class="form-control" name="txt_reply" id="txt_reply" rows="5" required placeholder="Enter your detailed response to the user's complaint..."></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-submit">
                        <i class="fas fa-paper-plane me-2"></i> Submit Response
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle sidebar on mobile
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>