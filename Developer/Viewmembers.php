<?php
include("../Assets/Connection/Connection.php");
session_start();


$did = $_SESSION["did"];
$communityId = isset($_GET["cid"]) && is_numeric($_GET["cid"]) ? $_GET["cid"] : null;

// Check if community exists
$selCommunity = "SELECT * FROM tbl_community WHERE community_id = '$communityId'";
$communityResult = $Con->query($selCommunity);
if ($communityResult->num_rows == 0) {
    echo "<script>alert('Community does not exist'); window.location='Communitys.php';</script>";
    exit;
}
$community = $communityResult->fetch_assoc();

// Check if developer is a member
$memberCheck = "SELECT * FROM tbl_member WHERE developer_id = '$did' AND community_id = '$communityId' AND member_status = 0";
$memberResult = $Con->query($memberCheck);
if ($memberResult->num_rows == 0) {
    echo "<script>alert('You are not a member of this community'); window.location='Communitys.php';</script>";
    exit;
}

// Check if developer is the community admin
$isAdmin = $community['developer_id'] == $did;

if (!$isAdmin) {
    echo "<script>alert('You do not have permission to manage members'); window.location='Communitys.php';</script>";
    exit;
}

// Handle member deletion (admin only)
if (isset($_GET["action"]) && $_GET["action"] == "delete") {
    if (isset($_GET["user_id"]) && is_numeric($_GET["user_id"])) {
        $userId = $_GET["user_id"];
        $delQry = "DELETE FROM tbl_member WHERE user_id = '$userId' AND community_id = '$communityId'";
        if ($Con->query($delQry)) {
            echo "<script>alert('Member removed successfully'); window.location='Viewmembers.php?cid=$communityId';</script>";
        } else {
            echo "<script>alert('Failed to remove member'); window.location='Viewmembers.php?cid=$communityId';</script>";
        }
    } elseif (isset($_GET["developer_id"]) && is_numeric($_GET["developer_id"])) {
        $developerId = $_GET["developer_id"];
        if ($developerId != $did) {
            $delQry = "DELETE FROM tbl_member WHERE developer_id = '$developerId' AND community_id = '$communityId'";
            if ($Con->query($delQry)) {
                echo "<script>alert('Member removed successfully'); window.location='DeveloperViewMembers.php?cid=$communityId';</script>";
            } else {
                echo "<script>alert('Failed to remove member'); window.location='DeveloperViewMembers.php?cid=$communityId';</script>";
            }
        } else {
            echo "<script>alert('You cannot remove yourself'); window.location='DeveloperViewMembers.php?cid=$communityId';</script>";
        }
    }
}

// Handle member acceptance (admin only)
if (isset($_GET["action"]) && $_GET["action"] == "accept" && isset($_GET["user_id"]) && is_numeric($_GET["user_id"])) {
    $userId = $_GET["user_id"];
    $acceptQry = "UPDATE tbl_member SET member_status = 0 WHERE user_id = '$userId' AND community_id = '$communityId' AND member_status = 1";
    if ($Con->query($acceptQry)) {
        echo "<script>alert('Member accepted successfully'); window.location='DeveloperViewMembers.php?cid=$communityId';</script>";
    } else {
        echo "<script>alert('Failed to accept member'); window.location='DeveloperViewMembers.php?cid=$communityId';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members of <?php echo htmlspecialchars($community["community_name"]) ?></title>
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
        .delete-btn, .accept-btn {
            text-decoration: none;
            margin-right: 10px;
        }
        .delete-btn {
            color: #ff4444;
        }
        .accept-btn {
            color: #28a745;
        }
        .delete-btn i, .accept-btn i {
            margin-right: 5px;
        }
        .section-title {
            margin: 20px 0 10px;
            font-size: 18px;
            font-weight: bold;
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

        <!-- Active Members Section -->
        <div class="section-title">Active Members</div>
        <table>
            <tr>
                <th>SlNo</th>
                <th>Member</th>
                <th>Photo</th>
                <th>Action</th>
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
                echo "<tr><td colspan='4'>No active members found.</td></tr>";
            } else {
                $i = 0;
                // Display user members
                while ($member = $memberResult->fetch_assoc()) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($member["user_name"]); ?></td>
                        <td><img src="../Assets/Files/User/Photo/<?php echo htmlspecialchars($member["user_photo"]) ?>" alt="Member Photo"></td>
                        <td>
                            <a href="ViewMembers.php?cid=<?php echo $communityId; ?>&action=delete&user_id=<?php echo $member["user_id"]; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to remove this member?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
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
                        <td>
                            <?php if ($devMember["developer_id"] != $did) { ?>
                                <a href="ViewMembers.php?cid=<?php echo $communityId; ?>&action=delete&developer_id=<?php echo $devMember["developer_id"]; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to remove this member?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            <?php } else { ?>
                                <span>-</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>

        <!-- Pending Join Requests Section -->
        <div class="section-title">Pending Join Requests</div>
        <table>
            <tr>
                <th>SlNo</th>
                <th>User</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
            <?php
            // Fetch pending user join requests
            $selPending = "SELECT m.user_id, u.user_name, u.user_photo 
                           FROM tbl_member m 
                           JOIN tbl_user u ON m.user_id = u.user_id 
                           WHERE m.community_id = '$communityId' AND m.member_status = 1";
            $pendingResult = $Con->query($selPending);

            if ($pendingResult->num_rows == 0) {
                echo "<tr><td colspan='4'>No pending join requests.</td></tr>";
            } else {
                $i = 0;
                while ($pending = $pendingResult->fetch_assoc()) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($pending["user_name"]); ?></td>
                        <td><img src="../Assets/Files/User/Photo/<?php echo htmlspecialchars($pending["user_photo"]) ?>" alt="User Photo"></td>
                        <td>
                            <a href="ViewMembers.php?cid=<?php echo $communityId; ?>&action=accept&user_id=<?php echo $pending["user_id"]; ?>" class="accept-btn" onclick="return confirm('Are you sure you want to accept this member?')">
                                <i class="fas fa-check"></i> Accept
                            </a>
                            <a href="ViewMembers.php?cid=<?php echo $communityId; ?>&action=delete&user_id=<?php echo $pending["user_id"]; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to reject this join request?')">
                                <i class="fas fa-trash"></i> Reject
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</body>
</html>