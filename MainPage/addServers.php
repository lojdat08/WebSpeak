<?php
include("../database.php");
try {
    $stmt = $conn->prepare("SELECT * 
                            FROM users 
                            WHERE user = ?"); // get userId
    $stmt->bind_param("s", $_COOKIE["username"]);
    $stmt->execute();
    $usernameResult = $stmt->get_result();
    $stmt->close();
} catch (mysqli_sql_exception) {
    echo "Error when trying to log out";
}
if (mysqli_num_rows($usernameResult) > 0) {
    $userId = mysqli_fetch_assoc($usernameResult)["id"];
    try {
        $stmt = $conn->prepare("SELECT * 
                            FROM usersinserver
                            WHERE userid = ?"); // get serverId's from userId
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $serverIdResult = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Error when trying add servers";
    }
    if (mysqli_num_rows($serverIdResult) > 0) {
        while ($serverIdRow = mysqli_fetch_assoc($serverIdResult)) {
            try {
                $stmt = $conn->prepare("SELECT * 
                            FROM servers
                            WHERE id = ?"); // get server from serverId
                $stmt->bind_param("i", $serverIdRow["serverId"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
            } catch (mysqli_sql_exception) {
                echo "Error when trying add servers";
            }
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $imgSrc = $row["img"];
                $serverId = $serverIdRow["serverId"];
                $serverName = $row["serverName"];
                echo "<a href = 'index.php?serverId=" . $serverId . "'>";
                echo "<img class='serverButton' src='$imgSrc' alt='$serverName'>";
                echo "</a>\n";
            }
        }
    }
}
if ($conn) {
    mysqli_close($conn);
}
