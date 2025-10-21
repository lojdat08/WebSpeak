<?php
if (isset($_GET['serverId']) && isset($_COOKIE['username'])) {
    $serverId = $_GET['serverId'];
    $username = $_COOKIE['username'];
    include("../database.php");
    include_once("lib/checkPermisions.php");
    $userInServer = CheckUserInServerName($username, $serverId, $conn);
    if (!$userInServer) {
        GoToIndex();
        if ($conn) {
            mysqli_close($conn);
        }
        return;
    }
    $serverName = GetServerName($serverId, $conn);
    echo "<h4>$serverName</h4>";
    echo "<a href='createRoom.php?serverId=$serverId'>Create room</a><br><br>";
    try {
        $stmt = $conn->prepare("SELECT * 
                            FROM serverrooms
                            WHERE serverid = ?"); // get rooms from serverId
        $stmt->bind_param("i", $serverId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Error when trying check servers";
    }
    if (mysqli_num_rows($result) > 0) {
        while ($roomRow = mysqli_fetch_assoc($result)) {
            $roomName = $roomRow["roomName"];
            $roomId = $roomRow["roomId"];
            $roomImage = GetRoomImage($roomRow["roomType"]);
            echo "<div class=\"room\" onclick=\"ChangeRoom('$roomId')\">";
            echo "<img class=\"roomImage\" src=\"$roomImage\">";
            echo "<span class=\"roomText\">$roomName</span><br>";
            echo "</div>";
        }
    }
    if ($conn) {
        mysqli_close($conn);
    }
}

function GetServerName(int $serverId, $conn): string
{
    try {
        $stmt = $conn->prepare("SELECT * 
                            FROM servers
                            WHERE id = ?"); // get server from serverId
        $stmt->bind_param("i", $serverId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Error when trying check servers";
    }
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $serverName = $row['serverName'];
        return $serverName;
    }
    if ($conn) {
        mysqli_close($conn);
    }
    return '';
}

function GetRoomImage($roomType)
{
    switch ($roomType) {
        case "normal": {
                return "roomImages/normalRoom.png";
            }
            break;
        case "voice": {
                return "roomImages/voiceRoom.png";
            }
            break;
    }
    return "roomImages/emptyRoom.png";
}
