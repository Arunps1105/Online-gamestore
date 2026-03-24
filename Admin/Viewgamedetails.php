<?php
session_start();
include("../Assets/Connection/Connection.php");
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameStore:: GameVault</title>
    
    <!-- Bootstrap Dark CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-nightshade.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;500;600;700&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
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
            overflow-x: hidden;
        }
        
        .title-font {
            font-family: 'Oxanium', cursive;
            letter-spacing: 1px;
        }
        
        /* Navbar */
        .navbar {
            background-color: rgba(15, 14, 23, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .navbar-brand {
            font-family: 'Oxanium', cursive;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--light) !important;
        }
        
        .navbar-brand span {
            color: var(--primary);
        }
        
        /* Game Details Section */
        .game-details-section {
            padding: 60px 0;
        }
        
        .game-header {
            margin-bottom: 40px;
        }
        
        .game-cover {
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .game-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--light);
        }
        
        .game-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--light-gray);
        }
        
        .meta-item i {
            color: var(--secondary);
        }
        
        .game-description {
            margin-bottom: 30px;
            line-height: 1.8;
            color: var(--light-gray);
        }
        
        .action-btn {
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            margin-right: 15px;
            margin-bottom: 15px;
        }
        
        
        .download-btn {
            background: var(--primary);
            color: white;
            border: none;
        }
        
        .download-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(108, 92, 231, 0.3);
        }
        
        .rate-btn {
            background: rgba(255, 255, 255, 0.05);
            color: var(--light);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .rate-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }
        
        /* Details Table */
        .details-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 40px;
            background: linear-gradient(145deg, #16151f, #1a1926);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .details-table th {
            background: rgba(108, 92, 231, 0.1);
            padding: 15px;
            text-align: left;
            color: var(--secondary);
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .details-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: var(--light-gray);
        }
        
        .details-table tr:last-child td {
            border-bottom: none;
        }
        
        /* Gallery Section */
        .gallery-section {
            margin-top: 60px;
        }
        
        .gallery-title {
            font-size: 1.8rem;
            margin-bottom: 30px;
            color: var(--light);
            position: relative;
            padding-bottom: 15px;
        }
        
        .gallery-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .gallery-item {
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(108, 92, 231, 0.3);
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .game-title {
                font-size: 2rem;
            }
            
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span>Game</span>Vault
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Browse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Top Charts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">New Releases</a>
                    </li>
                </ul>
               <div class="d-flex">
                    <a href="Homepage.php" class="btn btn-outline-light me-3"><i class="fas fa-user-shield me-2"></i> Dashboard</a>
                    <a href="Logout.php" class="btn btn-danger"><i class="fas fa-sign-in-alt me-2"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Game Details Section -->
    <section class="game-details-section">
        <div class="container">
            <?php
            if (isset($_GET['gid'])) {
                $gid = $_GET['gid'];

                $selQry = "SELECT * FROM tbl_game g 
                    INNER JOIN tbl_subcategory s ON g.subcategory_id = s.subcategory_id
                    INNER JOIN tbl_category c ON s.category_id = c.category_id 
                    INNER JOIN tbl_developer d ON g.developer_id = d.developer_id
                    INNER JOIN tbl_genre gr ON g.genre_id = gr.genre_id 
                    WHERE g.game_id = '$gid'";

                $row = $Con->query($selQry);
                
                if ($row->num_rows > 0) {
                    $data = $row->fetch_assoc();
            ?>
            <div class="game-header">
                <div class="row align-items-center">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <img src="../Assets/Files/Developer/<?php echo $data['game_photo']; ?>" 
                             class="game-cover" alt="<?php echo htmlspecialchars($data['game_name']); ?>">
                    </div>
                    <div class="col-lg-8">
                        <h1 class="game-title title-font"><?php echo htmlspecialchars($data['game_name']); ?></h1>
                        
                        <div class="game-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span><?php echo htmlspecialchars($data['game_date']); ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-gamepad"></i>
                                <span><?php echo htmlspecialchars($data['genre_name']); ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-layer-group"></i>
                                <span><?php echo htmlspecialchars($data['category_name']); ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-code-branch"></i>
                                <span><?php echo htmlspecialchars($data['subcategory_name']); ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span><?php echo htmlspecialchars($data['developer_name']); ?></span>
                            </div>
                        </div>
                        
                        <p class="game-description"><?php echo htmlspecialchars($data['game_description']); ?></p>
                        
                        <div class="game-actions">
                            <a href="Viewgamedetails.php?game=<?php echo $data['game_file']; ?>&gid=<?php echo $data['game_id']; ?>" 
                               download="../Assets/Files/Developer/Game/<?php echo $data['game_file']; ?>"
                               class="action-btn download-btn">
                                <i class="fas fa-download"></i> Download Now
                            </a>
                            <a href="Rating.php?game_id=<?php echo $data['game_id']?>" class="action-btn rate-btn">
                                <i class="fas fa-star"></i> Rate Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="game-info">
                <table class="details-table">
                    <tr>
                        <th>Game Information</th>
                        <th>Details</th>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><?php echo htmlspecialchars($data['game_name']); ?></td>
                    </tr>
                    <tr>
                        <td>Genre</td>
                        <td><?php echo htmlspecialchars($data['genre_name']); ?></td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td><?php echo htmlspecialchars($data['category_name']); ?></td>
                    </tr>
                    <tr>
                        <td>Subcategory</td>
                        <td><?php echo htmlspecialchars($data['subcategory_name']); ?></td>
                    </tr>
                    <tr>
                        <td>Developer</td>
                        <td><?php echo htmlspecialchars($data['developer_name']); ?></td>
                    </tr>
                    <tr>
                        <td>Release Date</td>
                        <td><?php echo htmlspecialchars($data['game_date']); ?></td>
                    </tr>
                </table>
            </div>
            
            <div class="gallery-section">
                <h2 class="gallery-title title-font">Game Gallery</h2>
                <div class="gallery-grid">
                    <?php
                    $selQry = "select * from tbl_gallery where game_id='".$_GET['gid']."'"; 
                    $row = $Con->query($selQry);
                    
                    while($gallery = $row->fetch_assoc()) {
                    ?>
                    <div class="gallery-item">
                        <img src="../Assets/Files/Developer/Game/<?php echo $gallery['gallery_file']?>" 
                             alt="Game screenshot" />
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
                } else {
                    echo '<div class="alert alert-danger">Game not found.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">No game specified.</div>';
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="title-font mb-4"><i class="fas fa-gamepad me-2"></i> GameVault</h5>
                    <p class="text-muted">Your ultimate destination for discovering and downloading amazing games across all platforms.</p>
                    <div class="social-icons mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-discord"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 footer-links">
                    <h5>Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 footer-links">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Safety Center</a></li>
                        <li><a href="#">Community</a></li>
                        <li><a href="#">Feedback</a></li>
                        <li><a href="#">Accessibility</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 footer-links">
                    <h5>Legal</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Copyright</a></li>
                        <li><a href="#">Guidelines</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 footer-links">
                    <h5>Developers</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Developer Portal</a></li>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">API Reference</a></li>
                        <li><a href="#">Publish Your Game</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-5 bg-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small text-muted mb-0">© 2023 GameVault. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-muted small me-3">Privacy Policy</a>
                    <a href="#" class="text-muted small me-3">Terms of Service</a>
                    <a href="#" class="text-muted small">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
</body>
</html>