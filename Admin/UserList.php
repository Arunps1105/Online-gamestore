<?php
include("../Assets/Connection/Connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameStore:: User Management</title>
    
    <!-- Bootstrap 5 Dark Theme -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&family=Rajdhani:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
        }
        
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
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 12px 40px rgba(0, 0, 0, 0.4),
                var(--glow-primary),
                var(--glow-accent);
        }
        
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
        
        .table {
            color: var(--light-1);
            backdrop-filter: blur(5px);
        }
        
        .table-hover tbody tr:hover {
            background: rgba(138, 99, 255, 0.1);
        }
        
        .page-header {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            margin-bottom: 2rem;
        }
        
        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(138, 99, 255, 0.2), rgba(0, 249, 255, 0.1));
            z-index: -1;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
            transition: all 0.3s ease;
        }
        
        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px var(--primary);
        }
        
        .gender-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .male {
            background: rgba(0, 149, 255, 0.2);
            color: #00a2ff;
            border: 1px solid #00a2ff;
        }
        
        .female {
            background: rgba(255, 0, 149, 0.2);
            color: #ff00a2;
            border: 1px solid #ff00a2;
        }
        
        .other {
            background: rgba(149, 255, 0, 0.2);
            color: #a2ff00;
            border: 1px solid #a2ff00;
        }
        
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
        
        .search-box {
            position: relative;
            max-width: 400px;
        }
        
        .search-box input {
            padding-left: 40px;
            background: rgba(30, 30, 48, 0.7);
            border: 1px solid rgba(138, 99, 255, 0.3);
            color: var(--light-1);
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: var(--primary);
        }
        
        .action-btn {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 3px;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
        }
        
        .pagination .page-item .page-link {
            background: rgba(30, 30, 48, 0.7);
            border: 1px solid rgba(138, 99, 255, 0.3);
            color: var(--light-1);
        }
        
        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }
    </style>
</head>
<body>
    <!-- Loading Animation -->
    <div class="loading-overlay" id="loadingOverlay">
        <lottie-player src="https://assets2.lottiefiles.com/packages/lf20_usmfx6bp.json" 
            background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay>
        </lottie-player>
        <h3 class="mt-4 text-white">Loading User Data</h3>
    </div>
    
    <div class="container py-5">
        <!-- Page Header -->
        <div class="page-header glass-card p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="fw-bold text-white mb-2">
                        <i class="fas fa-users me-3"></i>
                        User Management
                    </h1>
                    <p class="text-muted">View and manage all registered users</p>
                </div>
              <div class="col-md-4 text-end d-flex flex-column align-items-end">
    <a href="Homepage.php" class="btn btn-primary mb-3">
        <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
    </a>
    <lottie-player src="https://lottie.host/845ad241-7c36-40be-b9e7-835566a4b436/VjJpeWb2fw.json" 
        background="transparent" speed="1" style="width: 250px; height: 250px;" loop autoplay>
    </lottie-player>
</div>

            </div>
        </div>
        
        <!-- User Search and Filter -->
        <div class="glass-card p-4 mb-4 animate__animated animate__fadeIn">
            <div class="row">
                <div class="col-md-6">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Search users...">
                    </div>
                </div>
               
            </div>
        </div>
        
        <!-- Users Table Card -->
        <div class="glass-card p-4 animate__animated animate__fadeIn">
            <?php
            $i=0;
            $selQry="select * from tbl_user u inner join tbl_place p on u.place_id=p.place_id inner join tbl_district d on p.district_id=d.district_id"; 
            $result=$Con->query($selQry);
            
            if($result->num_rows == 0): ?>
                <div class="text-center py-5">
                    <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_kcsr6fcp.json" 
                        background="transparent" speed="1" 
                        style="width: 300px; height: 300px; margin: 0 auto;" 
                        loop autoplay>
                    </lottie-player>
                    <h4 class="mt-3 text-white">No users found</h4>
                    <p class="text-muted">There are currently no registered users</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="bg-dark">
                                <th width="5%">#</th>
                                <th width="10%">Photo</th>
                                <th width="15%">Name</th>
                                <th width="15%">Email</th>
                                <th width="10%">Contact</th>
                                <th width="15%">Location</th>
                                <th width="10%">DOB</th>
                                <th width="10%">Gender</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row=$result->fetch_assoc()): $i++; ?>
                            <tr>
                                <td><?php echo $i?></td>
                                <td>
                                    <img src="../Assets/Files/User/Photo/<?php echo $row["user_photo"];?>" 
                                         class="user-avatar" 
                                         alt="<?php echo $row["user_name"];?>"
                                         data-bs-toggle="tooltip" 
                                         data-bs-placement="top" 
                                         title="View profile">
                                </td>
                                <td>
                                    <strong><?php echo $row["user_name"];?></strong>
                                    <div class="text-muted small">ID: <?php echo $row["user_id"]; ?></div>
                                </td>
                                <td><?php echo $row["user_email"];?></td>
                                <td><?php echo $row["user_contact"];?></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span><?php echo $row["place_name"];?></span>
                                        <small class="text-muted"><?php echo $row["district_name"];?></small>
                                    </div>
                                </td>
                                <td><?php echo date("M d, Y", strtotime($row["user_dob"])); ?></td>
                                <td>
                                    <?php 
                                    $genderClass = strtolower($row["user_gender"]) == 'male' ? 'male' : 
                                                 (strtolower($row["user_gender"]) == 'female' ? 'female' : 'other');
                                    ?>
                                    <span class="gender-badge <?php echo $genderClass; ?>">
                                        <?php echo $row["user_gender"];?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <button class="action-btn btn-primary" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn btn-primary" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn btn-danger" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Delete User"
                                                onclick="confirmDelete(<?php echo $row['user_id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- User Profile Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content glass-card border-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white" id="userModalLabel">
                        <i class="fas fa-user-circle me-2"></i>User Profile
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="" id="modalUserPhoto" class="img-fluid rounded-circle mb-3" width="150" height="150">
                            <h4 id="modalUserName" class="text-white"></h4>
                            <div id="modalUserGender" class="gender-badge male mb-3"></div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-danger me-2">
                                    <i class="fas fa-ban me-1"></i> Ban
                                </button>
                                <button class="btn btn-primary">
                                    <i class="fas fa-envelope me-1"></i> Message
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Email</label>
                                    <div class="text-white" id="modalUserEmail"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Contact</label>
                                    <div class="text-white" id="modalUserContact"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Date of Birth</label>
                                    <div class="text-white" id="modalUserDob"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted">Location</label>
                                    <div class="text-white" id="modalUserLocation"></div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="text-muted">Address</label>
                                    <div class="text-white" id="modalUserAddress"></div>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted">Account Created</label>
                                    <div class="text-white" id="modalUserCreated"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
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
        
        // Initialize modal
        var userModal = new bootstrap.Modal(document.getElementById('userModal'));
        
        // Function to view user details
        function viewUserDetails(userId) {
            // In a real application, you would fetch user details via AJAX
            // For demo, we'll just show the modal
            userModal.show();
        }
        
        // Delete confirmation
        function confirmDelete(userId) {
            Swal.fire({
                title: 'Delete User?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#8a63ff',
                cancelButtonColor: '#ff4d6d',
                confirmButtonText: 'Yes, delete it!',
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
                    // AJAX call to delete user
                    fetch('delete_user.php?id=' + userId)
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'User Deleted',
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
    </script>
</body>
</html>