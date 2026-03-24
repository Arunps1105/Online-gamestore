<?php
include("../Connection/Connection.php");
session_start();

$did = isset($_SESSION["did"]) ? $_SESSION["did"] : 0;
$communityId = isset($_GET["id"]) ? $_GET["id"] : null;

// Check if developer is a member of the community
$memberCheck = "SELECT * FROM tbl_member WHERE developer_id = '$did' AND community_id = '$communityId' AND member_status = 0";
$memberResult = $Con->query($memberCheck);
if ($memberResult->num_rows == 0) {
    echo "You are not a member of this community";
    exit;
}

$selQry = "SELECT c.*, 
                  COALESCE(u.user_name, d.developer_name) AS sender_name, 
                  COALESCE(u.user_photo, d.developer_photo) AS sender_photo,
                  c.from_developer_id,
                  c.from_user_id
           FROM tbl_chat c 
           LEFT JOIN tbl_user u ON c.from_user_id = u.user_id 
           LEFT JOIN tbl_developer d ON c.from_developer_id = d.developer_id 
           WHERE c.community_id = '$communityId' 
           ORDER BY c.chat_date";
$result = $Con->query($selQry);
$currentDate = '';

while ($data = $result->fetch_assoc()) {
    $messageDate = date('Y-m-d', strtotime($data["chat_date"]));
    if ($messageDate != $currentDate) {
        $currentDate = $messageDate;
        echo "<div class='date-divider'>" . date('M d, Y', strtotime($currentDate)) . "</div>";
    }

    $isSent = ($data["from_developer_id"] == $did && $did != 0);
    $messageClass = $isSent ? "sent" : "received";
    $photoPath = $data["from_developer_id"] != 0 ? "../Assets/Files/Developer/Photo/" : "../Assets/Files/User/Photo/";
?>
    <div class="message <?php echo $messageClass ?>" data-chat-id="<?php echo $data['chat_id'] ?>">
        <div class="sender-info">
            <!-- <img src="<?php echo $photoPath . htmlspecialchars($data["sender_photo"]) ?>" alt="Sender Profile" class="sender-photo"> -->
            <span class="sender-name"><?php echo htmlspecialchars($data["sender_name"]) ?></span>
        </div>
        <?php if (!empty($data["chat_file"])) { ?>
            <div class="file-preview">
                <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $data["chat_file"])) { ?>
                    <img src="../Assets/Files/Chat/<?php echo htmlspecialchars($data["chat_file"]) ?>" alt="Attachment">
                <?php } else { ?>
                    <a href="../Assets/Files/Chat/<?php echo htmlspecialchars($data["chat_file"]) ?>" target="_blank">Download File</a>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="message-content"><?php echo htmlspecialchars($data["chat_content"]) ?></div>
        <div class="message-time"><?php echo date('h:i A', strtotime($data["chat_date"])) ?></div>
        <?php if ($isSent) { ?>
            <span class="delete-btn" onclick="deleteMessage(<?php echo $data['chat_id'] ?>)">
                <i class="fas fa-trash"></i>
            </span>
        <?php } ?>
    </div>
<?php
}
?>