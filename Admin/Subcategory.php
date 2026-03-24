<?php
include("../Assets/Connection/Connection.php");
session_start();

if(isset($_POST['btn_submit'])) {
    $subcategory = $_POST['txt_subcategory'];
    $category = $_POST['sel_category'];
    $cid = $_POST['txt_hidden'];
    
    if($cid == "") {
        $insQry = "insert into tbl_subcategory(subcategory_name,category_id) values('".$subcategory."','".$category."')";
        if($Con->query($insQry)) {
            echo "<script>alert('Subcategory added successfully'); window.location='Subcategory.php';</script>";
        }
    } else {
        $upQry = "update tbl_subcategory set subcategory_name='".$subcategory."', category_id='".$category."' where subcategory_id='".$cid."'";
        if($Con->query($upQry)) {
            echo "<script>alert('Subcategory updated successfully'); window.location='Subcategory.php';</script>";
        }
    }
}
         
if(isset($_GET['delId'])) {
    $delQry = "delete from tbl_subcategory where subcategory_id='".$_GET['delId']."'";
    if($Con->query($delQry)) {
        echo "<script>alert('Subcategory deleted successfully'); window.location='Subcategory.php';</script>";
    }
}

$cid = "";
$cname = "";
$cat = "";
if(isset($_GET['editId'])) {
    $editQry = "select * from tbl_subcategory where subcategory_id='".$_GET['editId']."'";
    $row = $Con->query($editQry);
    $editdata = $row->fetch_assoc();
    $cname = $editdata['subcategory_name'];
    $cid = $editdata['subcategory_id'];
    $cat = $editdata['category_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameHub::Subcategory Management</title>
    
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
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning), #e6b949);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: #2d3436;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .table {
            color: var(--light-1);
            backdrop-filter: blur(5px);
        }
        
        .table-hover tbody tr:hover {
            background: rgba(138, 99, 255, 0.1);
        }
        
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
        } .logout-btn {
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
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
        }
        
        .action-btn {
            min-width: 80px;
            margin-right: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
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
        <h3 class="mt-4 text-white">Loading Subcategory</h3>
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
                <a class="nav-link" href="Homepage.php">
                    <i class="fas fa-user-shield me-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
           
             
            <li class="nav-item">
                <a class="nav-link" href="Genre.php">
                    <i class="fas fa-tags me-2"></i>
                    <span>Genres</span>
                </a>
            </li>
                <li class="nav-item">
                <a class="nav-link" href="Category.php">
                    <i class="fas fa-layer-group me-2"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="Subcategory.php">
                    <i class="fas fa-tag me-2"></i>
                    <span>Subcategories</span>
                </a>
            </li>
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
                        <i class="fas fa-tags me-3"></i>
                        Subcategory Management
                    </h1>
                    <p class="text-muted">Manage game subcategories for your platform</p>
                </div>
            </div>
            
            <!-- Subcategory Form Card -->
            <div class="glass-card mb-4 animate__animated animate__fadeInUp">
                <div class="card-header bg-primary text-white border-0">
                    <h3 class="mb-0">
                        <i class="fas fa-<?php echo ($cid ? 'sync-alt' : 'plus-circle') ?> me-2"></i>
                        <?php echo ($cid ? 'Update Subcategory' : 'Add New Subcategory') ?>
                    </h3>
                </div>
                <div class="card-body">
                    <form id="form1" name="form1" method="post" action="">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sel_category" class="form-label">Category</label>
                                    <select name="sel_category" id="sel_category" class="form-select" required>
                                        <option value="">-- Select Category --</option>
                                        <?php
                                        $selQury = "select * from tbl_category";
                                        $row = $Con->query($selQury);
                                        while($data = $row->fetch_assoc()) {
                                        ?>
                                        <option <?php if($cat == $data['category_id']) echo "selected"; ?> 
                                            value="<?php echo $data['category_id']?>">
                                            <?php echo $data['category_name']?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txt_subcategory" class="form-label">Subcategory Name</label>
                                    <input type="hidden" name="txt_hidden" id="txt_hidden" value="<?php echo $cid ?>" />
                                    <input type="text" class="form-control form-control-lg" 
                                        name="txt_subcategory" id="txt_subcategory" 
                                        value="<?php echo $cname ?>" 
                                        placeholder="Enter subcategory name" required />
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" name="btn_submit" id="btn_submit" 
                                    class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-<?php echo ($cid ? 'sync-alt' : 'save') ?> me-2"></i>
                                    <?php echo ($cid ? 'Update' : 'Submit') ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Subcategories Table Card -->
            <div class="glass-card animate__animated animate__fadeInUp">
                <div class="card-header bg-primary text-white border-0">
                    <h3 class="mb-0">
                        <i class="fas fa-list-ul me-2"></i>
                        Current Subcategories
                    </h3>
                </div>
                <div class="card-body">
                    <?php 
                    $i = 0;
                    $selQry = "select * from tbl_subcategory s inner join tbl_category c on s.category_id=c.category_id";
                    $row = $Con->query($selQry);
                    $rowCount = $row->num_rows;
                    
                    if($rowCount == 0): ?>
                        <div class="text-center py-5">
                            <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_kcsr6fcp.json" 
                                background="transparent" speed="1" 
                                style="width: 300px; height: 300px; margin: 0 auto;" 
                                loop autoplay>
                            </lottie-player>
                            <h4 class="mt-3 text-white">No subcategories found</h4>
                            <p class="text-muted">Add your first subcategory to get started</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr class="bg-dark">
                                        <th width="5%">#</th>
                                        <th width="25%">Category</th>
                                        <th>Subcategory</th>
                                        <th width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($data = $row->fetch_assoc()): $i++; ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td>
                                            <i class="fas fa-tag text-primary me-2"></i>
                                            <?php echo $data['category_name'] ?>
                                        </td>
                                        <td>
                                            <i class="fas fa-tags text-warning me-2"></i>
                                            <?php echo $data['subcategory_name'] ?>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="Subcategory.php?editId=<?php echo $data['subcategory_id'] ?>" 
                                                   class="btn btn-warning btn-sm me-2">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="Subcategory.php?delId=<?php echo $data['subcategory_id'] ?>" 
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Are you sure you want to delete this subcategory?')">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </a>
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
        
        document.addEventListener('DOMContentLoaded', function() {
            // Animation trigger on scroll
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
            
            // Confirmation for delete actions
            document.querySelectorAll('.btn-danger').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if(!confirm('Are you sure you want to delete this subcategory?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>