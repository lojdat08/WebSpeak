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
            <div class="center">
                <h2>Adding user</h2>
                <form class="addUserForm" id="addUserForm">
                    <label for="addUsername">username of new user:<br>
                        <input type="text" class="addUsername" id="addUsername" placeholder="Username" name="addUsername" autocomplete="off" required><br><br>
                        <button type="submit">Add</button>
                </form>
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
<script src="lib/addUserToServer.js"></script>