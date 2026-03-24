<?php
include("../Assets/Connection/Connection.php");
session_start();
$selQry = "select * from tbl_complaint c 
           inner join tbl_user u on c.user_id = u.user_id 
           where c.complaint_status='0'";
 
$result = $Con->query($selQry);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameHub::Complaint Management</title>
    
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
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
        
        /* Form Elements */
        .form-control, .form-select {
            background: rgba(30, 30, 48, 0.7);
            border: 1px solid rgba(138, 99, 255, 0.3);
            color: var(--light-1);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(40, 40, 64, 0.8);
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(138, 99, 255, 0.25);
            color: var(--light-2);
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(138, 99, 255, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(138, 99, 255, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #e84379);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        /* Table Styling */
        .table {
            color: var(--light-1);
            backdrop-filter: blur(5px);
        }
        
        .table-hover tbody tr:hover {
            background: rgba(138, 99, 255, 0.1);
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
        
        /* Action Buttons */
        .action-btn {
            min-width: 80px;
            margin-right: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        /* Avatar styling */
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .badge-new {
            background: linear-gradient(135deg, var(--danger), #e84379);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Animations */
        @keyframes shine {
            0% { left: -100%; top: -100%; }
            100% { left: 100%; top: 100%; }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
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
        <h3 class="mt-4 text-white">Loading Complaints</h3>
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
                <a class="nav-link active" href="ViewComplaint.php">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span> Complaints </span>
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
                        <i class="fas fa-exclamation-circle me-3"></i>
                        Customer Complaints
                    </h1>
                    <p class="text-muted">Manage and respond to customer feedback and issues</p>
                </div>
                <div class="col-auto">
                    <lottie-player src="https://lottie.host/31eba203-32f6-4365-ab3e-f69c2f5fb4b2/F5Kk7vJmA9.json" 
                        background="transparent" speed="1" style="width: 100px; height: 100px;" loop autoplay>
                    </lottie-player>
                </div>
            </div>
            
            <!-- Complaints Table Card -->
            <div class="glass-card animate__animated animate__fadeInUp">
                <div class="card-header bg-primary text-white border-0">
                    <h3 class="mb-0">
                        <i class="fas fa-list-ul me-2"></i>
                        Pending Complaints
                    </h3>
                </div>
                <div class="card-body">
                    <?php if($result->num_rows == 0): ?>
                        <div class="text-center py-5">
                            <lottie-player src="https://lottie.host/845ad241-7c36-40be-b9e7-835566a4b436/VjJpeWb2fw.json" 
                                background="transparent" speed="1" 
                                style="width: 300px; height: 300px; margin: 0 auto;" 
                                loop autoplay>
                            </lottie-player>
                            <h4 class="mt-3 text-white">No pending complaints</h4>
                            <p class="text-muted">All customer issues have been addressed</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr class="bg-dark">
                                        <th width="5%">#</th>
                                        <th width="20%">User</th>
                                        <th width="20%">Title</th>
                                        <th width="35%">Content</th>
                                        <th width="10%">Date</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 0;
                                    while($row = $result->fetch_assoc()): 
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar">
                                                    <?php echo strtoupper(substr($row["user_name"], 0, 1)); ?>
                                                </div>
                                                <div>
                                                    <strong><?php echo $row["user_name"]; ?></strong>
                                                    <div class="text-muted small">User ID: <?php echo $row["user_id"]; ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo $row["complaint_title"]; ?></td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <?php echo substr($row["complaint_content"], 0, 50); ?>...
                                                <span class="badge badge-danger rounded-pill">NEW</span>
                                            </div>
                                        </td>
                                        <td><?php echo date("M d, Y", strtotime($row["complaint_date"])); ?></td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="Reply.php?cid=<?php echo $row['complaint_id']; ?>" 
                                                   class="btn btn-primary btn-sm me-2"
                                                   data-bs-toggle="tooltip" data-bs-placement="top" title="Reply to complaint">
                                                    <i class="fas fa-reply"></i>
                                                </a>
                                                <button class="btn btn-danger btn-sm"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Mark as spam"
                                                        onclick="markAsSpam(<?php echo $row['complaint_id'] ?>)">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
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
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Mark as spam function
        function markAsSpam(complaintId) {
            Swal.fire({
                title: 'Mark as Spam?',
                text: "This will remove the complaint from your queue.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#8a63ff',
                cancelButtonColor: '#ff4d6d',
                confirmButtonText: 'Yes, mark as spam',
                background: '#0a0a12',
                color: '#f0f0ff',
                backdrop: `
                    rgba(10,10,18,0.8)
                    url("https://assets1.lottiefiles.com/packages/lf20_soCRK3.json")
                    center top
                    no-repeat
                `
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX call to mark as spam
                    fetch('mark_spam.php?id=' + complaintId)
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Marked as Spam',
                                    showConfirmButton: false,
                                    timer: 1500,
                                    background: '#0a0a12',
                                    color: '#f0f0ff'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        });
                }
            });
        }
        
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