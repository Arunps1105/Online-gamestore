<?php
include("../Assets/Connection/Connection.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Management Portal | Developer Dashboard</title>
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
            padding-left: 250px;
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
        
        .game-img {
            border-radius: 12px;
            transition: transform 0.3s ease;
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 2px solid rgba(108, 92, 231, 0.3);
        }
        
        .game-img:hover {
            transform: scale(1.05);
            border-color: var(--accent);
        }
        
        .rating-stars {
            color: #FC3;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }
        
        .btn-view {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border: none;
            color: white;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.4);
        }
        
        .btn-view:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.6);
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
        
        .downloads-badge {
            background: rgba(0, 206, 201, 0.2);
            color: var(--accent);
            border: 1px solid var(--accent);
            border-radius: 50px;
            padding: 5px 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 0;
        }
        
        .empty-state p {
            color: var(--secondary);
            font-size: 1.2rem;
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
        }
        
        @keyframes shine {
            100% {
                transform: rotate(30deg) translate(100%, 100%);
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
                    <a class="nav-link active" href="Mygames.php">
                        <i class="fas fa-gamepad"></i>
                        <span class="nav-text">My Games</span>
                    </a>
                </li>
                  <li class="nav-item">
                <a class="nav-link" href="Homepage.php">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
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
            <h1 class="portal-title">Game Management Dashboard</h1>
            <p class="portal-subtitle">Manage your published games and view performance metrics</p>
        </div>

        <div class="game-card">
            <h3 class="card-title"><i class="fas fa-gamepad"></i> Your Published Games</h3>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Photo</th>
                            <th>Rating</th>
                            <th>Downloads</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $selQry = "
                            SELECT 
                                g.*, 
                                COUNT(d.download_id) AS total_downloads 
                            FROM 
                                tbl_game g 
                            LEFT JOIN 
                                tbl_download d ON g.game_id = d.game_id 
                            WHERE 
                                g.developer_id='".$_SESSION['did']."'
                            GROUP BY 
                                g.game_id
                        ";

                        $row=$Con->query($selQry);
                        $i=0;
                        
                        if($row->num_rows > 0) {
                            while($data=$row->fetch_assoc()) {
                                $i++;
                        ?>
                        <tr>
                            <td><?php echo $i?></td>
                            <td><?php echo htmlspecialchars($data['game_name'])?></td>
                            <td>
                                <img src="../Assets/Files/Developer/<?php echo $data['game_photo']?>" 
                                     class="game-img" 
                                     alt="<?php echo htmlspecialchars($data['game_name'])?>">
                            </td>
                            <td>
                                <?php
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
                                if($total_review > 0) {
                                    $average_rating = $total_user_rating / $total_review;
                                }
                                ?>
                                <div class="rating-stars">
                                    <?php
                                    $full_stars = floor($average_rating);
                                    $half_star = ($average_rating - $full_stars) >= 0.5;
                                    $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
                                    
                                    for($s = 0; $s < $full_stars; $s++) {
                                        echo '<i class="fas fa-star"></i>';
                                    }
                                    if($half_star) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    }
                                    for($s = 0; $s < $empty_stars; $s++) {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                    ?>
                                </div>
                                <small><?php echo number_format($average_rating, 1)?> (<?php echo $total_review?> reviews)</small>
                            </td>
                            <td>
                                <span class="downloads-badge">
                                    <i class="fas fa-download me-1"></i> <?php echo $data['total_downloads']?>
                                </span>
                            </td>
                            <td>
                                <a href="ViewRating.php?game_id=<?php echo $data['game_id']?>" 
                                   class="btn btn-view btn-sm">
                                    <i class="fas fa-star me-1"></i> View Ratings
                                </a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_9wjm4k5r.json" 
                                                  background="transparent" 
                                                  speed="1" 
                                                  style="width: 150px; height: 150px; margin: 0 auto;" 
                                                  loop autoplay></lottie-player>
                                    <p>No games published yet</p>
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
    </script>
</body>
</html>