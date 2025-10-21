<?php
if (isset($_POST['message']) && isset($_POST['roomId']) && isset($_POST['serverId'])) {
    $msg = $_POST['message'];
    $roomId = $_POST['roomId'];
    $serverId = $_POST['serverId'];
    $username = $_COOKIE["username"];
    include("../../database.php");
    include_once("getUserid.php");
    include_once("checkPermisions.php");
    $userId = GetUserIdFromName($username, $conn);
    if (CheckUserInServer($userId, $serverId, $conn)) {
        try {
            $stmt = $conn->prepare("INSERT INTO `roommessages`
                                (`roomId`, `authorId`, `message`)
                                VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $roomId, $userId, $msg);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception) {
            echo "Coudn't set message";
        }
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
