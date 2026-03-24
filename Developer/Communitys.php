<?php
include("../Assets/Connection/Connection.php");
session_start();

// Ensure user is logged in
if (!isset($_SESSION['did']) || empty($_SESSION['did'])) {
    echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Required',
        text: 'Please log in to join communities',
        confirmButtonColor: '#6c5ce7'
    }).then(() => {
        window.location='login.php';
    });
    </script>";
    exit;
}

// Handle join action
if (isset($_GET["gid"]) && is_numeric($_GET["gid"])) {
    $developerId = $_SESSION['did'];
    $communityId = $_GET["gid"];

    // Check if community exists
    $checkCommunity = "SELECT community_id FROM tbl_community WHERE community_id = '$communityId'";
    $result = $Con->query($checkCommunity);
    if ($result->num_rows == 0) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Not Found',
            text: 'Community does not exist',
            confirmButtonColor: '#6c5ce7'
        }).then(() => {
            window.location='Community.php';
        });
        </script>";
        exit;
    }

    // Check if user is already a member
    $checkMember = "SELECT * FROM tbl_member WHERE developer_id = '$developerId' AND community_id = '$communityId'";
    $memberResult = $Con->query($checkMember);
    if ($memberResult->num_rows > 0) {
        echo "<script>
        Swal.fire({
            icon: 'info',
            title: 'Already Joined',
            text: 'You are already a member of this community!',
            confirmButtonColor: '#6c5ce7'
        }).then(() => {
            window.location='Community.php';
        });
        </script>";
    } else {
        // Insert new member
        $insQry = "INSERT INTO tbl_member (developer_id, community_id, member_status) VALUES ('$developerId', '$communityId', 0)";
        if ($Con->query($insQry)) {
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Welcome!',
                text: 'You have successfully joined the community',
                confirmButtonColor: '#6c5ce7',
                timer: 2000
            }).then(() => {
                window.location='Community.php';
            });
            </script>";
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to join community',
                confirmButtonColor: '#6c5ce7'
            }).then(() => {
                window.location='Community.php';
            });
            </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Communities | GameHub</title>
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
            --neon-pink: #ff00ff;
            --neon-green: #00ff7f;
        }
        
        body {
            font-family: 'Oxanium', sans-serif;
            background: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            color: var(--light);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            padding-left: 250px; /* Added for sidebar */
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 15, 18, 0.92);
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
        
        /* Mobile Sidebar Toggle */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
            background: var(--primary);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .community-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .community-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .community-title {
            font-family: 'Rajdhani', sans-serif;
            color: var(--neon);
            font-weight: 700;
            font-size: 3.5rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            text-shadow: 0 0 10px var(--neon), 0 0 20px var(--neon);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .community-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--neon), transparent);
            border-radius: 50%;
            filter: blur(1px);
        }
        
        .community-subtitle {
            color: var(--secondary);
            font-size: 1.2rem;
            letter-spacing: 1px;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        .community-card {
            background: rgba(30, 30, 36, 0.8);
            border: 1px solid rgba(106, 90, 205, 0.4);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(8px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .community-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(108, 92, 231, 0.1) 0%, transparent 70%);
            transform: rotate(30deg);
            opacity: 0;
            transition: opacity 0.5s ease;
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
        
        .community-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(108, 92, 231, 0.4);
            border-color: var(--accent);
        }
        
        .community-card:hover::before {
            opacity: 1;
        }
        
        .community-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid var(--primary);
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .community-card:hover .community-img {
            border-color: var(--neon);
            box-shadow: 0 5px 20px rgba(0, 255, 252, 0.3);
        }
        
        .community-name {
            color: var(--neon);
            font-weight: 600;
            margin: 1rem 0;
            font-size: 1.3rem;
            position: relative;
            display: inline-block;
        }
        
        .community-name::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), transparent);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        
        .community-card:hover .community-name::after {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .btn-join {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            color: white;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-join::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--accent), var(--primary));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }
        
        .btn-join:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }
        
        .btn-join:hover::before {
            opacity: 1;
        }
        
        .btn-view {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--light);
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-view::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }
        
        .btn-view:hover {
            color: white;
            border-color: var(--neon);
        }
        
        .btn-view:hover::before {
            opacity: 0.2;
        }
        
        .badge-joined {
            background-color: rgba(0, 255, 127, 0.2);
            color: var(--neon-green);
            padding: 8px 15px;
            border-radius: 50px;
            font-weight: 600;
            border: 1px solid rgba(0, 255, 127, 0.3);
            transition: all 0.3s ease;
        }
        
        .badge-joined:hover {
            box-shadow: 0 0 10px rgba(0, 255, 127, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 0;
            background: rgba(30, 30, 36, 0.5);
            border-radius: 16px;
            backdrop-filter: blur(8px);
            border: 1px dashed var(--secondary);
        }
        
        .empty-state i {
            font-size: 4rem;
            color: var(--secondary);
            margin-bottom: 1.5rem;
            text-shadow: 0 0 10px rgba(162, 155, 254, 0.5);
        }
        
        .empty-state p {
            color: var(--secondary);
            font-size: 1.2rem;
            max-width: 500px;
            margin: 0 auto;
        }
        
        /* Glowing border effect */
        .glow-border {
            position: relative;
        }
        
        .glow-border::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: 18px;
            background: linear-gradient(45deg, var(--neon), var(--neon-pink), var(--primary));
            background-size: 200% 200%;
            z-index: -1;
            filter: blur(5px);
            opacity: 0;
            transition: opacity 0.5s ease;
            animation: gradientBG 3s ease infinite;
        }
         
        
        .community-card:hover.glow-border::after {
            opacity: 0.7;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Pixel grid background effect */
        .pixel-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(162, 155, 254, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(162, 155, 254, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
            z-index: -1;
            opacity: 0.5;
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
        }
        
        @media (max-width: 768px) {
            .community-title {
                font-size: 2.5rem;
            }
            
            .community-subtitle {
                font-size: 1rem;
            }
            
            .community-card {
                padding: 1rem;
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
            <li class="active">
                <a href="Communitys.php">
                    <i class="fas fa-users"></i>
                    <span>Communities</span>
                </a>
            </li>
            <!-- Add more navigation items as needed -->
        </ul>
        <div class="sidebar-footer">
            <ul class="sidebar-nav">
                  <li class="nav-item">
                    <a class="nav-link logout-btn" href="Logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Mobile sidebar toggle button (hidden on desktop) -->
    <button class="sidebar-toggle d-lg-none">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Pixel grid background effect -->
    <div class="pixel-grid"></div>

    <div class="community-container">
        <div class="community-header">
            <h1 class="community-title">Gaming Communities</h1>
            <p class="community-subtitle">Join your favorite gaming communities and connect with players worldwide. Find your squad, share strategies, and dominate the competition!</p>
        </div>

        <div class="row">
            <?php
            $selQry = "SELECT * FROM tbl_community";
            $result = $Con->query($selQry);
            
            if ($result->num_rows == 0) {
                echo '<div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-gamepad"></i>
                        <p>No communities found yet. Be the first to create one!</p>
                    </div>
                </div>';
            } else {
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $i++;
                    $developerId = $_SESSION['did'];
                    $communityId = $row['community_id'];
                    $checkMember = "SELECT * FROM tbl_member WHERE developer_id = '$developerId' AND community_id = '$communityId'";
                    $memberResult = $Con->query($checkMember);
                    $isMember = $memberResult->num_rows > 0;
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="community-card glow-border">
                            <img src="../Assets/Files/Developer/Community/<?php echo htmlspecialchars($row['community_photo']); ?>" class="community-img" alt="<?php echo htmlspecialchars($row['community_name']); ?>">
                            <h3 class="community-name"><?php echo htmlspecialchars($row['community_name']); ?></h3>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="CommunityChat.php?communityId=<?php echo $row['community_id']; ?>" class="btn btn-view">
                                    <i class="fas fa-comments me-2"></i> View
                                </a>
                                <?php if ($isMember) { ?>
                                    <span class="badge-joined">
                                        <i class="fas fa-check-circle me-2"></i> Joined
                                    </span>
                                <?php } else { ?>
                                    <a href="Communitys.php?gid=<?php echo $row['community_id']; ?>" class="btn btn-join">
                                        <i class="fas fa-plus-circle me-2"></i> Join
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
                      
        // Add subtle animation to cards when they come into view
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.community-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(card);
            });

            // Mobile sidebar toggle
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