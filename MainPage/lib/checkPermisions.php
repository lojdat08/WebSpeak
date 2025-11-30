<?php
function CheckUserInServerName(string $username, int $serverId, $conn): bool
{
    if (isset($conn) && isset($serverId) && isset($username)) {
        include_once("getUserid.php");
        $userId = GetUserIdFromName($username, $conn);
        return CheckUserInServer($userId, $serverId, $conn);
    }
    return false;
}

function CheckUserInServer(int $userId, int $serverId, $conn): bool
{
    if (isset($conn) && isset($serverId) && isset($userId)) {
        try {
            $stmt = $conn->prepare("SELECT * 
                            FROM usersinserver
                            WHERE userId = ? AND serverId = ?");
            $stmt->bind_param("ii", $userId, $serverId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        } catch (mysqli_sql_exception) {
            echo "Error when trying check permisions";
        }
        if (isset($result)) {
            if (mysqli_num_rows($result) > 0) {
                return true;
            }
        }
    }
    return false;
}

function GetServerIdFromRoomId($roomId, $conn): int
{
    return -1;
}

function GoToIndex()
{
    header("Location: index.php");
}