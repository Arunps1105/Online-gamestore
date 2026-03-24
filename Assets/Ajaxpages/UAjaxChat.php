<?php
include("../Connection/Connection.php");
session_start();
header("Content-Type: text/plain");

$uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : 0;
$did = isset($_SESSION["did"]) ? $_SESSION["did"] : 0;

if ($uid == 0 && $did == 0) {
    echo "Unauthorized access";
    exit;
}

$communityId = isset($_POST['community_id']) ? $_POST['community_id'] : (isset($_GET['community_id']) ? $_GET['community_id'] : null);

// Check if user or developer is a member of the community
$memberCheck = "SELECT * FROM tbl_member WHERE (user_id = '$uid' OR developer_id = '$did') AND community_id = '$communityId' AND member_status = 0";
$memberResult = $Con->query($memberCheck);
if ($memberResult->num_rows == 0) {
    echo "You are not a member of this community";
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $chatId = $_GET['chat_id'];
    $delQry = "DELETE FROM tbl_chat WHERE chat_id = '$chatId' AND (from_user_id = '$uid' OR from_developer_id = '$did') AND community_id = '$communityId'";
    echo $Con->query($delQry) ? "Message deleted" : "Deletion failed";
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    $delQry = "DELETE FROM tbl_chat WHERE community_id = '$communityId' AND (from_user_id = '$uid' OR from_developer_id = '$did')";
    echo $Con->query($delQry) ? "Your messages cleared" : "Clear failed";
    exit;
}

if (!isset($_POST['msg']) || !isset($_POST['community_id'])) {
    echo "Invalid request";
    exit;
}

$msg = trim($_POST['msg']);
$filePath = '';

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = [
        'image/jpeg', 'image/png', 'image/gif', 'image/jpg',
        'application/pdf', 'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/x-zip-compressed', 'application/zip'
    ];
    $fileType = $_FILES['file']['type'];
    $fileSize = $_FILES['file']['size'];
    $maxFileSize = 5 * 1024 * 1024; 

    if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
        $targetDir = "../Files/Chat/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileName = time() . "_" . basename($_FILES["file"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $filePath = $fileName;
        } else {
            echo "File upload failed";
            exit;
        }
    } else {
        echo "Invalid file type or size";
        exit;
    }
}

$checkQry = "SELECT * FROM tbl_chat 
             WHERE (from_user_id = '$uid' OR from_developer_id = '$did') 
             AND community_id = '$communityId' 
             AND chat_content = '$msg' 
             AND chat_date > NOW() - INTERVAL 1 MINUTE";
$checkResult = $Con->query($checkQry);

if ($checkResult->num_rows == 0 && ($msg !== '' || $filePath !== '')) {
    $insQry = "INSERT INTO tbl_chat (from_user_id, from_developer_id, chat_content, chat_date, chat_file, community_id) 
               VALUES ('$uid', '$did', '$msg', NOW(), '$filePath', '$communityId')";
    
    $Con->query($insQry);
    echo "Message sent";
    exit;
}
echo "Message sent";
exit;
?>