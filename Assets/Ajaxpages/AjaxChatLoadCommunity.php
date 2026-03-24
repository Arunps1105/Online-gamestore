<?php
include("../Connection/Connection.php");
session_start();

$uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : 0;
$did = isset($_SESSION["did"]) ? $_SESSION["did"] : 0;
$communityId = isset($_GET["communityId"]) ? $_GET["communityId"] : "";

$selQry = "SELECT c.*, u.user_name, u.user_photo, d.developer_name, d.developer_photo 
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

    $isSent = ($data["from_user_id"] == $uid && $uid != 0) || ($data["from_developer_id"] == $did && $did != 0);
    $messageClass = $isSent ? "sent" : "received";
    $senderName = $data["from_user_id"] != 0 ? $data["user_name"] : $data["developer_name"];
    $senderPhoto = $data["from_user_id"] != 0 ? "../Assets/Files/User/Photo/{$data['user_photo']}" : "../Assets/Files/Developer/Photo/{$data['developer_photo']}";
?>
    <div class="message <?php echo $messageClass ?>" data-chat-id="<?php echo $data['chat_id'] ?>">
        <div class="sender-info">
            <img src="<?php echo $senderPhoto ?>" alt="Sender" class="sender-photo">
            <span class="sender-name"><?php echo $senderName ?></span>
        </div>
        <?php if (!empty($data["chat_file"])) { ?>
            <div class="file-preview">
                <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $data["chat_file"])) { ?>
                    <img src="../Assets/Files/Chat/<?php echo $data["chat_file"] ?>" alt="Attachment">
                <?php } else { ?>
                    <a href="../Assets/Files/Chat/<?php echo $data["chat_file"] ?>" target="_blank">Download File</a>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="message-content"><?php echo $data["chat_content"] ?></div>
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