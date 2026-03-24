<?php
include("../Assets/Connection/Connection.php");
session_start();

// Verify connection is established
if(!$Con) {
    die("Database connection failed: " . mysqli_connect_error());
}

if(isset($_GET["acid"]))
{
    $upqry="update tbl_developer set developer_status='1' where developer_id='".$_GET["acid"]."'";
    if($Con->query($upqry))
    {
        ?>
        <script>
        alert("Accepted successfully");
        window.location="DeveloperVerification.php";
        </script>
        <?php
    }
}

if(isset($_GET["rejid"]))
{
    $upqry="update tbl_developer set developer_status='2' where developer_id='".$_GET["rejid"]."'";
    if($Con->query($upqry))
    {
        ?>
        <script>
        alert("Rejected successfully");
        window.location="DeveloperVerification.php";
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameHub::Developer Verification</title>
    
    <!-- Bootstrap 5 Dark Theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet">
    
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
        
        /* Logout Button */
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
        
        /* Table Styling */
        .table {
            color: var(--light-1);
            backdrop-filter: blur(5px);
        }
        
        .table-hover tbody tr:hover {
            background: rgba(138, 99, 255, 0.1);
        }
        
        /* Developer Table Specific Styles */
        .developer-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .developer-table thead th {
            background: rgba(138, 99, 255, 0.1);
            color: var(--accent);
            padding: 0.8rem 1rem;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid var(--primary);
        }
        
        .developer-table tbody tr {
            background: rgba(30, 30, 48, 0.5);
            transition: all 0.2s ease;
        }
        
        .developer-table tbody tr:hover {
            background: rgba(138, 99, 255, 0.15);
        }
        
        .developer-table td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(138, 99, 255, 0.1);
        }
        
        /* Developer Avatar */
        .developer-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
            margin-right: 1rem;
        }
        
        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-pending {
            background: rgba(255, 204, 0, 0.15);
            color: var(--warning);
            border: 1px solid var(--warning);
        }
        
        .badge-accepted {
            background: rgba(0, 255, 170, 0.15);
            color: var(--success);
            border: 1px solid var(--success);
        }
        
        .badge-rejected {
            background: rgba(255, 77, 109, 0.15);
            color: var(--danger);
            border: 1px solid var(--danger);
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s ease;
            border: none;
        }
        
        .btn-accept {
            background: var(--success);
            color: #111;
        }
        
        .btn-reject {
            background: var(--danger);
            color: white;
        }
        
        .btn-download {
            background: var(--primary);
            color: white;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 0;
        }
        
        .empty-state .lottie-animation {
            width: 180px;
            height: 180px;
            margin: 0 auto 1rem;
        }
        
        /* Tabs */
        .nav-tabs {
            border-bottom: 1px solid rgba(138, 99, 255, 0.2);
            margin-bottom: 1.5rem;
        }
        
        .nav-tabs .nav-link {
            color: var(--light-1);
            padding: 0.8rem 1.5rem;
            border: none;
            font-weight: 600;
            opacity: 0.7;
            transition: all 0.2s ease;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--accent);
            opacity: 1;
            border-bottom: 3px solid var(--accent);
            background: transparent;
        }
        
        .nav-tabs .nav-link:hover {
            opacity: 1;
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
        
        @media (max-width: 768px) {
            .developer-table thead {
                display: none;
            }
            
            .developer-table tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 8px;
                overflow: hidden;
            }
            
            .developer-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.8rem;
                border-bottom: none;
            }
            
            .developer-table td::before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 1rem;
                color: var(--accent);
            }
            
            .action-buttons {
                justify-content: flex-end;
                width: 100%;
            }
            
            .developer-avatar {
                width: 50px;
                height: 50px;
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
        <h3 class="mt-4 text-white">Loading Developer Verification</h3>
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
                <a class="nav-link" href="DeveloperVerification.php">
                    <i class="fas fa-user-check me-2"></i>
                    <span> Developer Verification </span>
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
            <!-- Header Card -->
            <div class="glass-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white border-0">
                    <div>
                        <i class="fas fa-user-shield me-2"></i>Developer Verification Portal
                    </div>
                    <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_vybwn7df.json" 
                        background="transparent" speed="1" style="width: 50px; height: 50px;" loop autoplay>
                    </lottie-player>
                </div>
                <div class="card-body">
                    <p class="mb-0">Review and manage developer applications for your game store platform.</p>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" id="devTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                        <i class="fas fa-clock me-2"></i>Pending Review
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="accepted-tab" data-bs-toggle="tab" data-bs-target="#accepted" type="button" role="tab">
                        <i class="fas fa-check-circle me-2"></i>Approved
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab">
                        <i class="fas fa-times-circle me-2"></i>Rejected
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="devTabsContent">
                <!-- Pending Developers Tab -->
                <div class="tab-pane fade show active" id="pending" role="tabpanel">
                    <div class="glass-card">
                        <div class="card-header">
                            <i class="fas fa-users me-2"></i>New Developer Applications
                        </div>
                        <div class="card-body">
                            <?php
                            $selQry = "SELECT * FROM tbl_developer WHERE developer_status='0'";
                            $result = $Con->query($selQry);
                            
                            if($result && $result->num_rows > 0) {
                            ?>
                            <div class="table-responsive">
                                <table class="developer-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 25%">Developer</th>
                                            <th style="width: 30%">Contact</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 25%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        while($row = $result->fetch_assoc()) {
                                            $i++;
                                        ?>
                                        <tr>
                                            <td data-label="#"><?php echo $i ?></td>
                                            <td data-label="Developer">
                                                <div class="d-flex align-items-center">
                                                    <img src="../Assets/Files/Developer/Photo/<?php echo $row["developer_photo"]; ?>" 
                                                        class="developer-avatar" 
                                                        alt="<?php echo htmlspecialchars($row["developer_name"]); ?>">
                                                    <div>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($row["developer_name"]); ?></div>
                                                        <small class="text-muted">ID: DEV-<?php echo str_pad($row['developer_id'], 4, '0', STR_PAD_LEFT); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Contact">
                                                <div>
                                                    <div><i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($row["developer_email"]); ?></div>
                                                    <div class="mt-2">
                                                        <a href="../Assets/Files/Developer/Photo/<?php echo $row["developer_proof"]; ?>" 
                                                           download 
                                                           class="btn btn-download btn-action btn-sm">
                                                            <i class="fas fa-download me-1"></i> View Proof
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Status">
                                                <span class="status-badge badge-pending">Pending</span>
                                            </td>
                                            <td data-label="Actions">
                                                <div class="action-buttons">
                                                    <a href="DeveloperVerification.php?acid=<?php echo $row['developer_id']?>" 
                                                       class="btn btn-accept btn-action">
                                                        <i class="fas fa-check me-1"></i> Accept
                                                    </a>
                                                    <a href="DeveloperVerification.php?rejid=<?php echo $row['developer_id']?>" 
                                                       class="btn btn-reject btn-action">
                                                        <i class="fas fa-times me-1"></i> Reject
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } else { ?>
                            <div class="empty-state">
                                <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_khtt8ejx.json" 
                                    background="transparent" speed="1" class="lottie-animation" loop autoplay>
                                </lottie-player>
                                <h4>No pending applications</h4>
                                <p class="text-muted">All developer applications have been processed</p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Accepted Developers Tab -->
                <div class="tab-pane fade" id="accepted" role="tabpanel">
                    <div class="glass-card">
                        <div class="card-header">
                            <i class="fas fa-check-circle me-2"></i>Approved Developers
                        </div>
                        <div class="card-body">
                            <?php
                            $selQry = "SELECT * FROM tbl_developer WHERE developer_status='1'";
                            $result = $Con->query($selQry);
                            
                            if($result && $result->num_rows > 0) {
                            ?>
                            <div class="table-responsive">
                                <table class="developer-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 25%">Developer</th>
                                            <th style="width: 30%">Contact</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 25%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        while($row = $result->fetch_assoc()) {
                                            $i++;
                                        ?>
                                        <tr>
                                            <td data-label="#"><?php echo $i ?></td>
                                            <td data-label="Developer">
                                                <div class="d-flex align-items-center">
                                                    <img src="../Assets/Files/Developer/Photo/<?php echo $row["developer_photo"]; ?>" 
                                                        class="developer-avatar" 
                                                        alt="<?php echo htmlspecialchars($row["developer_name"]); ?>">
                                                    <div>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($row["developer_name"]); ?></div>
                                                        <small class="text-muted">ID: DEV-<?php echo str_pad($row['developer_id'], 4, '0', STR_PAD_LEFT); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Contact">
                                                <div>
                                                    <div><i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($row["developer_email"]); ?></div>
                                                    <div class="mt-2 text-success">
                                                        <i class="fas fa-calendar-check me-1"></i>Approved
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Status">
                                                <span class="status-badge badge-accepted">Verified</span>
                                            </td>
                                            <td data-label="Action">
                                                <div class="action-buttons">
                                                    <a href="DeveloperVerification.php?rejid=<?php echo $row['developer_id']?>" 
                                                       class="btn btn-reject btn-action">
                                                        <i class="fas fa-user-slash me-1"></i> Revoke
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } else { ?>
                            <div class="empty-state">
                                <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_yo4xtgbs.json" 
                                    background="transparent" speed="1" class="lottie-animation" loop autoplay>
                                </lottie-player>
                                <h4>No approved developers</h4>
                                <p class="text-muted">Accept some developers from pending applications</p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Rejected Developers Tab -->
                <div class="tab-pane fade" id="rejected" role="tabpanel">
                    <div class="glass-card">
                        <div class="card-header">
                            <i class="fas fa-times-circle me-2"></i>Rejected Developers
                        </div>
                        <div class="card-body">
                            <?php
                            $selQry = "SELECT * FROM tbl_developer WHERE developer_status='2'";
                            $result = $Con->query($selQry);
                            
                            if($result && $result->num_rows > 0) {
                            ?>
                            <div class="table-responsive">
                                <table class="developer-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 25%">Developer</th>
                                            <th style="width: 30%">Contact</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 25%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        while($row = $result->fetch_assoc()) {
                                            $i++;
                                        ?>
                                        <tr>
                                            <td data-label="#"><?php echo $i ?></td>
                                            <td data-label="Developer">
                                                <div class="d-flex align-items-center">
                                                    <img src="../Assets/Files/Developer/Photo/<?php echo $row["developer_photo"]; ?>" 
                                                        class="developer-avatar" 
                                                        alt="<?php echo htmlspecialchars($row["developer_name"]); ?>">
                                                    <div>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($row["developer_name"]); ?></div>
                                                        <small class="text-muted">ID: DEV-<?php echo str_pad($row['developer_id'], 4, '0', STR_PAD_LEFT); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Contact">
                                                <div>
                                                    <div><i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($row["developer_email"]); ?></div>
                                                    <div class="mt-2 text-danger">
                                                        <i class="fas fa-calendar-times me-1"></i>Rejected
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Status">
                                                <span class="status-badge badge-rejected">Rejected</span>
                                            </td>
                                            <td data-label="Action">
                                                <div class="action-buttons">
                                                    <a href="DeveloperVerification.php?acid=<?php echo $row['developer_id']?>" 
                                                       class="btn btn-accept btn-action">
                                                        <i class="fas fa-user-check me-1"></i> Approve
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } else { ?>
                            <div class="empty-state">
                                <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_yo4xtgbs.json" 
                                    background="transparent" speed="1" class="lottie-animation" loop autoplay>
                                </lottie-player>
                                <h4>No rejected developers</h4>
                                <p class="text-muted">All applications are approved or pending</p>
                            </div>
                            <?php } ?>
                        </div>
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
        
        // Add hover effects to table rows
        document.querySelectorAll('.developer-table tbody tr').forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.style.transform = 'translateX(5px)';
            });
            row.addEventListener('mouseleave', () => {
                row.style.transform = '';
            });
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