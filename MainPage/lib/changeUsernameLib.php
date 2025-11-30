<?php
if (isset($_POST['newUsername']) && isset($_COOKIE['username'])) {
    include("../checkLogin.php");
    include("../../database.php");
    $username = $_COOKIE["username"];
    $newUsername = $_POST['newUsername'];
    try {
        $stmt = $conn->prepare("SELECT * 
                            FROM users
                            WHERE user = ?");
        $stmt->bind_param("s", $newUsername);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Error when trying check username";
    }
    if (mysqli_num_rows($result) <= 0) {
        try {
            $stmt = $conn->prepare("UPDATE users
                                SET user = ?
                                WHERE user = ?"); // create new server
            $stmt->bind_param("ss", $newUsername, $username);
            $stmt->execute();
            $stmt->close();
            include(__DIR__ . "\getConfig.php");
            $expireTime = time() + $config["cookies_expire"];
            setcookie("username", $newUsername, $expireTime, "/");
        } catch (mysqli_sql_exception) {
            echo "Couldn't change username";
        }
    } else {
        echo "Username is taken";
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
