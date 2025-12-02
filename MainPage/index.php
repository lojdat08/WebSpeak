<?php
include("checkLogin.php");
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WebSpeak</title>
    <link rel="stylesheet" href="index.css" type="text/css" />
    <link rel="icon" type="image/png" href="../logo.png">
</head>

<body>
    <div class="page-wrapper">
        <header>
            <div class="header-content">
                <?php
                include("profileSettingsButton.php");
                ?>
                <div class="buttons">
                    <form action="logout.php" method="post">
                        <button type="submit" class="headerButton" name="logout">Odhlásit se</button>
                    </form>
                </div>
            </div>
        </header>
        <div class="main">
            <div class="servers">
                <?php
                include("friendsIndexButton.html");
                ?>
                <h4>servers</h4>
                <?php
                include("addServers.php");
                include("createServerButton.html");
                ?>
            </div>
            <div class="left">
                <h4>Rooms</h4>
                <?php
                include("server/rooms.php");
                ?>
            </div>
            <div class="center">
                <h1>Messages</h1>
                <div class="messages">
                    <?php
                    include("server/roomMessages.php");
                    ?>
                </div>
                <form class="writeMessage" id="sendMessageForm">
                    <input type="text" id="textMessageForm" placeholder="Type your message..." autocomplete="off" />
                    <button type="submit">Send</button>
                </form>
            </div>
            <div class="right">
                <br>
                <button id="leaveServerButton">Leave server</button>
                <h3>users</h3>
                <?php
                include("server/users.php");
                include("addServerUserButton.html");
                ?>
            </div>
        </div>
    </div>
</body>

</html>
<script src="server/leaveServer.js?v=10"></script>
<script src="server/changeRooms.js"></script>
<script src="server/sendMessage.js"></script>
<script src="server/hideAddUser.js"></script>