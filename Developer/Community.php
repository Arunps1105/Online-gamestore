<?php
include("../Assets/Connection/Connection.php");
session_start();

// Ensure user is logged in
if (!isset($_SESSION['did']) || empty($_SESSION['did'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission for new community
if(isset($_POST["btn_submit"])) {
    $communityname = $_POST["txt_name"];
    $communitydescription = $_POST["txt_description"];
    
    $photo = $_FILES["file_photo"]["name"];
    $path = $_FILES["file_photo"]["tmp_name"];
    move_uploaded_file($path, '../Assets/Files/developer/Community/'.$photo);

    $insQry = "INSERT INTO tbl_community(community_name, community_description, community_photo, developer_id) VALUES ('".$communityname."','".$communitydescription."','".$photo."','".$_SESSION['did']."')";
    
    if($Con->query($insQry)) {
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Community created successfully',
            confirmButtonColor: '#6c5ce7'
        }).then(() => {
            window.location='Community.php';
        });
        </script>";
    } else {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to create community',
            confirmButtonColor: '#6c5ce7'
        });
        </script>";
    }
}

// Handle community deletion
if(isset($_GET['delId'])) {
    // First check if the community belongs to the current user
    $checkQry = "SELECT * FROM tbl_community WHERE community_id='".$_GET['delId']."' AND developer_id='".$_SESSION['did']."'";
    $checkResult = $Con->query($checkQry);
    
    if($checkResult->num_rows > 0) {
        $delQry = "DELETE FROM tbl_community WHERE community_id='".$_GET['delId']."'";
       if($Con->query($delQry)) {
        echo '<script>alert("Community deleted"); window.location="Community.php";</script>';
    }else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to delete community',
                confirmButtonColor: '#6c5ce7'
            });
            </script>";
        }
    } else {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Unauthorized',
            text: 'You cannot delete this community',
            confirmButtonColor: '#6c5ce7'
        }).then(() => {
            window.location='Community.php';
        });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Communities | GameHub</title>
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
        
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: rgba(30, 30, 36, 0.9);
            backdrop-filter: blur(8px);
            border-right: 1px solid rgba(106, 90, 205, 0.4);
            padding: 1.5rem 1rem;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(106, 90, 205, 0.4);
        }
        
        .sidebar-title {
            font-family: 'Rajdhani', sans-serif;
            color: var(--neon);
            font-weight: 700;
            font-size: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--light);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
         .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            border-top: 1px solid rgba(108, 92, 231, 0.2);
        }
        
        .sidebar-menu a:hover {
            background: rgba(108, 92, 231, 0.2);
            color: var(--neon);
            transform: translateX(5px);
        }
        
        .sidebar-menu a.active {
            background: linear-gradient(90deg, rgba(108, 92, 231, 0.3), transparent);
            color: var(--neon);
            border-left: 3px solid var(--neon);
        }
        
        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            transition: all 0.3s ease;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(106, 90, 205, 0.4);
        }
        
        .page-title {
            font-family: 'Rajdhani', sans-serif;
            color: var(--neon);
            font-weight: 700;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0;
        }
        
        .btn-neon {
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
        
        .btn-neon::before {
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
        
        .btn-neon:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }
        
        .btn-neon:hover::before {
            opacity: 1;
        }
        
        .card {
            background: rgba(30, 30, 36, 0.8);
            border: 1px solid rgba(106, 90, 205, 0.4);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(8px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(108, 92, 231, 0.4);
            border-color: var(--accent);
        }
        
        .form-control, .form-select {
            background: rgba(30, 30, 36, 0.6);
            border: 1px solid rgba(106, 90, 205, 0.4);
            color: var(--light);
            border-radius: 8px;
            padding: 10px 15px;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(30, 30, 36, 0.8);
            border-color: var(--neon);
            color: var(--light);
            box-shadow: 0 0 0 0.25rem rgba(108, 92, 231, 0.25);
        }
        
        .table {
            color: var(--light);
            background: rgba(30, 30, 36, 0.8);
            border-radius: 16px;
            overflow: hidden;
        }
        
        .table th {
            background: rgba(108, 92, 231, 0.3);
            color: var(--neon);
            border-bottom: 1px solid rgba(106, 90, 205, 0.4);
        }
        
        .table td, .table th {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid rgba(106, 90, 205, 0.2);
        }
        
        .table-hover tbody tr:hover {
            background: rgba(108, 92, 231, 0.1);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ff4757, #e84118);
            border: none;
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
        
        
        .community-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid var(--primary);
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
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar-title, .sidebar-menu span {
                display: none;
            }
            
            .sidebar-menu a {
                justify-content: center;
            }
            
            .sidebar-menu i {
                margin-right: 0;
                font-size: 1.2rem;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
        
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">GameHub</h3>
        </div>
        <ul class="sidebar-menu">
            <li><a href="Homepage.php"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
            <li><a href="Community.php" class="active"><i class="fas fa-users"></i> <span> Create Community</span></a></li>
            <li><a href="Viewgame.php"><i class="fas fa-gamepad"></i> <span>Games catlog</span></a></li>
            <li><a href="Myprofile.php"><i class="fas fa-user"></i> <span>Profile</span></a></li>
            <li><a href="Communitys.php"><i class="fas fa-envelope"></i> <span> View Communities</span></a></li></ul>
           <div class="sidebar-footer">
             
                  
                    <a class="nav-link logout-btn" href="Logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-header">
            <h1 class="page-title">Manage Communities</h1>
            <button type="button" class="btn btn-neon" data-bs-toggle="modal" data-bs-target="#addCommunityModal">
                <i class="fas fa-plus-circle me-2"></i> Add Community
            </button>
        </div>

        <!-- Add Community Modal -->
        <div class="modal fade" id="addCommunityModal" tabindex="-1" aria-labelledby="addCommunityModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: rgba(30, 30, 36, 0.95); border: 1px solid rgba(106, 90, 205, 0.4);">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-neon" id="addCommunityModalLabel">Create New Community</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="txt_name" class="form-label">Community Name</label>
                                <input type="text" class="form-control" name="txt_name" id="txt_name" 
                                    title="Name Allows Only Alphabets,Spaces and First Letter Must Be Capital Letter" 
                                    pattern="^[A-Z]+[a-zA-Z ]*$" required />
                            </div>
                            <div class="mb-3">
                                <label for="file_photo" class="form-label">Community Photo</label>
                                <input type="file" class="form-control" name="file_photo" id="file_photo" required />
                            </div>
                            <div class="mb-3">
                                <label for="txt_description" class="form-label">Description</label>
                                <textarea class="form-control" name="txt_description" id="txt_description" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="btn_submit" class="btn btn-neon">Create Community</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Communities Table -->
        <div class="card">
            <?php
            $selQry = "SELECT * FROM tbl_community WHERE developer_id='".$_SESSION['did']."'";
            $result = $Con->query($selQry);
            
            if ($result->num_rows == 0) {
                echo '<div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p>You haven\'t created any communities yet. Start by creating one!</p>
                </div>';
            } else {
                echo '<div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
                
                $i = 0;
                while ($row = $result->fetch_assoc()) {
                    $i++;
                    echo '<tr>
                        <td>'.$i.'</td>
                        <td>'.htmlspecialchars($row['community_name']).'</td>
                        <td><img src="../Assets/Files/Developer/Community/'.htmlspecialchars($row['community_photo']).'" class="community-img" /></td>
                        <td>'.htmlspecialchars($row['community_description']).'</td>
                        <td>
                            <a href="Community.php?delId='.$row['community_id'].'" class="btn btn-danger btn-sm" onclick="return confirmDelete()">
                                <i class="fas fa-trash-alt"></i> Delete
                            </a>
                        </td>
                    </tr>';
                }
                
                echo '</tbody>
                    </table>
                </div>';
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        
        
        // Add animation to table rows
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                row.style.transition = `opacity 0.3s ease ${index * 0.1}s, transform 0.3s ease ${index * 0.1}s`;
                
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, 100);
            });
        });
    </script>
</body>
</html>