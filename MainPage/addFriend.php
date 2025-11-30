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
                <h4>Friends</h4>
                <?php
                include("server/friends.php");
                include("addFriendButton.html");
                ?>
            </div>
            <div class="center">
                <h1>Add friend</h1>
                <form class="addFriendForm" id="addFriendForm">
                    <label for="friend Username:">Friend Username:</label><br>
                    <input type="text" class="friendUsername" id="friendUsername" placeholder="Friend Username" name="friendUsername" autocomplete="off"><br><br>
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
<script src="server/changeFriends.js"></script>
<script src="lib/addFriend.js"></script>;