<?php
if (isset($_POST['addUsername']) && isset($_POST['serverId']) && isset($_COOKIE['username'])) {
    include("../checkLogin.php");
    include("../../database.php");
    $username = $_COOKIE["username"];
    $addUsername = $_POST['addUsername'];
    $serverId = $_POST['serverId'];
    include(__DIR__ . "/doesUserExist.php");
    include(__DIR__ . "/checkPermisions.php");
    if (!DoesUsernameExist($addUsername, $conn)) {
        echo "Username does not exist";
    } else if (CheckUserInServerName($username, $serverId, $conn)) {
        if (!CheckUserInServerName($addUsername, $serverId, $conn)) {
            include_once(__DIR__ . "/getUserid.php");
            $addUserId = GetUserIdFromName($addUsername, $conn);
            $stmt = $conn->prepare("INSERT INTO usersinserver
                                        (serverId, userId)
                                        VALUES (?, ?)");
            $stmt->bind_param("ii", $serverId, $addUserId);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "User is already in server";
        }
    } else {
        echo "User is not in server";
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
