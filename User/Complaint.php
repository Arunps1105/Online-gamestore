<?php 
include("../Assets/Connection/Connection.php");
session_start();

if(isset($_POST['btn_submit'])) {
    $title = $_POST['txt_title'];
    $content = $_POST['txt_content'];

    $insqry = "insert into tbl_complaint(complaint_title,complaint_content,complaint_date,user_id) values('".$title."','".$content."',curdate(),'".$_SESSION['uid']."')";
    if($Con->query($insqry)) {
        ?>
        <script>
            alert("Complaint Submitted");
            window.location="Complaint.php";
        
        </script>
        <?php
    }
}

if(isset($_GET['delId'])) {
    $delQry = "delete from tbl_complaint where complaint_id='".$_GET['delId']."'";
    if($Con->query($delQry)) {
        ?>
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Your complaint has been removed',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            window.location="Complaint.php";
        });
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
    <title>Game Support Portal | Complaint System</title>
    <!-- Bootstrap Dark CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet">
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@1.5.7/dist/lottie-player.js"></script>
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
            padding-left: 250px; /* Added for sidebar */
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
        
        .complaints-table {
            background: rgba(30, 30, 36, 0.8);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(8px);
        }
        
        .table-dark {
            background-color: transparent;
            color: var(--light);
            margin-bottom: 0;
        }
        
        .table-dark thead th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: none;
        }
        
        .table-dark tbody tr {
            transition: all 0.2s ease;
        }
        
        .table-dark tbody tr:hover {
            background-color: rgba(108, 92, 231, 0.1);
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .status-pending {
            background-color: rgba(255, 165, 0, 0.2);
            color: orange;
            border: 1px solid orange;
        }
        
        .status-resolved {
            background-color: rgba(0, 255, 127, 0.2);
            color: var(--success);
            border: 1px solid var(--success);
        }
        
        .action-btn {
            color: var(--secondary);
            font-size: 1.1rem;
            margin: 0 8px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .action-btn:hover {
            color: var(--neon);
            transform: scale(1.2);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 0;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: var(--secondary);
            margin-bottom: 1.5rem;
        }
        
        .empty-state p {
            color: var(--secondary);
            font-size: 1.2rem;
        }
        
        .floating-icons {
            position: absolute;
            width: 100px;
            height: 100px;
            opacity: 0.7;
            z-index: -1;
            animation: float 6s ease-in-out infinite;
        }
        
        .icon-1 { top: 10%; left: 5%; animation-delay: 0s; }
        .icon-2 { top: 25%; right: 8%; animation-delay: 1s; }
        .icon-3 { bottom: 20%; left: 10%; animation-delay: 2s; }
        .icon-4 { bottom: 15%; right: 5%; animation-delay: 1.5s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
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
            
            .floating-icons {
                width: 70px;
                height: 70px;
                opacity: 0.5;
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
            <h1 class="portal-title">Game Support Portal</h1>
            <p class="portal-subtitle">Submit and track your game-related complaints</p>
        </div>

        <div class="game-card">
            <h3 class="card-title"><i class="fas fa-headset"></i> Submit New Complaint</h3>
            <form id="form1" name="form1" method="post" action="">
                <div class="mb-4">
                    <label for="txt_title" class="form-label">Complaint Title</label>
                    <input type="text" class="form-control" name="txt_title" id="txt_title" required placeholder="e.g. Game Bug, Purchase Issue, etc.">
                </div>
                <div class="mb-4">
                    <label for="txt_content" class="form-label">Detailed Description</label>
                    <textarea class="form-control" name="txt_content" id="txt_content" rows="5" required placeholder="Please describe your issue in detail..."></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-submit">
                        <i class="fas fa-paper-plane me-2"></i> Submit Complaint
                    </button>
                </div>
            </form>
        </div>

        <div class="game-card">
            <h3 class="card-title"><i class="fas fa-clipboard-list"></i> Your Complaints</h3>
            <div class="complaints-table">
                <table class="table table-dark table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selQry = "select * from tbl_complaint where user_id='".$_SESSION['uid']."'";
                        $row = $Con->query($selQry);
                        $i = 0;
                        
                        if($row->num_rows > 0) {
                            while($data = $row->fetch_assoc()) {
                                $i++;
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo htmlspecialchars($data['complaint_title']) ?></td>
                            <td><?php echo htmlspecialchars($data['complaint_content']) ?></td>
                            <td>
                                <?php if(isset($data['complaint_reply']) && !empty($data['complaint_reply'])): ?>
                                    <span class="status-badge status-resolved" title="<?php echo htmlspecialchars($data['complaint_reply']) ?>">
                                        <i class="fas fa-check-circle me-1"></i> Resolved
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock me-1"></i> Pending
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(isset($data['complaint_reply']) && !empty($data['complaint_reply'])): ?>
                                    <a href="#" class="action-btn" title="View Response" onclick="Swal.fire({
                                        title: 'Support Response',
                                        html: '<p><strong>Your Complaint:</strong><br><?php echo addslashes(htmlspecialchars($data['complaint_title'])) ?></p><p><strong>Our Response:</strong><br><?php echo addslashes(htmlspecialchars($data['complaint_reply'])) ?></p>',
                                        icon: 'info',
                                        confirmButtonColor: 'var(--primary)'
                                    })">
                                        <i class="fas fa-comment-alt"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="#" class="action-btn" title="Delete" onclick="confirmDelete(<?php echo $data['complaint_id'] ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <lottie-player src="https://lottie.host/437ca42d-b3d5-4abb-83aa-335c5afc5646/TEvMDyGRfZ.json" background="transparent" speed="1" style="width: 150px; height: 150px; margin: 0 auto;" loop autoplay></lottie-player>
                                    <p>No complaints submitted yet</p>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Toggle sidebar on mobile
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
        
        function confirmDelete(id) {
            Swal.fire({
                title: 'Delete Complaint?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--primary)',
                cancelButtonColor: 'var(--error)',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'Complaint.php?delId=' + id;
                }
            });
        }
        
        // Make floating icons draggable
        document.querySelectorAll('.floating-icons').forEach(icon => {
            let isDragging = false;
            let offsetX, offsetY;
            
            icon.addEventListener('mousedown', (e) => {
                isDragging = true;
                offsetX = e.clientX - icon.getBoundingClientRect().left;
                offsetY = e.clientY - icon.getBoundingClientRect().top;
                icon.style.cursor = 'grabbing';
            });
            
            document.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                
                icon.style.left = (e.clientX - offsetX) + 'px';
                icon.style.top = (e.clientY - offsetY) + 'px';
            });
            
            document.addEventListener('mouseup', () => {
                isDragging = false;
                icon.style.cursor = 'grab';
            });
        });
    </script>
</body>
</html>