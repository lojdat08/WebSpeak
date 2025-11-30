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
            </div>
            <div class="center">
                <h1>Create server</h1>
                <form action="lib/createRoomLib.php" class="createServer" id="createServerForm" enctype="multipart/form-data" method="post">
                    <label for="serverName">Server name:</label><br>
                    <input type="text" class="createServerText" id="createServerText" placeholder="Server name" name="serverName" autocomplete="off"><br><br>
                    <label for="serverImage">Server image:<br>
                    <input type="file" class="createServerText" id="createServerImage" placeholder="Server image" name="serverImage" accept=".jpeg, .png, .gif" autocomplete="off" required><br><br>
                    <button type="submit">Send</button>
                </form>
            </div>
            <div class="right">
                <h3></h3>
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
<script src="lib/createServer.js"></script>;