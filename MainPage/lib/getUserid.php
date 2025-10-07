<?php
function GetUserIdFromName($username, $conn): int
{
    try {
        $stmt = $conn->prepare("SELECT * 
                            FROM users
                            WHERE user = ?"); // get user from id
        $stmt->bind_param("i", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Couldn't log in.";
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (isset($row["id"])) {
            $userId = $row["id"];
            return $userId;
        }
    }
    return -1;
}
