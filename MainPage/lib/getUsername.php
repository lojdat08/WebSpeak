<?php
function GetUsernameFromId($userId, $conn): string
{
    try {
        $stmt = $conn->prepare("SELECT * 
                            FROM users
                            WHERE id = ?"); // get user from id
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Couldn't log in.";
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (isset($row["user"])) {
            $username = $row["user"];
            return $username;
        }
    }
    return "";
}
