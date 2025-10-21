<?php

if (isset($_POST['roomName']) && isset($_POST['roomType']) && isset($_POST['serverId'])) {
    $roomName = htmlspecialchars($_POST['roomName']);
    $roomType = htmlspecialchars($_POST['roomType']);
    $serverId = htmlspecialchars($_POST['serverId']);
    include("../../database.php");
    try {
        $stmt = $conn->prepare("INSERT INTO `serverrooms`
                                (`serverId`, `roomType`, `roomName`)
                                VALUES (?, ?, ?)"); // create new room
        $stmt->bind_param("sss", $serverId, $roomType, $roomName);
        $stmt->execute();
        $roomId = $conn->insert_id;
        $stmt->close();
        echo "serverId=$serverId&roomId=$roomId";
    } catch (mysqli_sql_exception) {
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
