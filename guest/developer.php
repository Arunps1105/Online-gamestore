<?php
include("../Assets/Connection/Connection.php");
if(isset($_POST["btn_Submit"]))
{
    $name=$_POST["txt_name"];
    $email=$_POST["txt_email"];
    $password = $_POST["txt_password"];
    $photo = $_FILES["file_photo"]["name"];
    $Photopath = $_FILES["file_photo"]["tmp_name"];
    $experiance=$_POST["txt_experiance"];
    $description=$_POST["txt_description"];
    move_uploaded_file($Photopath,'../Assets/Files/Developer/Photo/'.$photo);
    $proof = $_FILES["file_proof"]["name"];
    $Proofpath = $_FILES["file_proof"]["tmp_name"];
    move_uploaded_file($Proofpath,'../Assets/Files/Developer/Proof/'.$proof);
    
    $insQry="insert into tbl_developer(developer_name,developer_email,developer_password,developer_photo,developer_proof,developer_experiance,developer_description)value('".$name."','".$email."','".$password."','".$photo."','".$proof."','".$experiance."','".$description."')";
    if($Con->query($insQry))
    {
        ?>
        <script>
        alert("Registration successful!");
        window.location="Login.php";
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
    <title>GameHub - Developer Registration</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Lottie Player -->
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #6c5ce7;
            --secondary: #a29bfe;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --accent: #fd79a8;
            --success: #00b894;
            --danger: #d63031;
        }
        
        body {
            background: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
        }
        
        .registration-container {
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            padding: 2.5rem;
            max-width: 800px;
            width: 100%;
            margin: 2rem auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .lottie-animation {
            width: 100%;
            height: 200px;
            margin-bottom: -30px;
        }
        
        .form-title {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2rem;
        }
        
        .form-subtitle {
            color: var(--secondary);
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .form-label {
            color: var(--secondary);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 8px;
            padding: 12px 15px;
            color: white;
            margin-bottom: 1.2rem;
            width: 100%;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.3);
            border: none;
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .file-upload {
            position: relative;
            overflow: hidden;
            margin-bottom: 1.2rem;
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
        
        .file-upload-label {
            display: block;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: var(--secondary);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px dashed rgba(255, 255, 255, 0.3);
        }
        
        .file-upload-label:hover {
            background: rgba(255, 255, 255, 0.15);
        }
        
        .btn-submit {
            background: linear-gradient(to right, var(--primary), var(--accent));
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            color: white;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .file-preview-container {
            margin-top: 15px;
            text-align: center;
            display: none;
        }
        
        .file-preview {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            border: 2px solid var(--primary);
            object-fit: cover;
        }
        
        .file-info {
            margin-top: 10px;
            color: var(--secondary);
            font-size: 0.9rem;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--secondary);
        }
        
        @media (max-width: 768px) {
            .lottie-animation {
                height: 150px;
                margin-bottom: -20px;
            }
            
            .registration-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="registration-container">
            <!-- Added Lottie Animation -->
            <div class="lottie-animation">
                <lottie-player src="https://lottie.host/58ac75df-a748-4891-b6bf-d905c8e4a439/a9wIucbND5.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay></lottie-player>
            </div>
            
            <h1 class="form-title">Developer Registration</h1>
            <p class="form-subtitle">Join our developer community and showcase your games</p>
            
            <form action="" method="post" enctype="multipart/form-data" id="developerForm">
                <div class="row">
                    <div class="col-md-6">
                        <label for="txt_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="txt_name" name="txt_name" 
                               pattern="^[A-Z][a-zA-Z ]*$" 
                               title="Name must start with capital letter and contain only letters"
                               required>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="txt_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="txt_email" name="txt_email" required>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Profile Photo</label>
                        <div class="file-upload">
                            <input type="file" class="file-upload-input" id="file_photo" name="file_photo" accept="image/*" required>
                            <label for="file_photo" class="file-upload-label">
                                <i class="fas fa-camera me-2"></i> Choose Photo
                            </label>
                        </div>
                        <div class="file-preview-container" id="photoPreview">
                            <img src="" class="file-preview" id="previewPhoto" alt="Photo Preview">
                            <div class="file-info" id="photoInfo"></div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Proof Document</label>
                        <div class="file-upload">
                            <input type="file" class="file-upload-input" id="file_proof" name="file_proof" accept="image/*" required>
                            <label for="file_proof" class="file-upload-label">
                                <i class="fas fa-file-alt me-2"></i> Upload Proof
                            </label>
                        </div>
                        <div class="file-preview-container" id="proofPreview">
                            <img src="" class="file-preview" id="previewProof" alt="Proof Preview">
                            <div class="file-info" id="proofInfo"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <label for="txt_password" class="form-label">Password</label>
                        <div class="position-relative">
                            <input type="password" class="form-control" id="txt_password" name="txt_password" 
                                   minlength="8" required>
                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                        <div class="password-strength mt-2">
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted" id="strengthText">Password strength</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="txt_experiance" class="form-label">Years of Experience</label>
                        <input type="number" class="form-control" id="txt_experiance" name="txt_experiance" 
                               min="0" step="0.1" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="txt_description" class="form-label">Description</label>
                    <textarea class="form-control" id="txt_description" name="txt_description" 
                              placeholder="Tell us about your skills and experience..." required></textarea>
                </div>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="termsCheck" required>
                    <label class="form-check-label" for="termsCheck">
                        I agree to the <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>
                    </label>
                </div>
                
                <button type="submit" name="btn_Submit" class="btn btn-submit">
                    <i class="fas fa-user-plus me-2"></i> Register as Developer
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // File upload preview for profile photo
        document.getElementById('file_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const previewContainer = document.getElementById('photoPreview');
                const previewImage = document.getElementById('previewPhoto');
                const fileInfo = document.getElementById('photoInfo');
                
                previewContainer.style.display = 'block';
                
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
                
                fileInfo.innerHTML = `
                    <strong>${file.name}</strong><br>
                    ${(file.size / 1024).toFixed(2)} KB
                `;
            }
        });
        
        // File upload preview for proof document
        document.getElementById('file_proof').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const previewContainer = document.getElementById('proofPreview');
                const previewImage = document.getElementById('previewProof');
                const fileInfo = document.getElementById('proofInfo');
                
                previewContainer.style.display = 'block';
                
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
                
                fileInfo.innerHTML = `
                    <strong>${file.name}</strong><br>
                    ${(file.size / 1024).toFixed(2)} KB
                `;
            }
        });
        
        // Password strength indicator
        document.getElementById('txt_password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('strengthText');
            
            // Reset
            strengthBar.style.width = '0%';
            strengthBar.className = 'progress-bar';
            
            if (password.length === 0) {
                strengthText.textContent = 'Password strength';
                strengthText.className = 'text-muted';
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
        
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('txt_password');
            const icon = this;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Form validation
        document.getElementById('developerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('txt_password').value;
            const termsChecked = document.getElementById('termsCheck').checked;
            
            if (password.length < 8) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Too Short',
                    text: 'Password must be at least 8 characters long',
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
    </script>
</body>
</html>