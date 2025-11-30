<?php
function DoesUsernameExist(string $username, $conn): bool
{
    try {
        $stmt = $conn->prepare("SELECT * 
                            FROM users
                            WHERE user = ?"); // get user from id
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Couldn't log in.";
    }
    return mysqli_num_rows($result) > 0;
}

function DoesUserIdExist(int $userId, $conn): bool
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
    return mysqli_num_rows($result) > 0;
}