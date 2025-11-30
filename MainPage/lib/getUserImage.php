<?php
function GetUserImagePath($user): string
{
    include("../database.php");
    switch (gettype($user)) {
        case "string":
            include("lib/getUserId.php");
            $userId = GetUserIdFromName($user, $conn);
            break;
        case "integer":
            $userId = $user;
            break;
    }
    if (isset($userId)) {
        try {
            $stmt = $conn->prepare("SELECT * 
                            FROM users
                            WHERE id = ?"); // get user from id
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        } catch (mysqli_sql_exception) {
            echo "Error when trying get room messages";
        }
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $userImgPath = $row["userImg"];
        }
    }
    if ($conn) {
        mysqli_close($conn);
    }
    return isset($userImgPath) ? $userImgPath : __DIR__ . "/../../../profiles/0.png";
}
