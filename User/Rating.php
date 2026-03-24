<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Game Rating System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap Dark CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Popper & Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
            background: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center fixed;
            background-size: cover;
            color: var(--light);
            min-height: 100vh;
            position: relative;
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
        
        .rating-box {
            background: rgba(30, 30, 36, 0.6);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .average-rating {
            font-size: 4rem;
            font-weight: 700;
            color: var(--neon);
            text-shadow: 0 0 15px rgba(0, 255, 252, 0.5);
            line-height: 1;
        }
        
        .total-reviews {
            color: var(--secondary);
            font-size: 1.2rem;
        }
        
        .progress-container {
            margin-bottom: 1.5rem;
        }
        
        .progress-label-left {
            float: left;
            margin-right: 0.5em;
            line-height: 1em;
            color: var(--light);
            font-weight: 600;
        }
        
        .progress-label-right {
            float: right;
            margin-left: 0.3em;
            line-height: 1em;
            color: var(--secondary);
        }
        
        .progress {
            height: 8px;
            background-color: rgba(15, 15, 18, 0.8);
            border-radius: 4px;
            margin-top: 8px;
            clear: both;
        }
        
        .progress-bar {
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 4px;
        }
        
        .star-light {
            color: rgba(233, 236, 239, 0.2);
        }
        
        .star-filled {
            color: var(--neon);
            text-shadow: 0 0 10px rgba(0, 255, 252, 0.7);
        }
        
        .btn-primary {
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
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.6);
        }

        /* New Dashboard Button Style */
        .btn-dashboard {
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
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
            margin-right: 15px;
        }

        .btn-dashboard:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.6);
            color: white;
        }
        
        .review-card {
            background: rgba(30, 30, 36, 0.6);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 3px solid var(--primary);
            transition: all 0.3s ease;
        }
        
        .review-card:hover {
            transform: translateX(5px);
            border-left-color: var(--neon);
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .user-name {
            font-weight: 600;
            color: var(--neon);
        }
        
        .review-date {
            color: var(--secondary);
            font-size: 0.9rem;
        }
        
        .review-text {
            margin-top: 10px;
            color: var(--light);
            line-height: 1.6;
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
        
        /* Header button container */
        .header-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
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

            .header-buttons {
                position: static;
                justify-content: center;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
      <div class="portal-container">
        <!-- Fixed Dashboard Button - Now properly placed and styled -->
        <div class="text-right mb-4">
            <a href="Homepage.php" class="btn btn-primary">
                <i class="fas fa-tachometer-alt mr-2"></i> Go to Dashboard
            </a>
        </div>


        <div class="portal-header">
            <h1 class="portal-title">Game Ratings</h1>
            <p class="portal-subtitle">Share your experience and see what others think</p>
        </div>
        
        <!-- Floating decorative elements -->
        <img src="https://cdn-icons-png.flaticon.com/512/686/686589.png" class="floating-icons icon-1" alt="Game icon">
        <img src="https://cdn-icons-png.flaticon.com/512/686/686589.png" class="floating-icons icon-2" alt="Game icon">
        <img src="https://cdn-icons-png.flaticon.com/512/686/686589.png" class="floating-icons icon-3" alt="Game icon">
        <img src="https://cdn-icons-png.flaticon.com/512/686/686589.png" class="floating-icons icon-4" alt="Game icon">
        
        <div class="game-card">
            <h3 class="card-title"><i class="fas fa-star"></i> Game Rating</h3>
            <div class="rating-box">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="average-rating mb-2">
                            <span id="average_rating">0.0</span><small>/5</small>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-star fa-2x star-light mr-1 main_star"></i>
                            <i class="fas fa-star fa-2x star-light mr-1 main_star"></i>
                            <i class="fas fa-star fa-2x star-light mr-1 main_star"></i>
                            <i class="fas fa-star fa-2x star-light mr-1 main_star"></i>
                            <i class="fas fa-star fa-2x star-light mr-1 main_star"></i>
                        </div>
                        <h4 class="total-reviews"><span id="total_review">0</span> Reviews</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="progress-container">
                            <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" id="five_star_progress"></div>
                            </div>
                        </div>
                        <div class="progress-container">
                            <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" id="four_star_progress"></div>
                            </div>
                        </div>
                        <div class="progress-container">
                            <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" id="three_star_progress"></div>
                            </div>
                        </div>
                        <div class="progress-container">
                            <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" id="two_star_progress"></div>
                            </div>
                        </div>
                        <div class="progress-container">
                            <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" id="one_star_progress"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <h3 class="mb-4">Share Your Experience</h3>
                        <button type="button" name="add_review" id="add_review" class="btn btn-primary">
                            <i class="fas fa-pen-alt mr-2"></i> Write a Review
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="mt-5" id="review_content">
                <div class="text-center py-5">
                    <i class="fas fa-comment-slash fa-4x mb-3" style="color: var(--secondary);"></i>
                    <h4 style="color: var(--secondary);">No reviews yet. Be the first to review!</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="review_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background: rgba(30, 30, 36, 0.95); border: 1px solid var(--primary);">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" style="color: var(--neon);">Submit Your Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: var(--light);">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center my-4">
                        <i class="fas fa-star fa-2x star-light submit_star mr-2" id="submit_star_1" data-rating="1"></i>
                        <i class="fas fa-star fa-2x star-light submit_star mr-2" id="submit_star_2" data-rating="2"></i>
                        <i class="fas fa-star fa-2x star-light submit_star mr-2" id="submit_star_3" data-rating="3"></i>
                        <i class="fas fa-star fa-2x star-light submit_star mr-2" id="submit_star_4" data-rating="4"></i>
                        <i class="fas fa-star fa-2x star-light submit_star mr-2" id="submit_star_5" data-rating="5"></i>
                    </h4>
                    <div class="form-group">
                        <input type="hidden" name="txt_pid" id="txt_pid" value="<?php echo $_GET["game_id"];?>" />
                    </div>
                    <div class="form-group">
                        <textarea name="user_review" id="user_review" class="form-control" placeholder="Tell us about your experience with this game..." style="background: rgba(15, 15, 18, 0.8); border: 1px solid var(--primary); color: var(--light); min-height: 150px;"></textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="button" class="btn btn-primary" id="save_review" style="width: 200px;">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Review
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function(){
        var rating_data = 0;

        $('#add_review').click(function(){
            $('#review_modal').modal('show');
        });

        $(document).on('mouseenter', '.submit_star', function(){
            var rating = $(this).data('rating');
            reset_background();
            for(var count = 1; count <= rating; count++) {
                $('#submit_star_'+count).addClass('star-filled');
                $('#submit_star_'+count).removeClass('star-light');
            }
        });

        function reset_background() {
            for(var count = 1; count <= 5; count++) {
                $('#submit_star_'+count).addClass('star-light');
                $('#submit_star_'+count).removeClass('star-filled');
            }
        }

        $(document).on('mouseleave', '.submit_star', function(){
            reset_background();
            for(var count = 1; count <= rating_data; count++) {
                $('#submit_star_'+count).removeClass('star-light');
                $('#submit_star_'+count).addClass('star-filled');
            }
        });

        $(document).on('click', '.submit_star', function(){
            rating_data = $(this).data('rating');
        });

        $('#save_review').click(function(){
            var user_review = $('#user_review').val();
            var game_id = $('#txt_pid').val();

            if(rating_data == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Rating Required',
                    text: 'Please select a star rating',
                    confirmButtonColor: 'var(--primary)'
                });
                return false;
            }
            else if(user_review == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Review Required',
                    text: 'Please type your review',
                    confirmButtonColor: 'var(--primary)'
                });
                return false;
            }
            else {
                $.ajax({
                    url:"../Assets/AjaxPages/AjaxRating.php",
                    method:"POST",
                    data:{
                        rating_data: rating_data,
                        user_review: user_review,
                        game_id: game_id
                    },
                    success:function(data) {
                        $('#review_modal').modal('hide');
                        load_rating_data();
                        Swal.fire({
                            icon: 'success',
                            title: 'Thank You!',
                            text: 'Your review has been submitted',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again.',
                            confirmButtonColor: 'var(--primary)'
                        });
                    }
                });
            }
        });

        load_rating_data();

        function load_rating_data() {
            var game_id = $('#txt_pid').val();
            
            $.ajax({
                url:"../Assets/AjaxPages/AjaxRating.php",
                method:"POST",
                data:{action:'load_data',game_id:game_id},
                dataType:"JSON",
                success:function(data) {
                    $('#average_rating').text(data.average_rating);
                    $('#total_review').text(data.total_review);

                    var count_star = 0;
                    $('.main_star').each(function(){
                        count_star++;
                        if(Math.ceil(data.average_rating) >= count_star) {
                            $(this).addClass('star-filled');
                            $(this).removeClass('star-light');
                        }
                    });

                    $('#total_five_star_review').text(data.five_star_review);
                    $('#total_four_star_review').text(data.four_star_review);
                    $('#total_three_star_review').text(data.three_star_review);
                    $('#total_two_star_review').text(data.two_star_review);
                    $('#total_one_star_review').text(data.one_star_review);

                    $('#five_star_progress').css('width', (data.five_star_review/data.total_review) * 100 + '%');
                    $('#four_star_progress').css('width', (data.four_star_review/data.total_review) * 100 + '%');
                    $('#three_star_progress').css('width', (data.three_star_review/data.total_review) * 100 + '%');
                    $('#two_star_progress').css('width', (data.two_star_review/data.total_review) * 100 + '%');
                    $('#one_star_progress').css('width', (data.one_star_review/data.total_review) * 100 + '%');

                    if(data.review_data.length > 0) {
                        var html = '';
                        for(var count = 0; count < data.review_data.length; count++) {
                            html += '<div class="review-card">';
                            html += '<div class="row">';
                            html += '<div class="col-md-2">';
                            html += '<div class="user-avatar">'+data.review_data[count].user_name.charAt(0)+'</div>';
                            html += '</div>';
                            html += '<div class="col-md-10">';
                            html += '<div class="d-flex justify-content-between align-items-center">';
                            html += '<h5 class="user-name">'+data.review_data[count].user_name+'</h5>';
                            html += '<small class="review-date">'+data.review_data[count].datetime+'</small>';
                            html += '</div>';
                            
                            // Star rating
                            html += '<div class="mb-2">';
                            for(var star = 1; star <= 5; star++) {
                                var class_name = '';
                                if(data.review_data[count].rating >= star) {
                                    class_name = 'star-filled';
                                } else {
                                    class_name = 'star-light';
                                }
                                html += '<i class="fas fa-star '+class_name+' mr-1"></i>';
                            }
                            html += '</div>';
                            
                            html += '<div class="review-text">'+data.review_data[count].user_review+'</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                        }
                        $('#review_content').html(html);
                    }
                }
            });
        }
    });
    </script>
</body>
</html>