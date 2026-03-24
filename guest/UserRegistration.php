<?php
include("../Assets/Connection/Connection.php");
if(isset($_POST["btn_Submit"]))
{
    $name=$_POST["txt_name"];
    $email=$_POST["txt_email"];
    $contact=$_POST["txt_contact"];
    $address=$_POST["txt_address"];
    $dob = $_POST["txt_date"];
    $gender=$_POST["rd_gender"];
    $password=$_POST["pwd_pass"];
    $place=$_POST["sel_place"];
    
    $photo = $_FILES["file_photo"]["name"];
    $path = $_FILES["file_photo"]["tmp_name"];
    move_uploaded_file($path,'../Assets/Files/User/Photo/'.$photo);

    $insQry="insert into tbl_user(user_name,user_email,user_address,user_dob,user_gender,user_password,place_id,user_photo,user_contact)value('".$name."','".$email."','".$address."','".$dob."','".$gender."','".$password."','".$place."','".$photo."','".$contact."')";
    if($Con->query($insQry))
    {
        ?>
        <script>
        alert("Registration successful!");
        window.location="UserRegistration.php";
        </script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameHub - Join the Ultimate Gaming Community</title>
    <!-- Bootstrap Dark CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
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
            background: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center fixed;
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
            background: rgba(15, 15, 18, 0.9);
            z-index: -1;
        }
        
        .registration-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }
        
        .registration-card {
            background: rgba(30, 30, 36, 0.9);
            border: 1px solid rgba(106, 90, 205, 0.4);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .registration-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(108, 92, 231, 0.6);
        }
        
        .game-side {
            background: linear-gradient(135deg, rgba(108, 92, 231, 0.8), rgba(162, 155, 254, 0.6));
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        
        .form-side {
            padding: 3rem;
        }
        
        .form-title {
            font-family: 'Rajdhani', sans-serif;
            color: var(--neon);
            font-weight: 700;
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1rem;
            text-shadow: 0 0 15px rgba(0, 255, 252, 0.3);
        }
        
        .form-subtitle {
            color: var(--secondary);
            font-size: 1.1rem;
            margin-bottom: 2rem;
            letter-spacing: 1px;
        }
        
        .form-label {
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-control {
            background-color: rgba(15, 15, 18, 0.8);
            border: 1px solid var(--primary);
            color: var(--light);
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background-color: rgba(15, 15, 18, 0.9);
            color: var(--light);
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(0, 206, 201, 0.25);
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        
        /* Enhanced Select Dropdown */
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23a29bfe'%3e%3cpath d='M7 10l5 5 5-5z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 12px;
        }
        
        /* Gender Radio Buttons */
        .gender-options {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.2rem;
        }
        
        .form-check {
            display: flex;
            align-items: center;
        }
        
        .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            background-color: rgba(15, 15, 18, 0.8);
            border: 1px solid var(--primary);
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .form-check-label {
            color: var(--light);
            font-weight: 500;
        }
        
        /* File Upload Styling */
        .file-upload-container {
            margin-bottom: 1.5rem;
        }
        
        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload-btn {
            display: inline-block;
            padding: 12px 20px;
            background: rgba(108, 92, 231, 0.2);
            color: var(--secondary);
            border: 1px dashed var(--primary);
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
        }
        
        .file-upload-btn:hover {
            background: rgba(108, 92, 231, 0.3);
            border-color: var(--accent);
        }
        
        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-preview-container {
            margin-top: 15px;
            text-align: center;
            display: none;
        }
        
        .file-preview {
            max-width: 150px;
            max-height: 150px;
            border-radius: 10px;
            border: 2px solid var(--primary);
            object-fit: cover;
        }
        
        .file-info {
            margin-top: 10px;
            color: var(--secondary);
            font-size: 0.9rem;
        }
        
        /* Buttons */
        .btn-register {
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
            width: 100%;
            margin-top: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.6);
        }
        
        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }
        
        .btn-register:hover::before {
            left: 100%;
        }
        
        .btn-reset {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--secondary);
            color: var(--light);
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 50px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }
        
        .btn-reset:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: var(--accent);
            color: white;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .game-side {
                display: none;
            }
            
            .form-side {
                padding: 2rem;
            }
            
            .registration-container {
                padding: 1rem;
            }
        }
        
        @media (max-width: 768px) {
            .form-title {
                font-size: 2rem;
            }
            
            .form-subtitle {
                font-size: 1rem;
            }
            
            .gender-options {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
        
        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .floating {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="registration-card">
                    <div class="row g-0">
                        <!-- Game Side with Animation -->
                        <div class="col-lg-5 game-side">
                            <div class="floating">
                                <lottie-player src="https://lottie.host/1c281a76-8018-4020-868e-1b4f8c3191fe/m57qMzRiEi.json" 
                                             background="transparent" 
                                             speed="1" 
                                             style="width: 100%; height: 250px;" 
                                             loop autoplay></lottie-player>
                            </div>
                            <h3 class="text-white mt-4">Join Our Gaming Community</h3>
                            <p class="text-light">Unlock exclusive features and connect with gamers worldwide</p>
                            <div class="mt-4">
                                <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                                    <i class="fas fa-gamepad fa-2x text-white"></i>
                                    <span class="text-light">1000+ Games</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                                    <i class="fas fa-users fa-2x text-white"></i>
                                    <span class="text-light">500,000+ Members</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <i class="fas fa-trophy fa-2x text-white"></i>
                                    <span class="text-light">Daily Tournaments</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Registration Form Side -->
                        <div class="col-lg-7 form-side">
                            <h1 class="form-title">Create Account</h1>
                            <p class="form-subtitle">Start your gaming journey with us today</p>
                            
                            <form id="registrationForm" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="txt_name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="txt_name" name="txt_name" 
                                               placeholder="Enter your Name" required
                                               pattern="^[A-Z]+[a-zA-Z ]*$"
                                               title="Name must start with capital letter and contain only letters">
                                        <small class="text-muted">Must start with capital letter</small>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="txt_email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="txt_email" name="txt_email" 
                                               placeholder="Enter Your Email" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="txt_contact" class="form-label">Contact Number</label>
                                        <input type="tel" class="form-control" id="txt_contact" name="txt_contact" 
                                               placeholder="Enter Your Phone Number" required
                                               pattern="[7-9][0-9]{9}"
                                               title="Phone number with 7-9 and remaining 9 digits with 0-9">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="txt_address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="txt_address" name="txt_address" 
                                               placeholder="Your Address" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="txt_date" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="txt_date" name="txt_date" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Gender</label>
                                        <div class="gender-options">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="rd_gender" id="rd_gender_male" value="male" required>
                                                <label class="form-check-label" for="rd_gender_male">Male</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="rd_gender" id="rd_gender_female" value="female">
                                                <label class="form-check-label" for="rd_gender_female">Female</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="rd_gender" id="rd_gender_other" value="other">
                                                <label class="form-check-label" for="rd_gender_other">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="select" class="form-label">District</label>
                                        <select class="form-control" name="select" id="select" onChange="getPlace(this.value)" required>
                                            <option value="">Select District</option>
                                            <?php
                                            $sel="select * from tbl_district";
                                            $result=$Con->query($sel);
                                            while($row=$result->fetch_assoc())
                                            {
                                            ?>
                                            <option value="<?php echo $row["district_id"]?>">
                                            <?php echo $row["district_name"]?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="sel_place" class="form-label">Place</label>
                                        <select class="form-control" name="sel_place" id="sel_place" required>
                                            <option value="">Select Place</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="file-upload-container">
                                    <label class="form-label">Profile Photo</label>
                                    <div class="file-upload">
                                        <button type="button" class="file-upload-btn">
                                            <i class="fas fa-cloud-upload-alt me-2"></i> Choose Profile Picture
                                        </button>
                                        <input type="file" class="file-upload-input" id="file_photo" name="file_photo" accept="image/*" required>
                                    </div>
                                    <div class="file-preview-container" id="filePreview">
                                        <img src="" class="file-preview" id="previewImage" alt="Preview">
                                        <div class="file-info" id="fileInfo"></div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="pwd_pass" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="pwd_pass" name="pwd_pass" 
                                               placeholder="At least 8 characters" required minlength="8">
                                        <div class="password-strength mt-2">
                                            <div class="progress" style="height: 5px;">
                                                <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                            </div>
                                            <small class="text-muted" id="strengthText">Password strength</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="pwd_retype" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="pwd_retype" name="pwd_retype" 
                                               placeholder="Retype your password" required>
                                        <small class="text-muted" id="passwordMatch"></small>
                                    </div>
                                </div>
                                
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                    <label class="form-check-label" for="termsCheck">
                                        I agree to the <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                    </label>
                                </div>
                                
                                <button type="submit" name="btn_Submit" class="btn btn-register">
                                    <i class="fas fa-user-plus me-2"></i> Create Account
                                </button>
                                
                                <button type="reset" class="btn btn-reset">
                                    <i class="fas fa-undo me-2"></i> Reset Form
                                </button>
                                
                                <div class="text-center mt-4">
                                    <p class="text-light">Already have an account? <a href="Login.php" class="text-primary">Sign In</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Function to get places based on district selection
        function getPlace(did) {
            $.ajax({
                url: "../Assets/Ajaxpages/AjaxPlace.php?did=" + did,
                success: function(result) {
                    $("#sel_place").html(result);
                }
            });
        }
        
        // File upload preview
        document.getElementById('file_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const previewContainer = document.getElementById('filePreview');
                const previewImage = document.getElementById('previewImage');
                const fileInfo = document.getElementById('fileInfo');
                
                // Show preview container
                previewContainer.style.display = 'block';
                
                // Display image preview
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
                
                // Display file info
                fileInfo.innerHTML = `
                    <strong>${file.name}</strong><br>
                    ${(file.size / 1024).toFixed(2)} KB
                `;
            }
        });
        
        // Password strength indicator
        document.getElementById('pwd_pass').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('strengthText');
            
            // Reset
            strengthBar.style.width = '0%';
            strengthBar.classList.remove('bg-danger', 'bg-warning', 'bg-success');
            
            if (password.length === 0) {
                strengthText.textContent = 'Password strength';
                return;
            }
            
            // Calculate strength
            let strength = 0;
            
            // Length
            if (password.length > 8) strength += 1;
            if (password.length > 12) strength += 1;
            
            // Contains numbers
            if (/\d/.test(password)) strength += 1;
            
            // Contains special chars
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 1;
            
            // Contains both lower and upper case
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 1;
            
            // Update UI
            if (strength <= 2) {
                strengthBar.style.width = '33%';
                strengthBar.classList.add('bg-danger');
                strengthText.textContent = 'Weak';
                strengthText.className = 'text-danger';
            } else if (strength <= 4) {
                strengthBar.style.width = '66%';
                strengthBar.classList.add('bg-warning');
                strengthText.textContent = 'Medium';
                strengthText.className = 'text-warning';
            } else {
                strengthBar.style.width = '100%';
                strengthBar.classList.add('bg-success');
                strengthText.textContent = 'Strong';
                strengthText.className = 'text-success';
            }
        });
        
        // Password match verification
        document.getElementById('pwd_retype').addEventListener('input', function() {
            const password = document.getElementById('pwd_pass').value;
            const confirmPassword = this.value;
            const matchText = document.getElementById('passwordMatch');
            
            if (confirmPassword.length === 0) {
                matchText.textContent = '';
                return;
            }
            
            if (password === confirmPassword) {
                matchText.textContent = 'Passwords match';
                matchText.className = 'text-success';
            } else {
                matchText.textContent = 'Passwords do not match';
                matchText.className = 'text-danger';
            }
        });
        
        // Form submission validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const password = document.getElementById('pwd_pass').value;
            const confirmPassword = document.getElementById('pwd_retype').value;
            const termsChecked = document.getElementById('termsCheck').checked;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Please make sure your passwords match',
                    confirmButtonColor: '#6c5ce7'
                });
                return;
            }
            
            if (!termsChecked) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Terms Not Accepted',
                    text: 'You must agree to the Terms of Service and Privacy Policy',
                    confirmButtonColor: '#6c5ce7'
                });
                return;
            }
        });
        
        // Trigger file input when button is clicked
        document.querySelector('.file-upload-btn').addEventListener('click', function() {
            document.getElementById('file_photo').click();
        });
    </script>
</body>
</html>