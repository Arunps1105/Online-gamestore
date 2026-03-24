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
            --primary-color: #7289da;
            --secondary-color: #2c2f33;
            --dark-color: #23272a;
            --darker-color: #1e2124;
            --text-color: #ffffff;
            --accent-color: #00ff88;
            --danger-color: #ff4655;
        }

        body {
            background: url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            background: rgba(30, 33, 36, 0.85);
            z-index: -1;
        }

        .chat-container {
            width: 100%;
            max-width: 900px;
            background: rgba(35, 39, 42, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 90vh;
            position: relative;
            border: 2px solid var(--primary-color);
            backdrop-filter: blur(5px);
        }

        .chat-header {
            background: linear-gradient(90deg, var(--darker-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 2px solid var(--primary-color);
        }

        .chat-header .back-btn {
            background: none;
            border: none;
            color: var(--text-color);
            font-size: 18px;
            cursor: pointer;
            transition: transform 0.3s;
            padding: 5px;
            border-radius: 50%;
        }

        .chat-header .back-btn:hover {
            transform: translateX(-3px);
            color: var(--accent-color);
        }

        .chat-header img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent-color);
            transition: transform 0.3s;
            cursor: pointer;
        }

        .chat-header img:hover {
            transform: scale(1.1);
        }

        .chat-header .community-info {
            flex: 1;
        }

        .chat-header .community-info h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 0.5px;
        }

        .chat-header .options {
            cursor: pointer;
            font-size: 20px;
            color: var(--text-color);
            transition: transform 0.3s, color 0.3s;
            padding: 5px;
            border-radius: 50%;
        }

        .chat-header .options:hover {
            transform: rotate(90deg);
            color: var(--accent-color);
            background: rgba(255, 255, 255, 0.1);
        }

        .chat-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            background: rgba(35, 39, 42, 0.7);
        }

        .chat-body::-webkit-scrollbar {
            width: 8px;
        }

        .chat-body::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        .chat-body::-webkit-scrollbar-track {
            background: var(--darker-color);
        }

        .message {
            max-width: 70%;
            padding: 12px 15px;
            border-radius: 12px;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }

        .message:hover {
            transform: translateY(-2px);
        }

        .message.sent {
            background: linear-gradient(135deg, var(--primary-color) 0%, #5b6ee1 100%);
            align-self: flex-end;
            margin-left: auto;
            border-bottom-right-radius: 4px;
            color: white;
        }

        .message.received {
            background: var(--secondary-color);
            align-self: flex-start;
            border-bottom-left-radius: 4px;
            color: var(--text-color);
        }

        .sender-info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .sender-photo {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent-color);
        }

        .sender-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--accent-color);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .message-content {
            word-break: break-word;
            font-size: 15px;
            line-height: 1.5;
        }

        .message-time {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.7);
            align-self: flex-end;
            margin-top: 4px;
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
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .message:hover .delete-btn {
            display: flex;
        }

        .message .delete-btn:hover {
            background: rgba(255, 70, 85, 0.3);
            transform: scale(1.1);
        }

        .file-preview {
            margin-top: 8px;
            max-width: 250px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .file-preview img {
            max-width: 100%;
            border-radius: 8px;
            transition: transform 0.3s;
        }

        .file-preview img:hover {
            transform: scale(1.03);
        }

        .date-divider {
            text-align: center;
            color: var(--accent-color);
            font-size: 13px;
            margin: 20px 0;
            background: rgba(30, 33, 36, 0.7);
            padding: 5px 15px;
            border-radius: 20px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid var(--accent-color);
        }

        .chat-footer {
            padding: 15px 20px;
            background: var(--darker-color);
            display: flex;
            align-items: center;
            gap: 15px;
            border-top: 1px solid var(--secondary-color);
        }

        .message-input {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            background: var(--secondary-color);
            font-size: 15px;
            outline: none;
            color: var(--text-color);
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
        }

        .message-input:focus {
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.3), 0 0 0 2px var(--accent-color);
        }

        .message-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .send-btn, .attach-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 22px;
            color: var(--primary-color);
            transition: all 0.3s;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .send-btn:hover, .attach-btn:hover {
            background: rgba(114, 137, 218, 0.2);
            color: var(--accent-color);
            transform: scale(1.1);
        }

        .send-btn:disabled {
            opacity: 0.5;
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
            background: var(--darker-color);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            position: relative;
            border: 2px solid var(--accent-color);
            max-width: 80%;
        }

        .profile-content img {
            width: 250px;
            height: 250px;
            border-radius: 10px;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .close-profile {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 28px;
            cursor: pointer;
            color: var(--danger-color);
            transition: transform 0.3s;
        }

        .close-profile:hover {
            transform: rotate(90deg);
        }

        .options-menu {
            display: none;
            position: absolute;
            right: 20px;
            top: 70px;
            background: var(--darker-color);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 100;
            border: 1px solid var(--primary-color);
            overflow: hidden;
            min-width: 200px;
        }

        .options-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: var(--text-color);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
            border-bottom: 1px solid var(--secondary-color);
        }

        .options-menu a:last-child {
            border-bottom: none;
        }

        .options-menu a:hover {
            background: var(--primary-color);
            color: white;
            padding-left: 25px;
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
            background: rgba(30, 33, 36, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(3px);
        }

        .loader::after {
            content: '';
            width: 50px;
            height: 50px;
            border: 5px solid var(--primary-color);
            border-top-color: var(--accent-color);
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
            background: var(--primary-color);
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transform: translateX(200%);
            transition: transform 0.4s ease-out;
            z-index: 1000;
            border-left: 4px solid var(--accent-color);
        }

        .notification.show {
            transform: translateX(0);
        }

        @media (max-width: 600px) {
            .chat-container {
                height: 100vh;
                border-radius: 0;
            }

            .message {
                max-width: 85%;
            }

            .profile-content img {
                width: 200px;
                height: 200px;
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
            <a href="#" onclick="clearChat()"><i class="fas fa-broom"></i> Clear Chat</a>
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

    <div id="notification" class="notification">Message sent successfully!</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let isSending = false;
        let isInitialLoad = true;

        function goToDashboard() {
            window.location.href = "Homepage.php"; // Change to your dashboard URL
        }

        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
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