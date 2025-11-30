<?php
if (isset($_COOKIE["username"])) {
    include(__DIR__ . "/../checkLogin.php");
    include(__DIR__ . "/../../database.php");
    include_once(__DIR__ . "/../lib/getUserid.php");
    $username = $_COOKIE["username"];
    $userId = GetUserIdFromName($username, $conn);
    $friendsResult = GetFriends($userId, $conn);
    while ($friendRow = mysqli_fetch_assoc($friendsResult)) {
        $friendId = GetIdFromRow($userId, $friendRow["friendId1"], $friendRow["friendId2"]);
        $friendRow = GetUser($friendId, $conn);
        $friendImgPath = $friendRow["userImg"];
        $friendUsername = $friendRow["user"];
        echo "<div class=\"userDiv\" onclick=\"ChangeFriend('$friendId')\" style=\"cursor: pointer;\">";
        echo "<img class=\"userProfileImg\" src=\"$friendImgPath\"/>";
        echo "<b class=\"userName\">$friendUsername</b>";
        echo "</div>";
    }
    if ($conn) {
        mysqli_close($conn);
    }
}

function GetFriends(int $userId, $conn)
{
    try {
        $stmt = $conn->prepare("SELECT friendId1, friendId2 
                            FROM friends
                            WHERE friendId1 = ? OR friendId2 = ?"); // get friend
        $stmt->bind_param("ii", $userId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Error when trying check servers";
    }
    if(empty($result)){
        return null;
    }
    return $result;
}

function GetIdFromRow(int $authorId, int $friend1, int $friend2): int
{
    if ($authorId == $friend1) {
        return $friend2;
    } else {
        return $friend1;
    }
}

function GetUser(int $userId, $conn)
{
    try {
        $stmt = $conn->prepare("SELECT * 
                            FROM users
                            WHERE id = ?"); // get user from serverId
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Error when trying check servers";
    }
    return mysqli_fetch_assoc($result);
}
