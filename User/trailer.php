<?php
include("../Assets/Connection/Connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyber Legends - Official Trailer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Lottie Files -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <style>
        :root {
            --cyber-primary: #00f0ff;
            --cyber-secondary: #ff00f0;
            --cyber-dark: #0a0a1a;
            --cyber-darker: #050510;
        }
        
        body {
            background: linear-gradient(135deg, var(--cyber-darker), var(--cyber-dark));
            color: #fff;
            font-family: 'Orbitron', sans-serif;
            overflow-x: hidden;
        }
        
        .text-primary {
            color: var(--cyber-primary) !important;
            text-shadow: 0 0 10px rgba(0, 240, 255, 0.5);
        }
        
        .trailer-info {
            background: rgba(10, 10, 26, 0.8);
            border: 1px solid var(--cyber-primary);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 20px rgba(0, 240, 255, 0.3);
        }
        
        .btn-primary {
            background-color: var(--cyber-primary);
            border-color: var(--cyber-primary);
            color: #000;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: transparent;
            color: var(--cyber-primary);
            box-shadow: 0 0 15px var(--cyber-primary);
        }
        
        .btn-outline-light {
            border-color: var(--cyber-secondary);
            color: var(--cyber-secondary);
            transition: all 0.3s ease;
        }
        
        .btn-outline-light:hover {
            background-color: var(--cyber-secondary);
            color: #000;
            box-shadow: 0 0 15px var(--cyber-secondary);
        }
        
        .video-container {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0, 240, 255, 0.5);
            margin-bottom: 2rem;
            border: 2px solid var(--cyber-primary);
        }
        
        .video-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                transparent,
                rgba(0, 240, 255, 0.1),
                transparent
            );
            transform: rotate(45deg);
            animation: shine 6s infinite;
            z-index: 1;
        }
        
        @keyframes shine {
            0% { left: -50%; }
            100% { left: 150%; }
        }
        
        .feature-list li {
            position: relative;
            padding-left: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .feature-list li::before {
            content: '▹';
            position: absolute;
            left: 0;
            color: var(--cyber-primary);
        }
        
        .cyberpunk-badge {
            position: absolute;
            top: -15px;
            right: 20px;
            background: var(--cyber-secondary);
            color: #000;
            padding: 5px 15px;
            font-weight: bold;
            border-radius: 20px;
            transform: rotate(5deg);
            box-shadow: 0 0 10px var(--cyber-secondary);
            z-index: 2;
        }
        
        h1, h2, h3, h4 {
            font-weight: 700;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <!-- Cyberpunk Glitch Intro Animation -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: -1;">
        <lottie-player 
            src="https://assets1.lottiefiles.com/packages/lf20_5tkzkblw.json" 
            background="transparent" 
            speed="1" 
            style="width: 100%; height: 100%; opacity: 0.1;" 
            loop 
            autoplay>
        </lottie-player>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 position-relative">
                <!-- Cyberpunk Badge -->
                <div class="cyberpunk-badge">OFFICIAL TRAILER</div>
                
                <h1 class="text-center mb-4" style="font-size: 3rem;">CYBER LEGENDS</h1>
                <p class="text-center mb-5" style="letter-spacing: 2px;">- OFFICIAL TRAILER -</p>
                
                <div class="video-container">
                    <div class="ratio ratio-16x9">
                        <iframe 
                            src="https://www.youtube.com/embed/XtoscKyXD0Y?autoplay=1&mute=1" 
                            title="Cyber Legends - Official Game Trailer"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            referrerpolicy="strict-origin-when-cross-origin" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
                
                <div class="trailer-info p-4 mt-5">
                    <h3 class="text-primary mb-4">ABOUT THE GAME</h3>
                    <p class="lead">Cyber Legends is an action-packed RPG set in a dystopian future where megacorporations rule the world. Create your character, choose your faction, and fight for control of Neo-Tokyo.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h4 class="text-primary mb-3">GAME FEATURES</h4>
                            <ul class="feature-list">
                                <li>Open-world cyberpunk environment</li>
                                <li>Character customization with cybernetic enhancements</li>
                                <li>Multiplayer co-op missions</li>
                                <li>Branching storyline with multiple endings</li>
                                <li>Dynamic hacking system</li>
                                <li>Vehicle combat and customization</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h4 class="text-primary mb-3">RELEASE INFORMATION</h4>
                            <div class="release-info">
                                <p><strong class="text-primary">RELEASE DATE:</strong> October 15, 2023</p>
                                <p><strong class="text-primary">PLATFORMS:</strong> PC, PlayStation 5, Xbox Series X</p>
                                <p><strong class="text-primary">DEVELOPER:</strong> Neon Dreams Studio</p>
                                <p><strong class="text-primary">GENRE:</strong> Action RPG</p>
                            </div>
                            
                            <!-- System Requirements -->
                            <h4 class="text-primary mt-4 mb-3">SYSTEM REQUIREMENTS</h4>
                            <div class="d-flex flex-wrap">
                                <div class="me-4 mb-3">
                                    <div class="text-primary fw-bold">MINIMUM</div>
                                    <div class="small">i5 | 8GB RAM | GTX 1060</div>
                                </div>
                                <div class="mb-3">
                                    <div class="text-primary fw-bold">RECOMMENDED</div>
                                    <div class="small">i7 | 16GB RAM | RTX 2060</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                   
                    <a href="Viewgame.php" class="btn btn-outline-light btn-lg px-4 py-3">
                        <i class="fas fa-play-circle me-2"></i>BACK TO GAMESTORE
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
</body>
</html>