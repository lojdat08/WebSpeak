<?php
if (isset($_GET['roomId'])) {
    $roomId = $_GET['roomId'];
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
        include("lib/getUsername.php");
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
