<?php
if (isset($_GET['serverId'])) {
    $serverId = $_GET['serverId'];
    include("../database.php");
    include_once("lib/checkPermisions.php");
    $userInServer = CheckUserInServerName($username, $serverId, $conn);
    if ($userInServer) {
        try {
            $stmt = $conn->prepare("SELECT * 
                            FROM usersinserver
                            WHERE serverid = ?"); // get server users id's from serverId
            $stmt->bind_param("i", $serverId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        } catch (mysqli_sql_exception) {
            echo "Error when trying check servers";
        }
        if (mysqli_num_rows($result) > 0) {
            while ($userRow = mysqli_fetch_assoc($result)) {
                $user = GetUser($userRow["userId"]);
                $username = $user["user"];
                $userImgPath = $user["userImg"];
                echo "<div class=\"userDiv\">";
                echo "<img class=\"userProfileImg\" src=\"$userImgPath\"/>";
                echo "<b class=\"userName\">$username</b>";
                echo "</div>";
            }
        }
    }
    if ($conn) {
        mysqli_close($conn);
    }
}

function GetUser(int $userId)
{
    include("../database.php");
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
    } finally {
        if ($conn) {
            mysqli_close($conn);
        }
    }
    return mysqli_fetch_assoc($result);
}