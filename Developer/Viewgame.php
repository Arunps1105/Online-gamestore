<?php
include("../Assets/Connection/Connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GameVault | Premium Game Store</title>
    
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
        
        .nav-link {
            color: var(--light) !important;
            font-weight: 600;
            margin: 0 10px;
            position: relative;
            letter-spacing: 0.5px;
        }
        
        .nav-link:hover {
            color: var(--primary) !important;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(10, 10, 18, 0.9), rgba(10, 10, 18, 0.9)), url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            padding: 150px 0 100px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://assets.codepen.io/3364143/7b039c3b-8540-44e0-bb05-9a963e2a2f1b.png') no-repeat;
            background-size: cover;
            opacity: 0.03;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            background: linear-gradient(90deg, var(--light), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--light-gray);
            max-width: 600px;
            margin: 0 auto 30px;
        }
        
        .btn-hero {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s;
            letter-spacing: 0.5px;
        }
        
        .btn-hero-primary {
            background: var(--primary);
            color: white;
            border: none;
        }
        
        .btn-hero-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(108, 92, 231, 0.3);
        }
        
        .btn-hero-outline {
            border: 2px solid var(--secondary);
            color: var(--secondary);
        }
        
        .btn-hero-outline:hover {
            background: var(--secondary);
            color: var(--dark);
            transform: translateY(-3px);
        }
        
        /* Game Cards */
        .game-card {
            background: linear-gradient(145deg, #16151f, #1a1926);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
        }
        
        .game-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(108, 92, 231, 0.3);
            border-color: rgba(108, 92, 231, 0.3);
        }
        
        .game-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .game-card:hover::before {
            opacity: 1;
        }
        
        .game-cover {
            height: 200px;
            width: 100%;
            object-fit: cover;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .game-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent);
            color: white;
            font-weight: 700;
            font-size: 0.8rem;
            padding: 4px 12px;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(253, 121, 168, 0.3);
            z-index: 2;
        }
        
        .game-title {
            font-weight: 700;
            color: var(--light);
            margin-bottom: 8px;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
        }
        
        .game-category {
            font-size: 0.8rem;
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        
        .rating-stars {
            color: #ffd700;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        
        .download-badge {
            background: rgba(0, 206, 201, 0.15);
            color: var(--secondary);
            font-size: 0.8rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
        }
        
        .action-btn {
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .view-btn {
            background: var(--primary);
            color: white;
            border: none;
        }
        
        .view-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }
        
        .rate-btn {
            background: rgba(255, 255, 255, 0.05);
            color: var(--light);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .rate-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        /* Featured Section */
        .featured-section {
            background: linear-gradient(135deg, #16151f, #1a1926);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            margin: 40px 0;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .featured-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://assets.codepen.io/3364143/7b039c3b-8540-44e0-bb05-9a963e2a2f1b.png') no-repeat;
            background-size: cover;
            opacity: 0.03;
        }
        
        .featured-badge {
            position: absolute;
            top: 30px;
            left: 30px;
            background: var(--accent);
            color: white;
            font-weight: 700;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            box-shadow: 0 5px 20px rgba(253, 121, 168, 0.3);
            z-index: 2;
        }
        
        /* Categories Section */
        .category-card {
            background: linear-gradient(145deg, #16151f, #1a1926);
            border-radius: 16px;
            padding: 25px 15px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            border: 1px solid rgba(255, 255, 255, 0.05);
            text-align: center;
            height: 100%;
        }
        
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(108, 92, 231, 0.2);
            border-color: rgba(108, 92, 231, 0.3);
        }
        
        .category-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
        }
        
        /* Newsletter Section */
        .newsletter-section {
            background: linear-gradient(135deg, #16151f, #1a1926);
            border-radius: 20px;
            padding: 50px;
            margin: 40px 0;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(135deg, #0f0e17, #0a0a12);
            padding: 60px 0 0;
            margin-top: 80px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .footer-links h5 {
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--light);
            position: relative;
            padding-bottom: 10px;
            letter-spacing: 0.5px;
        }
        
        .footer-links h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 3px;
        }
        
        .footer-links ul li {
            margin-bottom: 10px;
        }
        
        .footer-links ul li a {
            color: var(--light-gray);
            transition: all 0.3s;
            text-decoration: none;
            letter-spacing: 0.5px;
        }
        
        .footer-links ul li a:hover {
            color: var(--secondary);
            padding-left: 5px;
        }
        
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            color: var(--light);
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            background: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
        }
        
        /* Custom Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }
        
        /* Glow Effect */
        .glow {
            text-shadow: 0 0 10px rgba(108, 92, 231, 0.5);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .newsletter-section {
                padding: 30px;
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
                        <a class="nav-link active" href="Viewgame.php">Browse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="HomePage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Viewgame.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="trailer.php">Top Charts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="trailer.php">New Releases</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="Homepage.php" class="btn btn-outline-light me-3"><i class="fas fa-user-shield me-2"></i> Dashboard</a>
                    <a href="Logout.php" class="btn btn-danger"><i class="fas fa-sign-in-alt me-2"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="hero-title title-font mb-4">Unlock Your Next <span class="glow">Gaming Adventure</span></h1>
                    <p class="hero-subtitle">Discover thousands of premium games across all genres. Download instantly and start playing today.</p>
                    
                    <div class="d-flex flex-wrap">
                        <a href="#" class="btn btn-hero btn-hero-primary me-3 mb-3"><i class="fas fa-gamepad me-2"></i> Explore Games</a>
                        <a href="#" class="btn btn-hero btn-hero-outline mb-3"><i class="fas fa-crown me-2"></i> Go Premium</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left">
                    <lottie-player src="https://lottie.host/32106317-d6ff-4245-93f3-c29aa940fcf2/fmrtDHngpf.json" background="transparent" speed="1" style="width: 100%; height: 400px;" loop autoplay class="floating"></lottie-player>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-md-6">
                <h2 class="title-font">Popular Games</h2>
                <p class="text-muted">Most downloaded games this week</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="btn btn-outline-primary">View All <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
        
        <div class="row g-4">
            <?php
            $selQry = "
                SELECT 
                    g.*, 
                    COUNT(d.download_id) AS total_downloads 
                FROM 
                    tbl_game g 
                LEFT JOIN 
                    tbl_download d ON g.game_id = d.game_id 
                GROUP BY 
                    g.game_id
            ";

            $row=$Con->query($selQry);
            $i=0;
            while($data=$row->fetch_assoc())
            {
                $i++;
                // Calculate rating (same as original PHP code)
                $average_rating = 0;
                $total_review = 0;
                $five_star_review = 0;
                $four_star_review = 0;
                $three_star_review = 0;
                $two_star_review = 0;
                $one_star_review = 0;
                $total_user_rating = 0;
                $query = "SELECT * FROM tbl_rating where game_id = '".$data["game_id"]."' ORDER BY rating_id DESC";
                $result = $Con->query($query);
                while($rows = $result->fetch_assoc()) {
                    if($rows["rating_value"] == '5') { $five_star_review++; }
                    if($rows["rating_value"] == '4') { $four_star_review++; }
                    if($rows["rating_value"] == '3') { $three_star_review++; }
                    if($rows["rating_value"] == '2') { $two_star_review++; }
                    if($rows["rating_value"] == '1') { $one_star_review++; }
                    $total_review++;
                    $total_user_rating = $total_user_rating + $rows["rating_value"];
                }
                if($total_review == 0 || $total_user_rating == 0) {
                    $average_rating = 0;
                } else {
                    $average_rating = $total_user_rating / $total_review;
                }
            ?>
            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo ($i % 4) * 100; ?>">
                <div class="game-card h-100">
                    <?php if($i % 3 == 0): ?>
                    <span class="game-badge">TRENDING</span>
                    <?php endif; ?>
                    <img src="../Assets/Files/Developer/<?php echo $data['game_photo']?>" class="game-cover w-100" alt="<?php echo $data['game_name']?>">
                    <div class="p-4">
                        <span class="game-category">Action</span>
                        <h5 class="game-title"><?php echo $data['game_name']?></h5>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="rating-stars">
                                <?php
                                $fullStars = floor($average_rating);
                                $hasHalfStar = ($average_rating - $fullStars) >= 0.5;
                                
                                for ($s = 1; $s <= 5; $s++) {
                                    if ($s <= $fullStars) {
                                        echo '<i class="fas fa-star"></i>';
                                    } elseif ($hasHalfStar && $s == $fullStars + 1) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                                <small class="ms-1 text-muted">(<?php echo $total_review; ?>)</small>
                            </div>
                            <span class="download-badge">
                                <i class="fas fa-download me-1"></i><?php echo $data['total_downloads']?>
                            </span>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex">
                            <a href="Viewgamedetails.php?gid=<?php echo $data['game_id']?>" class="action-btn view-btn me-md-2">
                                <i class="fas fa-info-circle me-1"></i> Details
                            </a>
                            <a href="Rating.php?game_id=<?php echo $data['game_id']?>" class="action-btn rate-btn">
                                <i class="fas fa-star me-1"></i> Rate
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- Featured Section -->
    <div class="container">
        <div class="featured-section p-4 p-lg-5">
            <span class="featured-badge">FEATURED</span>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="title-font mb-4">Game of the Month</h2>
                    <h3 class="text-primary mb-4">Cyber Legends</h3>
                    <p class="text-muted mb-4">Experience the ultimate cyberpunk adventure with stunning visuals and immersive gameplay that will keep you hooked for hours.</p>
                    <div class="d-flex flex-wrap">
                        <div class="me-4 mb-3">
                            <div class="text-primary fw-bold">4.8</div>
                            <div class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                        <div class="me-4 mb-3">
                            <div class="text-primary fw-bold">10M+</div>
                            <div class="text-muted small">Downloads</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-primary fw-bold">1.2GB</div>
                            <div class="text-muted small">Size</div>
                        </div>
                    </div>
                    <div class="d-flex mt-4">
                        <button class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-download me-2"></i> Download Now
                        </button>
                        <button class="btn btn-outline-light btn-lg">
                            <i class="fas fa-play-circle me-2"></i> Watch Trailer
                        </button>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_5tkzkblw.json" background="transparent" speed="1" style="width: 100%; height: 300px;" loop autoplay></lottie-player>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <section class="py-5">
        <div class="container">
     <h2 class="title-font text-center mb-5">Browse by Category</h2>
<div class="row g-4">
    <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="100">
        <div class="category-card">
            <div class="category-icon">
                <lottie-player src=" https://lottie.host/b36e7012-2c39-4f28-b1bf-1a08961b1199/g50pJbrGue.json " background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
            </div>
            <h5 class="mb-0">Action</h5>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="200">
        <div class="category-card">
            <div class="category-icon">
                <lottie-player src="https://lottie.host/662c69da-be36-4d6f-ab90-8f89c8f417be/ZHPXqeUt8U.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
            </div>
            <h5 class="mb-0">Adventure</h5>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="300">
        <div class="category-card">
            <div class="category-icon">
                 <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_2cwDXD.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
            </div>
            <h5 class="mb-0">Puzzle</h5>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="400">
        <div class="category-card">
            <div class="category-icon">
                <lottie-player src="https://lottie.host/265b6c78-c812-420e-b0b8-6f1e189bb742/hFQXbxNpGx.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
            </div>
            <h5 class="mb-0">Racing</h5>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="500">
        <div class="category-card">
            <div class="category-icon">
            <lottie-player src="https://lottie.host/e5a0aa0b-e7d1-4b68-991b-733e05b30150/nDDFFHqxMA.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
            </div>
            <h5 class="mb-0">Sports</h5>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-delay="600">
        <div class="category-card">
            <div class="category-icon">
                <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_puciaact.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
            </div>
            <h5 class="mb-0">Strategy</h5>
        </div>
    </div>
</div>
</div>
</section>

<!-- Newsletter Section -->
<section class="py-5">
<div class="container">
    <div class="newsletter-section">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <h2 class="title-font mb-4">Stay Updated</h2>
                <p class="text-muted mb-4">Subscribe to our newsletter to get the latest game releases, updates, and exclusive offers.</p>
                <div class="input-group">
                    <input type="email" class="form-control bg-dark text-light border-dark" placeholder="Your email address">
                    <button class="btn btn-primary" type="button">Subscribe</button>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <lottie-player src="https://lottie.host/5539fbf7-eb4e-49c7-8bf3-80b70adc5994/8rPljcuEJ0.json" background="transparent" speed="1" style="width: 100%; height: 200px;" loop autoplay></lottie-player>
            </div>
        </div>
    </div>
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
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    </script>
    
    <!-- Custom JS -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    </script>
</body>
</html>