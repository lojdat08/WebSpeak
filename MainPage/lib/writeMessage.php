<?php
if (isset($_POST['message']) && isset($_POST['roomId'])) {
    $msg = $_POST['message'];
    $roomId = $_POST['roomId'];
    $username = $_COOKIE["username"];
    include("../../database.php");
    include("getUserid.php");
    $userId = GetUserIdFromName($username, $conn);
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
    if ($conn) {
        mysqli_close($conn);
    }
}
