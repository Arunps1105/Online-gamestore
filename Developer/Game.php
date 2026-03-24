<?php
include("../Assets/Connection/Connection.php");
session_start();

// Initialize variables
$gname = "";
$gid = "";
$gdescription = "";
$gphoto = "";
$gfile = "";
$ggenre = "";
$gcategory = "";
$gsubcategory = "";

// Handle edit data retrieval
if(isset($_GET['editId'])) {
    $editId = $_GET['editId'];
    $editQry = "SELECT * FROM tbl_game WHERE game_id='".$Con->real_escape_string($editId)."' AND developer_id='".$_SESSION['did']."'";
    $result = $Con->query($editQry);
    
    if($result && $result->num_rows > 0) {
        $editdata = $result->fetch_assoc();
        $gname = $editdata['game_name'];
        $gid = $editdata['game_id'];
        $gdescription = $editdata['game_description'];
        $gphoto = $editdata['game_photo'];
        $gfile = $editdata['game_file'];
        $ggenre = $editdata['genre_id'];
        
        // Get category and subcategory info
        $catQry = "SELECT c.category_id FROM tbl_subcategory s 
                  INNER JOIN tbl_category c ON s.category_id = c.category_id 
                  WHERE s.subcategory_id = '".$editdata['subcategory_id']."'";
        $catResult = $Con->query($catQry);
        if($catResult && $catResult->num_rows > 0) {
            $catData = $catResult->fetch_assoc();
            $gcategory = $catData['category_id'];
            $gsubcategory = $editdata['subcategory_id'];
        }
    }
}

// Handle form submission
if(isset($_POST["btn_Submit"])) {
    $name = $_POST["txt_name"];
    $description = $_POST["txt_description"];
    $genre = $_POST["sel_genre"];
    $category = $_POST["sel_category"];
    $subcategory = $_POST["sel_subcategory"];
    $game_id = isset($_POST["hid_id"]) ? $_POST["hid_id"] : "";
    
    if(!empty($game_id)) {
        // Update existing game
        $updateQry = "UPDATE tbl_game SET 
                     game_name='".$Con->real_escape_string($name)."',
                     game_description='".$Con->real_escape_string($description)."',
                     genre_id='".$Con->real_escape_string($genre)."',
                     subcategory_id='".$Con->real_escape_string($subcategory)."'";
        
        // Handle photo update if new photo was uploaded
        if(!empty($_FILES["file_photo"]["name"])) {
            $photo = $_FILES["file_photo"]["name"];
            $path = $_FILES["file_photo"]["tmp_name"];
            move_uploaded_file($path,'../Assets/Files/Developer/'.$photo);
            $updateQry .= ", game_photo='".$photo."'";
        }
        
        // Handle game file update if new file was uploaded
        if(!empty($_FILES["game_file"]["name"])) {
            $game = $_FILES["game_file"]["name"];
            $path1 = $_FILES["game_file"]["tmp_name"];
            move_uploaded_file($path1,'../Assets/Files/Developer/Game/'.$game);
            $updateQry .= ", game_file='".$game."'";
        }
        
        $updateQry .= " WHERE game_id='".$Con->real_escape_string($game_id)."'";
        
        if($Con->query($updateQry)) {
            echo "<script>alert('Game updated successfully'); window.location='Game.php';</script>";
        } else {
            echo "<script>alert('Failed to update game');</script>";
        }
    } else {
        // Insert new game
        $photo = $_FILES["file_photo"]["name"];
        $path = $_FILES["file_photo"]["tmp_name"];
        move_uploaded_file($path,'../Assets/Files/Developer/'.$photo);
        
        $game = $_FILES["game_file"]["name"];
        $path1 = $_FILES["game_file"]["tmp_name"];
        move_uploaded_file($path1,'../Assets/Files/Developer/Game/'.$game);
        
        $insqry = "INSERT INTO tbl_game(game_name,game_description,genre_id,subcategory_id,game_photo,game_date,developer_id,game_file) 
                  VALUES('".$name."','".$description."','".$genre."','".$subcategory."','".$photo."',curdate(),'".$_SESSION['did']."','".$game."')";
         
        if($Con->query($insqry)) {
            echo "<script>alert('Game added successfully'); window.location='Game.php';</script>";
        } else {
            echo "<script>alert('Failed to add game');</script>";
        }
    }
}

