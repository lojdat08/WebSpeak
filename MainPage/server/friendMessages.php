<?php
if (isset($_GET['friendId']) && isset($_COOKIE['username'])) {
    $friendId = $_GET['friendId'];
    $username = $_COOKIE['username'];
    include(__DIR__ . "/../checkLogin.php");
    include(__DIR__ . "/../lib/getFriendsId.php");
    include(__DIR__ . "/../../database.php");
    include_once(__DIR__ . "/../lib/getUserId.php");
    $userId = GetUserIdFromName($username, $conn);
    $friendsId = FriendsId($userId, $friendId, $conn);
    if($friendsId == -1) return;
    try {
        $stmt = $conn->prepare("SELECT *
                            FROM friendmessages
                            WHERE friendsId = ?
                            ORDER BY createDate ASC");
        $stmt->bind_param("i", $friendsId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Error when trying get room messages";
    }
    if (mysqli_num_rows($result) > 0) {
        include_once(__DIR__ . "/../lib/getUsername.php");
        while ($row = mysqli_fetch_assoc($result)) {
            $authorId = $row["authorId"];
            $message = $row["message"];
            $createDate = $row["createDate"];
            $authorUsername = GetUsernameFromId($authorId, $conn);
            echo "<p>Author: $authorUsername - $message - [$createDate]</p>\n";
        }
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
