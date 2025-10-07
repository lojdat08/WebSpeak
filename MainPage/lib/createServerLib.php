<?php
if (isset($_POST['serverName']) && isset($_POST['serverImg'])) {
    $serverName = $_POST['serverName'];
    $serverImg = $_POST['serverImg'];
    $username = $_COOKIE["username"];
    include("../../database.php");
    include("getUserid.php");
    $userId = GetUserIdFromName($username, $conn);
    try {
        $stmt = $conn->prepare("INSERT INTO `servers`
                                (`serverName`, `img`)
                                VALUES (?, ?)"); // create new server
        $stmt->bind_param("ss", $serverName, $serverImg);
        $stmt->execute();
        $serverId = $conn->insert_id;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO `usersinserver`
                                (`userId`, `serverId`)
                                VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $serverId);
        $stmt->execute();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Coudn't create server";
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
