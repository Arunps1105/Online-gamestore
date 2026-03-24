<?php
include("../Assets/Connection/Connection.php");
session_start();
$selQry="select * from tbl_developer where developer_id = '".$_SESSION['did']."' ";
$result=$Con->query($selQry);
$developerdata=$result->fetch_assoc();

if(isset($_POST['btn_submit']))
{
    $name=$_POST['txt_name'];
    $email=$_POST['txt_email'];
     
    $upQry="update tbl_developer set developer_name='".$name."',developer_email='".$email."' where developer_id='".$_SESSION['did']."' ";
     if($Con->query($upQry))
{
?>
<script>
    alert("Profile updated successfully!");
    window.location="myprofile.php";
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
    <title>Edit Developer Profile</title>
    <!-- Bootstrap Dark CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-night.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            --glow: 0 0 15px rgba(0, 255, 252, 0.5);
        }
        
        body {
            font-family: 'Oxanium', sans-serif;
            background: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
            background-size: cover;
            color: var(--light);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            position: relative;
            display: flex;
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
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: rgba(20, 20, 25, 0.95);
            border-right: 1px solid rgba(106, 90, 205, 0.3);
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
        }
        
        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(106, 90, 205, 0.3);
        }
        
        .sidebar-title {
            color: var(--neon);
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 1.2rem;
            margin: 0;
        }
        
        .sidebar-menu {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }
        
        .nav-item {
            margin: 5px 0;
        }
        
        .nav-link {
            color: var(--secondary);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .nav-link:hover, .nav-link.active {
            background: rgba(108, 92, 231, 0.2);
            color: var(--light);
            border-left: 3px solid var(--accent);
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
       .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px;
            border-top: 1px solid rgba(108, 92, 231, 0.2);
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
        
        
        
        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 20px;
        }
        
        .dev-edit-container {
            max-width: 500px;
            margin: 2rem auto;
            background: rgba(20, 20, 25, 0.95);
            border-radius: 12px;
            border: 1px solid var(--primary);
            box-shadow: var(--glow),
                        inset 0 0 10px rgba(106, 90, 205, 0.3);
            overflow: hidden;
            position: relative;
        }
        
        .dev-edit-container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary), var(--accent), var(--primary));
            z-index: -1;
            border-radius: 14px;
            animation: borderGlow 6s linear infinite;
            background-size: 300%;
            opacity: 0.5;
        }
        
        @keyframes borderGlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .dev-edit-header {
            padding: 1.5rem;
            background: linear-gradient(90deg, rgba(108, 92, 231, 0.2), rgba(0, 206, 201, 0.2));
            text-align: center;
            border-bottom: 1px solid rgba(106, 90, 205, 0.3);
        }
        
        .dev-edit-title {
            font-family: 'Rajdhani', sans-serif;
            color: var(--neon);
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: var(--glow);
            font-size: 1.5rem;
        }
        
        .dev-edit-body {
            padding: 2rem;
        }
        
        .form-label {
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
        
        .form-control {
            background: rgba(30, 30, 36, 0.7);
            border: 1px solid rgba(106, 90, 205, 0.3);
            color: var(--light);
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background: rgba(40, 40, 48, 0.8);
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(0, 206, 201, 0.25);
            color: var(--light);
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent);
            z-index: 4;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group input {
            padding-left: 45px;
        }
        
        .btn-dev-submit {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: var(--dark);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.5);
        }
        
        .btn-dev-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.7);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">Developer Panel</h3>
        </div>
        
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fas fa-user-edit"></i> Edit Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Homepage.php">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <!-- Add more menu items as needed -->
            </ul>
        </div>
        
     <div class="sidebar-footer">
            <ul class="sidebar-nav">
                <li class="nav-item">
                    <div class="position-absolute bottom-0 start-0 p-3 w-100">
                    <a class="nav-link logout-btn" href="Logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="dev-edit-container">
            <div class="dev-edit-header">
                <h3 style="color:#00fff7; text-shadow:0 0 10px #00fff7, 0 0 20px #00fff7;">
                    <i class="fas fa-user-edit"></i> Update Developer Profile
                </h3>
            </div>
            
            <div class="dev-edit-body">
                <form id="form1" name="form1" method="post" action="">
                    <div class="mb-4">
                        <label for="txt_name" class="form-label">Developer Name</label>
                        <div class="input-group">
                            <i class="fas fa-user-tie input-icon"></i>
                            <input type="text" class="form-control" name="txt_name" id="txt_name" 
                                   value="<?php echo $developerdata['developer_name'] ?>"
                                   pattern="^[A-Z]+[a-zA-Z ]*$"
                                   title="Name must start with capital letter and contain only letters"
                                   required>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="txt_email" class="form-label">Developer Email</label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="form-control" name="txt_email" id="txt_email" 
                                   value="<?php echo $developerdata['developer_email'] ?>"
                                   required>
                        </div>
                    </div>
                    
                    <button type="submit" name="btn_submit" id="btn_submit" class="btn btn-dev-submit">
                        <i class="fas fa-save me-2"></i>Update Profile
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Original form (hidden) -->
    <form id="form1" name="form1" method="post" action="" style="display:none;">
        <table width="200" border="1">
            <tr>
                <td>Name</td>
                <td><label for="txt_name"></label>
                <input type="text" name="txt_name" id="txt_name" value="<?php echo $developerdata['developer_name'] ?>" />
            </tr>
            <tr>
                <td>Email</td>
                <td><label for="txt_email"></label>
                <input type="text" name="txt_email" id="txt_email" value="<?php echo $developerdata['developer_email'] ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="2"><div align="center">
                    <input name="btn_submit" type="submit" id="btn_submit" value="Submit" />
                </div></td>
            </tr>
        </table>
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>