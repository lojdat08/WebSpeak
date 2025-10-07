<?php
if (isset($_GET['serverId'])) {
    $serverId = $_GET['serverId'];
}
if (isset($serverId)) {
    include("../database.php");
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

function GetRoomImage($roomType)
{
    return "../logo.png";
}
