<?php
if (isset($_GET['roomId']) && isset($_GET['serverId'])) {
    $roomId = $_GET['roomId'];
    $serverId = $_GET['serverId'];
    include("../database.php");
    try {
        $stmt = $conn->prepare("SELECT * 
                            FROM roommessages
                            WHERE roomId = ?
                            ORDER BY createDate DESC"); // get rooms from serverId
        $stmt->bind_param("s", $roomId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Error when trying get room messages";
    }
    if (mysqli_num_rows($result) > 0) {
        include_once("lib/checkPermisions.php");
        $username = $_COOKIE['username'];
        if (CheckUserInServerName($username, $serverId, $conn)) {
            include_once("lib/getUsername.php");
            while ($row = mysqli_fetch_assoc($result)) {
                $authorId = $row["authorId"];
                $message = $row["message"];
                $createDate = $row["createDate"];
                $authorUsername = GetUsernameFromId($authorId, $conn);
                echo "<p>Author: $authorUsername - $message - [$createDate]</p>\n";
            }
        }
        else
        {
            header("Location: index.php");
        }
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
