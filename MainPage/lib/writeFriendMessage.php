<?php
if (isset($_POST['message']) && isset($_POST['friendId']) && isset($_COOKIE["username"])) {
    include(__DIR__ . "/../checkLogin.php");
    $msg = $_POST['message'];
    $friendId = $_POST['friendId'];
    $username = $_COOKIE["username"];
    include("../../database.php");
    include_once(__DIR__ . "/getUserid.php");
    include_once(__DIR__ . "/checkPermisions.php");
    $userId = GetUserIdFromName($username, $conn);
    try {
        include(__DIR__ . "/getFriendsId.php");
        $friendsId = FriendsId($userId, $friendId, $conn);
        if($friendsId == -1) return;
        $stmt = $conn->prepare("INSERT INTO `friendmessages`
                                (`friendsId`, `authorId`, `message`)
                                VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $friendsId, $userId, $msg);
        $stmt->execute();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Coudn't set message";
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
