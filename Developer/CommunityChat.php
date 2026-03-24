<?php
include("../Assets/Connection/Connection.php");
session_start();

// Fetch community details
$communityId = $_GET["communityId"];
$sel = "SELECT * FROM tbl_community WHERE community_id = '$communityId'";
$res = $Con->query($sel);
$row = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Chat - <?php echo $row["community_name"] ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary-color: #5865F2; /* Discord-like blue */
            --secondary-color: #2C2D31;
            --dark-color: #1E1F22;
            --darker-color: #111214;
            --text-color: #F2F3F5;
            --accent-color: #00A8FC;
            --danger-color: #ED4245;
            --success-color: #3BA55C;
        }

        body {
            background: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            color: var(--text-color);
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(17, 18, 20, 0.85);
            z-index: -1;
        }

        .chat-container {
            width: 100%;
            max-width: 1000px;
            background: rgba(30, 31, 34, 0.9);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 90vh;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
        }

        .chat-header {
            background: var(--secondary-color);
            color: white;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .chat-header .back-btn {
            background: none;
            border: none;
            color: var(--text-color);
            font-size: 18px;
            cursor: pointer;
            transition: all 0.2s;
            padding: 6px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-header .back-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--accent-color);
        }

        .chat-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .chat-header .community-info {
            flex: 1;
        }

        .chat-header .community-info h3 {
            margin: 0;
            font-size: 17px;
            font-weight: 600;
            color: var(--text-color);
        }

        .chat-header .options {
            cursor: pointer;
            font-size: 18px;
            color: var(--text-color);
            transition: all 0.2s;
            padding: 6px;
            border-radius: 50%;
        }

        .chat-header .options:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--accent-color);
        }

        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            background: var(--dark-color);
        }

        .chat-body::-webkit-scrollbar {
            width: 8px;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        .chat-body::-webkit-scrollbar-track {
            background: transparent;
        }

        .message {
            max-width: 75%;
            padding: 12px 16px;
            border-radius: 8px;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 4px;
            transition: background 0.2s;
        }

        .message.sent {
            background: var(--primary-color);
            align-self: flex-end;
            margin-left: auto;
            border-bottom-right-radius: 2px;
            color: white;
        }

        .message.received {
            background: var(--secondary-color);
            align-self: flex-start;
            border-bottom-left-radius: 2px;
            color: var(--text-color);
        }

        .sender-info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .sender-photo {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            object-fit: cover;
        }

        .sender-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--accent-color);
        }

        .message-content {
            word-break: break-word;
            font-size: 15px;
            line-height: 1.5;
        }

        .message-time {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.6);
            align-self: flex-end;
            margin-top: 2px;
            font-weight: 400;
        }

        .message .delete-btn {
            display: none;
            position: absolute;
            top: 8px;
            right: 8px;
            cursor: pointer;
            color: var(--danger-color);
            font-size: 14px;
            background: rgba(0, 0, 0, 0.3);
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .message:hover .delete-btn {
            display: flex;
        }

        .file-preview {
            margin-top: 8px;
            max-width: 300px;
            border-radius: 8px;
            overflow: hidden;
        }

        .file-preview img {
            max-width: 100%;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .file-preview img:hover {
            transform: scale(1.02);
        }

        .date-divider {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            font-size: 13px;
            margin: 20px 0;
            position: relative;
        }

        .date-divider::before,
        .date-divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }

        .date-divider::before {
            left: 0;
        }

        .date-divider::after {
            right: 0;
        }

        .chat-footer {
            padding: 12px 20px;
            background: var(--secondary-color);
            display: flex;
            align-items: center;
            gap: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .message-input {
            flex: 1;
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            background: var(--dark-color);
            font-size: 15px;
            outline: none;
            color: var(--text-color);
            transition: all 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .message-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(88, 101, 242, 0.3);
        }

        .message-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .send-btn, .attach-btn {
            background: var(--primary-color);
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: white;
            transition: all 0.2s;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .attach-btn {
            background: transparent;
            color: var(--text-color);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .send-btn:hover {
            background: #4752C4;
            transform: translateY(-1px);
        }

        .attach-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .profile-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .profile-content {
            background: var(--secondary-color);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            position: relative;
            max-width: 80%;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .profile-content img {
            width: 200px;
            height: 200px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .close-profile {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-color);
            transition: all 0.2s;
            background: rgba(0, 0, 0, 0.3);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-profile:hover {
            background: var(--danger-color);
            color: white;
        }

        .options-menu {
            display: none;
            position: absolute;
            right: 20px;
            top: 60px;
            background: var(--secondary-color);
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 100;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            min-width: 180px;
        }

        .options-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: var(--text-color);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }

        .options-menu a:hover {
            background: var(--primary-color);
            color: white;
        }

        .options-menu a i {
            width: 20px;
            text-align: center;
        }

        .loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(3px);
        }

        .loader::after {
            content: '';
            width: 40px;
            height: 40px;
            border: 4px solid var(--primary-color);
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--secondary-color);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transform: translateX(200%);
            transition: transform 0.3s ease-out;
            z-index: 1000;
            border-left: 3px solid var(--success-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification i {
            color: var(--success-color);
        }

        @media (max-width: 768px) {
            .chat-container {
                height: 100vh;
                border-radius: 0;
            }

            .message {
                max-width: 85%;
            }

            .profile-content img {
                width: 180px;
                height: 180px;
            }
        }
    </style>
</head>
<body>
    <div class="loader" id="loader"></div>
    
    <div class="profile-modal" id="profile">
        <div class="profile-content">
            <i class="fas fa-times close-profile" onclick="closeProfile()"></i>
            <img src="../Assets/Files/Developer/Community/<?php echo $row["community_photo"] ?>" alt="Community Photo">
        </div>
    </div>
    
    <div class="chat-container">
        <div class="chat-header">
            <button class="back-btn" onclick="goToDashboard()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <img src="../Assets/Files/Developer/Community/<?php echo $row["community_photo"] ?>" alt="Community Photo" onclick="openProfile()">
            <div class="community-info">
                <h3><?php echo $row["community_name"] ?></h3>
                <input type="hidden" id="communityId" value="<?php echo $communityId ?>">
            </div>
            <i class="fas fa-ellipsis-v options" onclick="toggleOptions()"></i>
        </div>
        
        <div class="options-menu" id="optionsMenu">
            <a href="#" onclick="clearChat()"><i class="fas fa-trash-alt"></i> Clear Chat</a>
            <a href="Viewmembers.php?cid=<?php echo $communityId ?>"><i class="fas fa-users"></i> View Members</a>
        </div>
        
        <div class="chat-body" id="chatBody"></div>
        
        <div class="chat-footer">
            <label for="fileInput">
                <i class="fas fa-paperclip attach-btn"></i>
            </label>
            <input type="file" id="fileInput" style="display: none;" onchange="previewFile()">
            <input type="text" class="message-input" id="messageInput" placeholder="Type a message..." autocomplete="off" onkeypress="handleKeyPress(event)">
            <button class="send-btn" id="sendBtn" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
            <div id="filePreview" class="file-preview"></div>
        </div>
    </div>

    <div id="notification" class="notification">
        <i class="fas fa-check-circle"></i>
        <span>Message sent successfully!</span>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let isSending = false;
        let isInitialLoad = true;

        function goToDashboard() {
            window.location.href = "Homepage.php";
        }

        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.querySelector('span').textContent = message;
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        function handleKeyPress(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        }

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

            if (message.length > 500) {
                showNotification("Message too long (max 500 chars)");
                isSending = false;
                sendBtn.disabled = false;
                return;
            }

            const formData = new FormData();
            formData.append("msg", message);
            formData.append("communityId", communityId);
            if (file) formData.append("file", file);

            $.ajax({
                url: "../Assets/AjaxPages/AjaxCommunityChat.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: () => document.getElementById("loader").style.display = "flex",
                success: (response) => {
                    document.getElementById("messageInput").value = "";
                    document.getElementById("fileInput").value = "";
                    document.getElementById("filePreview").innerHTML = "";
                    loadMessages();
                    showNotification("Message sent!");
                    isSending = false;
                    sendBtn.disabled = false;
                },
                error: () => {
                    showNotification("Failed to send message");
                    isSending = false;
                    sendBtn.disabled = false;
                },
                complete: () => document.getElementById("loader").style.display = "none"
            });
        }

        function deleteMessage(chatId) {
            if (confirm("Are you sure you want to delete this message?")) {
                $.ajax({
                    url: `../Assets/AjaxPages/AjaxCommunityChat.php?action=delete&chat_id=${chatId}`,
                    success: () => {
                        loadMessages();
                        showNotification("Message deleted");
                    }
                });
            }
        }

        function clearChat() {
            const communityId = document.getElementById("communityId").value;
            if (confirm("Are you sure you want to clear all messages?")) {
                document.getElementById("loader").style.display = "flex";
                $.ajax({
                    url: `../Assets/AjaxPages/AjaxCommunityChat.php?action=clear&communityId=${communityId}`,
                    success: () => {
                        showNotification("Chat cleared");
                        loadMessages();
                    },
                    complete: () => document.getElementById("loader").style.display = "none"
                });
            }
            toggleOptions();
        }

        function loadMessages() {
            const communityId = document.getElementById("communityId").value;
            const chatBody = document.getElementById("chatBody");
            const oldScrollHeight = chatBody.scrollHeight;

            const isScrolledToBottom = chatBody.scrollHeight - chatBody.scrollTop <= chatBody.clientHeight + 5;

            $.ajax({
                url: `../Assets/AjaxPages/AjaxChatLoadCommunity.php?communityId=${communityId}`,
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

        function openProfile() {
            document.getElementById("profile").style.display = "flex";
        }

        function closeProfile() {
            document.getElementById("profile").style.display = "none";
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