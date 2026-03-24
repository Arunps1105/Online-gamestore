<?php
include("../Assets/Connection/Connection.php");
session_start();

$uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : 0;
$did = isset($_SESSION["did"]) ? $_SESSION["did"] : 0;

if ($uid == 0 && $did == 0) {
    header("Location: ../Login.php");
    exit;
}

$communityId = isset($_GET["id"]) && is_numeric($_GET["id"]) ? $_GET["id"] : null;

// Check if community exists
$selCommunity = "SELECT * FROM tbl_community WHERE community_id = '$communityId'";
$communityResult = $Con->query($selCommunity);
if ($communityResult->num_rows == 0) {
    echo "<script>alert('Community does not exist'); window.location='Community.php';</script>";
    exit;
}
$row = $communityResult->fetch_assoc();

// Check if user or developer is a member of the community
$memberCheck = "SELECT * FROM tbl_member WHERE (user_id = '$uid' OR developer_id = '$did') AND community_id = '$communityId' AND member_status = 0";
$memberResult = $Con->query($memberCheck);
if ($memberResult->num_rows == 0) {
    echo "<script>alert('You are not a member of this community'); window.location='Communitys.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat in <?php echo htmlspecialchars($row["community_name"]) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .chat-container {
            width: 100%;
            max-width: 900px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 90vh;
            position: relative;
        }

        .chat-header {
            background: #0084ff;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .chat-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .chat-header .community-info {
            flex: 1;
        }

        .chat-header .community-info h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 500;
        }

        .chat-header .options {
            cursor: pointer;
            font-size: 20px;
        }

        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .chat-body::-webkit-scrollbar {
            width: 6px;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .message {
            max-width: 70%;
            padding: 8px 12px;
            border-radius: 8px;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .message.sent {
            background: #dcf8c6;
            align-self: flex-end;
            margin-left: auto;
            border-bottom-right-radius: 2px;
        }

        .message.received {
            background: white;
            align-self: flex-start;
            border-bottom-left-radius: 2px;
            box-shadow: 0 1px 0.5px rgba(0, 0, 0, 0.13);
        }

        .sender-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: #667781;
        }

        .sender-photo {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            object-fit: cover;
        }

        .sender-name {
            font-weight: 500;
        }

        .message-content {
            word-break: break-word;
            font-size: 14px;
            line-height: 1.4;
        }

        .message-time {
            font-size: 11px;
            color: #667781;
            align-self: flex-end;
        }

        .message .delete-btn {
            display: none;
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            color: #ff4444;
            font-size: 14px;
        }

        .message.sent:hover .delete-btn {
            display: block;
        }

        .file-preview {
            margin-top: 8px;
            max-width: 200px;
        }

        .file-preview img {
            max-width: 100%;
            border-radius: 8px;
        }

        .date-divider {
            text-align: center;
            color: #667781;
            font-size: 12px;
            margin: 15px 0;
            background: rgba(255, 255, 255, 0.8);
            padding: 5px;
            border-radius: 5px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .chat-footer {
            padding: 10px 20px;
            background: #f0f2f5;
            display: flex;
            align-items: center;
            gap: 10px;
            border-top: 1px solid #d9d9d9;
        }

        .message-input {
            flex: 1;
            padding: 10px 15px;
            border: none;
            border-radius: 20px;
            background: white;
            font-size: 14px;
            outline: none;
        }

        .send-btn, .attach-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: #0084ff;
        }

        .send-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .community-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .community-content {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            position: relative;
            max-width: 400px;
        }

        .community-content img {
            width: 200px;
            height: 200px;
            border-radius: 10px;
            object-fit: cover;
        }

        .community-content p {
            margin: 10px 0;
            font-size: 14px;
            color: #333;
        }

        .close-community {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
            color: #667781;
        }

        .options-menu {
            display: none;
            position: absolute;
            right: 20px;
            top: 60px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 100;
        }

        .options-menu a {
            display: block;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            font-size: 14px;
        }

        .options-menu a:hover {
            background: #f0f2f5;
        }

        .loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .loader::after {
            content: '';
            width: 40px;
            height: 40px;
            border: 4px solid #0084ff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 600px) {
            .chat-container {
                height: 100vh;
                border-radius: 0;
            }

            .message {
                max-width: 80%;
            }
        }
    </style>
</head>
<body>
    <div class="loader" id="loader"></div>
    <div class="community-modal" id="communityModal">
        <div class="community-content">
            <i class="fas fa-times close-community" onclick="closeCommunityModal()"></i>
            <img src="../Assets/Files/Developer/Community/<?php echo htmlspecialchars($row["community_photo"]) ?>" alt="Community Photo">
            <h3><?php echo htmlspecialchars($row["community_name"]) ?></h3>
            <p><?php echo htmlspecialchars($row["community_description"]) ?></p>
        </div>
    </div>
    <div class="chat-container">
        <div class="chat-header">
            <img src="../Assets/Files/Developer/Community/<?php echo htmlspecialchars($row["community_photo"]) ?>" alt="Community Photo" onclick="openCommunityModal()">
            <div class="community-info">
                <h3><?php echo htmlspecialchars($row["community_name"]) ?></h3>
                <input type="hidden" id="communityId" value="<?php echo $communityId ?>">
            </div>
            <i class="fas fa-ellipsis-v options" onclick="toggleOptions()"></i>
        </div>
        <div class="options-menu" id="optionsMenu">
            <a href="#" onclick="clearChat()"><i class="fas fa-broom"></i> Clear Your Messages</a>
            <a href="ViewMembers.php?cid=<?php echo $communityId; ?>"><i class="fas fa-users"></i> View Members</a>
        </div>
        <div class="chat-body" id="chatBody"></div>
        <div class="chat-footer">
            <label for="fileInput">
                <i class="fas fa-paperclip attach-btn"></i>
            </label>
            <input type="file" id="fileInput" style="display: none;" onchange="previewFile()">
            <input type="text" class="message-input" id="messageInput" placeholder="Type a message..." autocomplete="off">
            <button class="send-btn" id="sendBtn" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
            <div id="filePreview" class="file-preview"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let isSending = false;
        let isInitialLoad = true;

        function sendMessage() {
            if (isSending) return;
            isSending = true;
            const sendBtn = document.getElementById("sendBtn");
            sendBtn.disabled = true;

            const message = document.getElementById("messageInput").value.trim();
            const fileInput = document.getElementById("fileInput");
            const file = fileInput.files[0];
            const communityId = document.getElementById("communityId").value;

            if (!message && !file) {
                isSending = false;
                sendBtn.disabled = false;
                return;
            }

            if (message.length > 60) {
                alert("Message length should be less than 60 characters");
                isSending = false;
                sendBtn.disabled = false;
                return;
            }

            const formData = new FormData();
            formData.append("msg", message);
            formData.append("community_id", communityId);
            if (file) formData.append("file", file);

            $.ajax({
                url: "../Assets/AjaxPages/UAjaxChat.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: () => document.getElementById("loader").style.display = "flex",
                success: (response) => {
                    if (response.trim() === "Message sent") {
                        document.getElementById("messageInput").value = "";
                        document.getElementById("fileInput").value = "";
                        document.getElementById("filePreview").innerHTML = "";
                        loadMessages();
                    }
                    // No alert for other responses to avoid popups
                },
                error: () => {
                    // Silent error handling to avoid popups
                    console.log("Failed to send message");
                },
                complete: () => {
                    isSending = false;
                    sendBtn.disabled = false;
                    document.getElementById("loader").style.display = "none";
                    // Clear inputs as a fallback
                    document.getElementById("messageInput").value = "";
                    document.getElementById("fileInput").value = "";
                    document.getElementById("filePreview").innerHTML = "";
                }
            });
        }

        function deleteMessage(chatId) {
            if (confirm("Are you sure you want to delete this message?")) {
                $.ajax({
                    url: `../Assets/AjaxPages/UAjaxChat.php?action=delete&chat_id=${chatId}&community_id=${document.getElementById("communityId").value}`,
                    success: () => loadMessages()
                });
            }
        }

        function clearChat() {
            const communityId = document.getElementById("communityId").value;
            if (confirm("Are you sure you want to clear all your messages?")) {
                document.getElementById("loader").style.display = "flex";
                $.ajax({
                    url: `../Assets/AjaxPages/UAjaxChat.php?action=clear&community_id=${communityId}`,
                    success: () => {
                        alert("Your messages cleared");
                        loadMessages();
                    },
                    complete: () => document.getElementById("loader").style.display = "none"
                });
            }
        }

        function loadMessages() {
            const communityId = document.getElementById("communityId").value;
            const chatBody = document.getElementById("chatBody");
            const oldScrollHeight = chatBody.scrollHeight;
            const isScrolledToBottom = chatBody.scrollHeight - chatBody.scrollTop <= chatBody.clientHeight + 5;

            $.ajax({
                url: `../Assets/AjaxPages/AjaxChatLoad.php?id=${communityId}`,
                success: (data) => {
                    const oldScrollTop = chatBody.scrollTop;
                    $("#chatBody").html(data);
                    const newScrollHeight = chatBody.scrollHeight;

                    if (isInitialLoad || isScrolledToBottom) {
                        chatBody.scrollTop = newScrollHeight;
                        isInitialLoad = false;
                    } else {
                        chatBody.scrollTop = oldScrollTop + (newScrollHeight - oldScrollHeight);
                    }
                }
            });
        }

        function previewFile() {
            const file = document.getElementById("fileInput").files[0];
            const preview = document.getElementById("filePreview");
            preview.innerHTML = "";
            if (file) {
                if (file.type.startsWith('image/')) {
                    const img = document.createElement("img");
                    img.src = URL.createObjectURL(file);
                    img.className = "file-preview";
                    img.style.maxWidth = "100px";
                    preview.appendChild(img);
                } else {
                    preview.innerHTML = `<p>Selected: ${file.name}</p>`;
                }
            }
        }

        function toggleOptions() {
            const menu = document.getElementById("optionsMenu");
            menu.style.display = menu.style.display === "none" ? "block" : "none";
        }

        function openCommunityModal() {
            document.getElementById("communityModal").style.display = "flex";
        }

        function closeCommunityModal() {
            document.getElementById("communityModal").style.display = "none";
        }

        // Auto-load messages
        loadMessages();
        setInterval(loadMessages, 1000);

        // Close options menu when clicking outside
        document.addEventListener("click", (e) => {
            const optionsMenu = document.getElementById("optionsMenu");
            if (!e.target.closest(".options") && !e.target.closest(".options-menu")) {
                optionsMenu.style.display = "none";
            }
        });
    </script>
</body>
</html>