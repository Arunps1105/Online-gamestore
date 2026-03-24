<?php
include("../Assets/Connection/Connection.php");

if(isset($_POST["btn_submit"])) {
    $file = $_FILES["file_photo"]["name"];
    $path = $_FILES["file_photo"]["tmp_name"];
    move_uploaded_file($path,'../Assets/Files/Developer/Game/'.$file);

    $insQry="insert into tbl_gallery(gallery_file,game_id)value('".$file."','".$_GET['gid']."')";
    if($Con->query($insQry)) {
        echo'<script>alert("Image uploaded successfully"); window.location="Gallery.php?gid='.$_GET['gid'].'";</script>';
    }
}

if(isset($_GET['delId'])) {
    $delQry = "delete from tbl_gallery where gallery_id='".$_GET['delId']."'";
    if($Con->query($delQry)) {
        echo '<script>alert("Image deleted"); window.location="Gallery.php?gid='.$_GET['gid'].'";</script>';
    }
}

// Get game details for header
$gameQry = "SELECT * FROM tbl_game WHERE game_id='".$_GET['gid']."'";
$gameResult = $Con->query($gameQry);
$gameData = $gameResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $gameData['game_name']; ?> Gallery | GameVault</title>
    
    <!-- Bootstrap Dark CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-nightshade.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;500;600;700&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #6c5ce7;
            --primary-dark: #5649c0;
            --secondary: #00cec9;
            --accent: #fd79a8;
            --dark: #0f0e17;
            --darker: #0a0a12;
            --light: #f8f9fa;
            --gray: #2d3436;
            --light-gray: #636e72;
        }
        
        body {
            background-color: var(--darker);
            color: var(--light);
            font-family: 'Rajdhani', sans-serif;
        }
        
        .title-font {
            font-family: 'Oxanium', cursive;
            letter-spacing: 1px;
        }
        
        .gallery-header {
            background: linear-gradient(rgba(10, 10, 18, 0.9), rgba(10, 10, 18, 0.9)), url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            padding: 80px 0 40px;
            margin-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .upload-card {
            background: linear-gradient(145deg, #16151f, #1a1926);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .upload-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .upload-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .gallery-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(108, 92, 231, 0.2);
            border-color: rgba(108, 92, 231, 0.3);
        }
        
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        
        .gallery-item .actions {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(15, 14, 23, 0.9);
            padding: 10px;
            display: flex;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .gallery-item:hover .actions {
            opacity: 1;
        }
        
        .delete-btn {
            background: rgba(253, 121, 168, 0.2);
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 5px 15px;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .delete-btn:hover {
            background: var(--accent);
            color: white;
        }
        
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
        
        .file-label {
            display: block;
            padding: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px dashed rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .file-label:hover {
            border-color: var(--primary);
            background: rgba(108, 92, 231, 0.1);
        }
        
        .file-label i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 10px;
        }
        
        .back-btn {
            color: var(--secondary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .back-btn:hover {
            color: var(--light);
        }
    </style>
</head>
<body>
    <!-- Gallery Header -->
    <div class="gallery-header">
        <div class="container">
            <a href="Viewgamedetails.php?gid=<?php echo $_GET['gid']; ?>" class="back-btn">
                <i class="fas fa-arrow-left me-2"></i> Back to Game
            </a>
            <h1 class="title-font text-white"><?php echo $gameData['game_name']; ?> Gallery</h1>
            <p class="lead">Upload and manage screenshots for your game</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-4">
        <!-- Upload Form -->
        <div class="upload-card">
            <h3 class="title-font mb-4"><i class="fas fa-cloud-upload-alt me-2"></i> Upload New Image</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-4">
                    <div class="custom-file-input">
                        <label class="file-label">
                            <i class="fas fa-images"></i>
                            <div>Drag & drop your image here or click to browse</div>
                            <small class="text-muted">Supports JPG, PNG (Max 5MB)</small>
                            <input type="file" name="file_photo" id="file_photo" class="d-none" required>
                        </label>
                    </div>
                </div>
                <button type="submit" name="btn_submit" class="upload-btn">
                    <i class="fas fa-upload me-2"></i> Upload Image
                </button>
            </form>
        </div>

        <!-- Gallery Grid -->
        <h3 class="title-font mb-4"><i class="fas fa-images me-2"></i> Gallery Images</h3>
        <?php
        $selQry = "SELECT * FROM tbl_gallery WHERE game_id='".$_GET['gid']."'";
        $row = $Con->query($selQry);
        
        if($row->num_rows > 0) {
            echo '<div class="gallery-grid">';
            $i = 0;
            while($data = $row->fetch_assoc()) {
                $i++;
                echo '
                <div class="gallery-item">
                    <a href="../Assets/Files/Developer/Game/'.$data['gallery_file'].'" data-lightbox="gallery" data-title="Screenshot #'.$i.'">
                        <img src="../Assets/Files/Developer/Game/'.$data['gallery_file'].'" alt="Game Screenshot">
                    </a>
                    <div class="actions">
                        <a href="Gallery.php?delId='.$data['gallery_id'].'&gid='.$_GET['gid'].'" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this image?\')">
                            <i class="fas fa-trash me-2"></i> Delete
                        </a>
                    </div>
                </div>';
            }
            echo '</div>';
        } else {
            echo '<div class="alert alert-dark text-center py-4">
                <i class="fas fa-image fa-3x mb-3 text-muted"></i>
                <h4>No images uploaded yet</h4>
                <p class="text-muted">Upload your first screenshot using the form above</p>
            </div>';
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Lightbox JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // File input preview
        // document.getElementById('file_photo').addEventListener('change', function(e) {
        //     const fileLabel = document.querySelector('.file-label');
        //     if(this.files.length > 0) {
        //         fileLabel.innerHTML = `
        //             <i class="fas fa-check-circle text-success"></i>
        //             <div>${this.files[0].name}</div>
        //             <small class="text-muted">Ready to upload</small>
        //         `;
        //     }
        // });
        
        // Lightbox configuration
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'showImageNumberLabel': true,
            'positionFromTop': 100
        });
    </script>
</body>
</html>