// Handle deletion
if(isset($_GET['delId'])) {
    $delQry = "DELETE FROM tbl_game WHERE game_id='".$Con->real_escape_string($_GET['delId'])."' AND developer_id='".$_SESSION['did']."'";
    if($Con->query($delQry)) {
        echo "<script>alert('Game deleted successfully'); window.location='Game.php';</script>";
    } else {
        echo "<script>alert('Failed to delete game');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Management</title>
    <!-- Bootstrap Dark CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-dark.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Lottie Files -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-color: #6c5ce7;
            --primary-dark: #5649d2;
            --primary-light: #a29bfe;
            --secondary-color: #00cec9;
            --accent-color: #fd79a8;
            --dark-color: #0f0f1a;
            --darker-color: #0a0a12;
            --darkest-color: #050509;
            --light-color: #e0e0e0;
            --text-color: #f5f5ff;
            --text-muted: #b0b0c0;
            --card-bg: #1a1a2e;
            --table-bg: #161627;
            --table-hover: #24243e;
            --neon-glow: 0 0 10px rgba(108, 92, 231, 0.7);
            --neon-glow-hover: 0 0 15px rgba(108, 92, 231, 0.9);
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--dark-color);
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(108, 92, 231, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(0, 206, 201, 0.1) 0%, transparent 20%),
                linear-gradient(to bottom, rgba(15, 15, 26, 0.95), rgba(10, 10, 18, 0.98)),
                url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: var(--text-color);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 1px;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: rgba(10, 10, 18, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: var(--text-color);
            box-shadow: 5px 0 25px rgba(0,0,0,0.5);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            border-right: 1px solid rgba(108, 92, 231, 0.2);
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 25px;
            background: linear-gradient(to right, rgba(108, 92, 231, 0.2), transparent);
            text-align: center;
            border-bottom: 1px solid rgba(108, 92, 231, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(108, 92, 231, 0.1) 0%, transparent 100%);
            z-index: -1;
        }
        
        .sidebar-header h4 {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            color: var(--primary-light);
            text-shadow: 0 0 5px rgba(108, 92, 231, 0.5);
        }
        
        .animation-container {
            max-width: 200px;
            margin: 0 auto;
            filter: drop-shadow(0 0 5px rgba(108, 92, 231, 0.5));
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            margin: 5px 15px;
            border-radius: 6px;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-menu a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(108, 92, 231, 0.2), transparent);
            transition: all 0.6s ease;
        }
        
        .sidebar-menu a:hover {
            background: rgba(108, 92, 231, 0.1);
            color: var(--primary-light);
            transform: translateX(5px);
        }
        
        .sidebar-menu a:hover::before {
            left: 100%;
        }
        
        .sidebar-menu a.active {
            background: linear-gradient(to right, rgba(108, 92, 231, 0.2), transparent);
            border-left: 4px solid var(--primary-color);
            color: var(--primary-light);
            box-shadow: var(--neon-glow);
        }
        
        .sidebar-menu a i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }
        
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            text-align: center;
            border-top: 1px solid rgba(108, 92, 231, 0.1);
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card {
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.4);
            margin-bottom: 30px;
            border: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: var(--card-bg);
            border: 1px solid rgba(108, 92, 231, 0.1);
            overflow: hidden;
            position: relative;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(108, 92, 231, 0.05) 0%, transparent 100%);
            z-index: -1;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.5), var(--neon-glow-hover);
        }
        
        .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding: 15px 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, var(--primary-light), transparent);
        }
        
        .btn-primary {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            font-family: 'Orbitron', sans-serif;
        }
        
        .btn-primary:hover {
            background: linear-gradient(to right, var(--primary-dark), var(--primary-color));
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(108, 92, 231, 0.4), var(--neon-glow);
        }
        
        .btn-primary:active {
            transform: translateY(1px);
        }
        
        .btn-primary::before {
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
        
        @keyframes shine {
            0% { transform: rotate(30deg) translate(-30%, -30%); }
            100% { transform: rotate(30deg) translate(30%, 30%); }
        }
        
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            border: 1px solid rgba(108, 92, 231, 0.1);
        }
        
        .table {
            background-color: var(--table-bg);
            color: var(--text-color);
            margin-bottom: 0;
            font-size: 0.95rem;
        }
        
        .table th {
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
            padding: 15px;
        }
        
        .table td, .table th {
            vertical-align: middle;
            border-top: 1px solid rgba(108, 92, 231, 0.1);
            padding: 12px 15px;
        }
        
        .table-hover tbody tr:hover {
            background-color: var(--table-hover);
            transform: scale(1.01);
            box-shadow: 0 0 15px rgba(108, 92, 231, 0.1);
        }
        
        .action-btns a {
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        
        .action-btns a:hover {
            transform: scale(1.1);
            filter: drop-shadow(0 0 5px rgba(108, 92, 231, 0.5));
        }
        
        .game-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid rgba(108, 92, 231, 0.2);
            transition: all 0.3s ease;
        }
        
        .game-img:hover {
            transform: scale(1.05);
            box-shadow: var(--neon-glow);
        }
        
        .form-control, .form-select, .form-control:focus, .form-select:focus {
            background-color: var(--darkest-color);
            border: 1px solid rgba(108, 92, 231, 0.2);
            color: var(--text-color);
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 0.25rem rgba(108, 92, 231, 0.25), var(--neon-glow);
            background-color: var(--darker-color);
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .breadcrumb {
            background-color: rgba(26, 26, 46, 0.8);
            border-radius: 8px;
            padding: 12px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border: 1px solid rgba(108, 92, 231, 0.1);
        }
        
        .breadcrumb-item a {
            color: var(--primary-light);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .breadcrumb-item a:hover {
            color: var(--secondary-color);
            text-shadow: 0 0 5px rgba(0, 206, 201, 0.5);
        }
        
        .breadcrumb-item.active {
            color: var(--text-muted);
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            color: var(--primary-light);
            content: "›";
            padding: 0 8px;
        }
        
        .logout-btn {
            background: linear-gradient(135deg, #e84393, #fd79a8);
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(232, 67, 147, 0.3);
            width: calc(100% - 40px);
            margin: 0 20px;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            font-family: 'Orbitron', sans-serif;
        }
        
        .logout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(232, 67, 147, 0.4), 0 0 15px rgba(232, 67, 147, 0.5);
        }
        
        .logout-btn i {
            margin-right: 8px;
        }
        
        .text-muted {
            color: var(--text-muted) !important;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(108, 92, 231, 0.1);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(var(--primary-color), var(--primary-dark));
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-light);
        }
        
        /* Floating particles animation */
        .particle {
            position: absolute;
            background: rgba(108, 92, 231, 0.5);
            border-radius: 50%;
            filter: blur(1px);
            animation: float 15s infinite linear;
            z-index: -1;
        }
        
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); opacity: 1; }
            100% { transform: translateY(-1000px) rotate(720deg); opacity: 0; }
        }
        
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                opacity: 0;
                visibility: hidden;
            }
            
            .sidebar.active {
                transform: translateX(0);
                opacity: 1;
                visibility: visible;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block !important;
            }
        }
        
        @media (min-width: 992px) {
            .sidebar {
                transform: translateX(0) !important;
                opacity: 1 !important;
                visibility: visible !important;
            }
        }
        
        /* Toggle button for mobile */
        .sidebar-toggle {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
            background: var(--primary-color);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: none;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background: var(--primary-dark);
            transform: scale(1.1);
        }
        
        /* Floating action button */
        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            z-index: 100;
            transition: all 0.3s ease;
            font-size: 1.5rem;
            text-decoration: none;
        }
        
        .fab:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.4), var(--neon-glow-hover);
            color: white;
        }
        
        /* Status indicators */
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-active {
            background-color: #00cec9;
            box-shadow: 0 0 8px #00cec9;
        }
        
        .status-inactive {
            background-color: #fd79a8;
            box-shadow: 0 0 8px #fd79a8;
        }
        
        /* Custom file input */
        .custom-file-input {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        
        .custom-file-input input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .custom-file-label {
            display: block;
            padding: 10px 15px;
            background: var(--darker-color);
            border: 1px dashed rgba(108, 92, 231, 0.5);
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .custom-file-input:hover .custom-file-label {
            border-color: var(--primary-light);
            background: rgba(108, 92, 231, 0.1);
        }
        
        /* Pulse animation for notifications */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(108, 92, 231, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(108, 92, 231, 0); }
            100% { box-shadow: 0 0 0 0 rgba(108, 92, 231, 0); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body>
    <!-- Floating particles background -->
    <div id="particles-container"></div>
    
    <!-- Mobile sidebar toggle -->
    <button class="sidebar-toggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>Game Store</h4>
            <div class="animation-container">
                <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_puciaact.json" background="transparent" speed="1" style="width: 100%; height: 100px;" loop autoplay></lottie-player>
            </div>
        </div>
        <div class="sidebar-menu">
            <a href="Homepage.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="Game.php" class="active"><i class="fas fa-gamepad"></i> Games</a>
            <a href="ViewRating.php"><i class="far fa-star"></i> View rating</a>
        </div>
        <div class="sidebar-footer">
            <a href="Logout.php" class="btn logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-md-12">
                    <h2 class="fw-bold text-light"><i class="fas fa-gamepad me-2"></i> Game Management</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="Homepage.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Games</li>
                        </ol>
                    </nav>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo empty($gid) ? 'Add New Game' : 'Edit Game'; ?></h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="hid_id" value="<?php echo $gid; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="txt_name" class="form-label">Game Name</label>
                                            <input type="text" class="form-control" name="txt_name" id="txt_name" value="<?php echo htmlspecialchars($gname); ?>" required>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="txt_description" class="form-label">Description</label>
                                            <textarea class="form-control" name="txt_description" id="txt_description" rows="3" required><?php echo htmlspecialchars($gdescription); ?></textarea>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="file_photo" class="form-label">Game Photo</label>
                                            <div class="custom-file-input">
                                                <input type="file" class="form-control" name="file_photo" id="file_photo" <?php echo empty($gid) ? 'required' : ''; ?>>
                                                <label for="file_photo" class="custom-file-label">
                                                    <i class="fas fa-cloud-upload-alt me-2"></i>
                                                    <?php echo empty($gphoto) ? 'Choose file...' : 'Change file (current: '.$gphoto.')'; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="sel_genre" class="form-label">Genre</label>
                                            <select class="form-select" name="sel_genre" required>
                                                <option value="">Select Genre</option>
                                                <?php
                                                $selQry = "SELECT * FROM tbl_genre";
                                                $row = $Con->query($selQry);
                                                while($data = $row->fetch_assoc()):
                                                ?>
                                                <option value="<?php echo $data['genre_id']; ?>" <?php echo ($ggenre == $data['genre_id']) ? 'selected' : ''; ?>>
                                                    <?php echo $data['genre_name']; ?>
                                                </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="sel_category" class="form-label">Category</label>
                                            <select class="form-select" name="sel_category" id="sel_category" onchange="getSubcategory(this.value)" required> 
                                                <option value="">Select Category</option>
                                                <?php
                                                $selQry = "SELECT * FROM tbl_category";
                                                $row = $Con->query($selQry);
                                                while($data = $row->fetch_assoc()):
                                                ?>
                                                <option value="<?php echo $data['category_id']; ?>" <?php echo ($gcategory == $data['category_id']) ? 'selected' : ''; ?>>
                                                    <?php echo $data['category_name']; ?>
                                                </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="sel_subcategory" class="form-label">Subcategory</label>
                                            <select class="form-select" name="sel_subcategory" id="sel_subcategory" required> 
                                                <option value="">Select Subcategory</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="game_file" class="form-label">Game File</label>
                                            <div class="custom-file-input">
                                                <input type="file" class="form-control" name="game_file" id="game_file" <?php echo empty($gid) ? 'required' : ''; ?>>
                                                <label for="game_file" class="custom-file-label">
                                                    <i class="fas fa-file-archive me-2"></i>
                                                    <?php echo empty($gfile) ? 'Choose game file...' : 'Change file (current: '.$gfile.')'; ?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center mt-4">
                                    <button type="submit" name="btn_Submit" class="btn btn-primary px-5 py-3">
                                        <i class="fas fa-save me-2"></i><?php echo empty($gid) ? 'Add Game' : 'Update Game'; ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Your Games</h5>
                            <span class="badge bg-primary rounded-pill">
                                <?php 
                                $countQry = "SELECT COUNT(*) as total FROM tbl_game WHERE developer_id='".$_SESSION['did']."'";
                                $countResult = $Con->query($countQry);
                                $countData = $countResult->fetch_assoc();
                                echo $countData['total'];
                                ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Photo</th>
                                            <th>Genre</th>
                                            <th>Category</th>
                                            <th>Subcategory</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $selQry = "SELECT * FROM tbl_game g 
                                                  INNER JOIN tbl_subcategory s ON g.subcategory_id=s.subcategory_id
                                                  INNER JOIN tbl_category c ON s.category_id = c.category_id
                                                  INNER JOIN tbl_genre gr ON g.genre_id=gr.genre_id 
                                                  WHERE developer_id='".$_SESSION['did']."'"; 
                                        $row = $Con->query($selQry);
                                        $i = 0;
                                        while($data = $row->fetch_assoc()):
                                            $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo htmlspecialchars($data['game_name']); ?></td>
                                            <td><?php echo substr(htmlspecialchars($data['game_description']), 0, 50) . '...'; ?></td>
                                            <td><img src="../Assets/Files/Developer/<?php echo htmlspecialchars($data['game_photo']); ?>" class="game-img" alt="Game Image"></td>
                                            <td><?php echo htmlspecialchars($data['genre_name']); ?></td>
                                            <td><?php echo htmlspecialchars($data['category_name']); ?></td>
                                            <td><?php echo htmlspecialchars($data['subcategory_name']); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($data['game_date'])); ?></td>
                                            <td class="action-btns">
                                                <a href="Game.php?delId=<?php echo $data['game_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this game?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <a href="Game.php?editId=<?php echo $data['game_id']; ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="Gallery.php?gid=<?php echo $data['game_id']; ?>" class="btn btn-sm btn-info">
                                                    <i class="fas fa-images"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <a href="#top" class="fab">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Assets/JQ/jQuery.js"></script> 
    <script>
        // Initialize subcategory on page load if category is set
        $(document).ready(function() {
            <?php if(!empty($gcategory)): ?>
            getSubcategory('<?php echo $gcategory; ?>');
            <?php endif; ?>
            
            // Toggle sidebar on mobile
            $('.sidebar-toggle').click(function() {
                $('.sidebar').toggleClass('active');
            });
            
            // Create floating particles
            createParticles();
            
            // Update file input labels
            $('input[type="file"]').change(function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html('<i class="fas fa-cloud-upload-alt me-2"></i>' + (fileName || 'Choose file...'));
            });
        });
        
        function getSubcategory(sid) {
            $.ajax({
                url:"../Assets/Ajaxpages/AjaxSubcategory.php?sid="+sid,
                success: function(result){
                    $("#sel_subcategory").html(result);
                    <?php if(!empty($gsubcategory)): ?>
                    $("#sel_subcategory").val('<?php echo $gsubcategory; ?>');
                    <?php endif; ?>
                }
            });
        }
        
        // Create floating particles for background
        function createParticles() {
            const container = document.getElementById('particles-container');
            const particleCount = 30;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size between 2px and 6px
                const size = Math.random() * 4 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;
                
                // Random opacity
                particle.style.opacity = Math.random() * 0.5 + 0.1;
                
                // Random animation duration
                const duration = Math.random() * 20 + 10;
                particle.style.animationDuration = `${duration}s`;
                
                // Random delay
                particle.style.animationDelay = `${Math.random() * 10}s`;
                
                container.appendChild(particle);
            }
        }
    </script>
</body>
</html>