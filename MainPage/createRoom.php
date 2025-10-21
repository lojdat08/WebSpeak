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
                <div class="buttons">
                    <form action="logout.php" method="post">
                        <button type="submit" class="headerButton" name="logout">Odhlásit se</button>
                    </form>
                </div>
            </div>
        </header>
        <div class="main">
            <div class="servers">
                <h4>servers</h4>
                <?php
                include("addServers.php");
                ?>
                <a href="createServer.php">
                    <img class="serverButton">
                </a>
            </div>
            <div class="left">
            </div>
            <div class="center">
                <h1>Create room</h1>
                <form class="createRoom" id="createRoomForm">
                    <label for="roomName">Server room:</label><br><br>
                    <input type="text" class="createRoomText" id="createRoomText" placeholder="Room name" autocomplete="off" minlength="3"><br><br>
                    <label for="roomType">Room type:</label><br><br>
                    <select class="createRoomType" id="createRoomType">
                        <option value="normal">Normal</option>
                        <option value="voice">Voice</option>
                    </select><br><br>
                    <button type="submit">Send</button>
                </form>
            </div>
            <div class="right">
                <h3>users</h3>
            </div>
        </div>
        <footer>
            <div class="footerContent">
                <p>text</p>
            </div>
        </footer>
    </div>
</body>

</html>
<script src="lib/createRoom.js"></script>;