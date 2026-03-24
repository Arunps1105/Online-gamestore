<?php
include("../Assets/Connection/Connection.php");
session_start();

if (!isset($_SESSION["uid"])) {
    header("Location: ../Login.php");
    exit;
}

$uid = $_SESSION["uid"];
$communityId = isset($_GET["cid"]) && is_numeric($_GET["cid"]) ? $_GET["cid"] : null;

// Check if community exists
$selCommunity = "SELECT * FROM tbl_community WHERE community_id = '$communityId'";
$communityResult = $Con->query($selCommunity);
if ($communityResult->num_rows == 0) {
    echo "<script>alert('Community does not exist'); window.location='Community.php';</script>";
    exit;
}
$community = $communityResult->fetch_assoc();

// Check if user is a member
$memberCheck = "SELECT * FROM tbl_member WHERE user_id = '$uid' AND community_id = '$communityId' AND member_status = 0";
$memberResult = $Con->query($memberCheck);
if ($memberResult->num_rows == 0) {
    echo "<script>alert('You are not a member of this community'); window.location='Community.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members of <?php echo htmlspecialchars($community["community_name"]) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            color: #0084ff;
            text-decoration: none;
            font-size: 16px;
        }
        .back-btn i {
            margin-right: 5px;
        }
        .community-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .community-info img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            object-fit: cover;
        }
        .community-info h2 {
            margin: 10px 0;
            font-size: 24px;
        }
        .community-info p {
            color: #667781;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #0084ff;
            color: white;
        }
        td img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .admin-tag {
            background: #28a745;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="CommunityChat.php?communityId=<?php echo $communityId; ?>" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Chat</a>
        <div class="community-info">
            <img src="../Assets/Files/Developer/Community/<?php echo htmlspecialchars($community["community_photo"]) ?>" alt="Community Photo">
            <h2><?php echo htmlspecialchars($community["community_name"]) ?></h2>
            <p><?php echo htmlspecialchars($community["community_description"]) ?></p>
        </div>
        <table>
            <tr>
                <th>SlNo</th>
                <th>Member</th>
                <th>Photo</th>
            </tr>
            <?php
            // Fetch user members
            $selMembers = "SELECT m.user_id, u.user_name, u.user_photo 
                           FROM tbl_member m 
                           JOIN tbl_user u ON m.user_id = u.user_id 
                           WHERE m.community_id = '$communityId' AND m.member_status = 0";
            $memberResult = $Con->query($selMembers);
            
            // Fetch developer members
            $selDevMembers = "SELECT m.developer_id, d.developer_name, d.developer_photo 
                             FROM tbl_member m 
                             JOIN tbl_developer d ON m.developer_id = d.developer_id 
                             WHERE m.community_id = '$communityId' AND m.member_status = 0";
            $devMemberResult = $Con->query($selDevMembers);

            if ($memberResult->num_rows == 0 && $devMemberResult->num_rows == 0) {
                echo "<tr><td colspan='3'>No members found.</td></tr>";
            } else {
                $i = 0;
                // Display user members
                while ($member = $memberResult->fetch_assoc()) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <?php echo htmlspecialchars($member["user_name"]); ?>
                        </td>
                        <td><img src="../Assets/Files/User/Photo/<?php echo htmlspecialchars($member["user_photo"]) ?>" alt="Member Photo"></td>
                    </tr>
                    <?php
                }
                // Display developer members
                while ($devMember = $devMemberResult->fetch_assoc()) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <?php echo htmlspecialchars($devMember["developer_name"]); ?>
                            <?php if ($devMember["developer_id"] == $community["developer_id"]) { ?>
                                <span class="admin-tag">Admin</span>
                            <?php } ?>
                        </td>
                        <td><img src="../Assets/Files/Developer/Photo/<?php echo htmlspecialchars($devMember["developer_photo"]) ?>" alt="Developer Photo"></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</body>
</html>