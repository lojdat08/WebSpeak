<?php
if (isset($_POST['friendId']) && isset($_COOKIE['username'])) {
    include("../checkLogin.php");
    include("../../database.php");
    $username = $_COOKIE["username"];
    $friendId = $_POST['friendId'];
    include_once(__DIR__ . "/getUserid.php");
    $userId = GetUserIdFromName($username, $conn);
    include_once(__DIR__ . "/getFriendsId.php");
    $friendsId = FriendsId($userId, $friendId, $conn);
    if ($friendsId != -1) {
        $stmt = $conn->prepare("DELETE FROM friends
                                        WHERE id = ?");
        $stmt->bind_param("i", $friendsId);
        $stmt->execute();
        $stmt->close();
        include_once(__DIR__ . "/getConfig.php");
        if ($config["remove_messages_after_friend_removal"]) // remove messages after friend removal
        {
            $stmt = $conn->prepare("DELETE FROM friendmessages
                                            WHERE friendsId = ?");
            $stmt->bind_param("i", $friendsId);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        echo "You are not friends with this user";
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
