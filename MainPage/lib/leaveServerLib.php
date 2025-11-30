<?php
if (isset($_POST['leaveServerId']) && isset($_COOKIE['username'])) {
    include("../checkLogin.php");
    include("../../database.php");
    $username = $_COOKIE["username"];
    $leaveServerId = $_POST['leaveServerId'];
    include_once(__DIR__ . "/getUserid.php");
    $userId = GetUserIdFromName($username, $conn);
    if ($userId != -1) {
        include_once(__DIR__ . "/checkPermisions.php");
        if (CheckUserInServer($userId, $leaveServerId, $conn)) {
            $stmt = $conn->prepare("DELETE FROM usersinserver
                                WHERE (serverId = ? AND userId = ?)");
            $stmt->bind_param("ii", $leaveServerId, $userId);
            $stmt->execute();
            $stmt->close();
        }
        else
        {
            echo "You are not in this server.";
        }
    } else {
        echo "Can't get your user info.";
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
