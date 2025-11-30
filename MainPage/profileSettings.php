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
                <h2>Nastavení profilu</h2>
                <form class="profileImageForm" id="profileImageForm">
                    <label for="newProfileImage">Profile image:<br>
                        <input type="file" class="newProfileImage" id="newProfileImage" placeholder="Profile image" name="newProfileImage" accept=".jpeg, .png, .gif" autocomplete="off" required data-max-size="10000000"><br><br>
                        <button type="submit">Save</button>
                </form><br><br><br>
                <form class="changeUsernameForm" id="changeUsernameForm">
                    <label for="newUsername">New username:<br>
                        <input type="text" class="newUsername" id="newUsername" placeholder="New username" name="newUsername" autocomplete="off" required><br><br>
                        <button type="submit">Update</button>
                </form><br><br><br>
                <form class="changePasswordForm" id="changePasswordForm">
                    <label for="oldPassword">Old password:<br>
                        <input type="password" class="newPassword" id="oldPassword" placeholder="Old password" name="oldPassword" autocomplete="off" required><br>
                        <input type="password" class="newPassword" id="newPassword" placeholder="New password" name="newPassword" autocomplete="off" required><br>
                        <input type="password" class="newPassword" id="newPasswordAgain" placeholder="New password again" name="newPasswordAgain" autocomplete="off" required><br><br>
                        <button type="submit">Update</button>
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
<script src="lib/setProfileImage.js"></script>
<script src="lib/changeUsername.js"></script>
<script src="lib/changePassword.js"></script>