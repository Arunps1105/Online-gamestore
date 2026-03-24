<?php
include("../Connection/Connection.php");
session_start();

// Check if user or developer is logged in
if (!isset($_SESSION["uid"]) && !isset($_SESSION["did"])) {
    echo "Unauthorized access";
    exit;
}

$from_uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : 0;
$from_did = isset($_SESSION["did"]) ? $_SESSION["did"] : 0;

if ($from_uid == 0 && $from_did == 0) {
    echo "Invalid session";
    exit;
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $chatId = $_GET['chat_id'];
    $delQry = "DELETE FROM tbl_chat WHERE chat_id = '$chatId' AND (from_user_id = '$from_uid' OR from_developer_id = '$from_did')";
    echo $Con->query($delQry) ? "Message deleted" : "Deletion failed";
    exit;
}

// Handle clear action
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    $communityId = $_GET['communityId'];
    $delQry = "DELETE FROM tbl_chat WHERE community_id = '$communityId' AND (from_user_id = '$from_uid' OR from_developer_id = '$from_did')";
    echo $Con->query($delQry) ? "Chat cleared" : "Clear failed";
    exit;
}

// Handle message sending
if (!isset($_POST['msg']) || !isset($_POST['communityId'])) {
    echo "Invalid request";
    exit;
}

$msg = trim($_POST['msg']);
$communityId = $_POST['communityId'];
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
    $maxFileSize = 5 * 1024 * 1024; // 5MB

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

// Check for duplicate message
$checkQry = "SELECT * FROM tbl_chat 
             WHERE (from_user_id = '$from_uid' OR from_developer_id = '$from_did') 
             AND community_id = '$communityId' 
             AND chat_content = '$msg' 
             AND chat_file = '$filePath' 
             AND chat_date > NOW() - INTERVAL 1 MINUTE";
$checkResult = $Con->query($checkQry);

if ($checkResult->num_rows == 0 && ($msg !== '' || $filePath !== '')) {
    $insQry = "INSERT INTO tbl_chat (from_user_id, from_developer_id, chat_content, chat_file, chat_date, community_id) 
               VALUES ('$from_uid', '$from_did', '$msg', '$filePath', NOW(), '$communityId')";

    if ($Con->query($insQry)) {
        echo "Message sent";
    } else {
        echo "Failed to send message";
    }
} else {
    echo "Duplicate message ignored";
}
?>