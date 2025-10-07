<?php
include("checkLogin.php");
?>
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
                    <a href="index.php">
                        <p class="headerButton"> Zpátka
                    </a>
                </div>
            </div>
        </header>
        <div class="main">
            <div class="servers">
            </div>
            <div class="left">
            </div>
            <div class="center">
                <h1>Create server</h1>
                <form class="createServer" id="createServerForm">
                    <label for="serverName">Server name:</label><br>
                    <input type="text" class="createServerText" id="createServerText" placeholder="Server name" autocomplete="off"><br>
                    <label for="serverImage">Server image path: (serverImages/logo.png nebo serverImages/logo2.png)</label><br>
                    <input type="text" class="createServerText" id="createServerImage" placeholder="Server image path" autocomplete="off"><br>
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
<script src="lib/createServer.js"></script>;