<?php
if (isset($_POST['friendUsername']) && isset($_COOKIE['username'])) {
    include("../checkLogin.php");
    include("../../database.php");
    $username = $_COOKIE["username"];
    $friendUsername = $_POST['friendUsername'];
    include(__DIR__ . "/doesUserExist.php");
    if (!DoesUsernameExist($friendUsername, $conn)) {
        echo "Username does not exist";
    }
    else
    {
        include_once(__DIR__ . "/getUserid.php");
        $userId = GetUserIdFromName($username, $conn);
        $friendId = GetUserIdFromName($friendUsername, $conn);
        include_once(__DIR__ . "/getFriendsId.php");
        if($userId == $friendId) {
            echo "You can't be your friend";
        }
        else if(FriendsId($userId, $friendId, $conn) == -1) {
            $stmt = $conn->prepare("INSERT INTO friends
                                        (friendId1, friendId2)
                                        VALUES (?, ?)");
            $stmt->bind_param("ii", $userId, $friendId);
            $stmt->execute();
            $stmt->close();
        }
        else
        {
            echo "User is already your friend";
        }
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
