<?php
if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && $_COOKIE["username"] && $_COOKIE["token"]) {
    include("../checkLogin.php");
    include("../../database.php");
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $username = $_COOKIE["username"];
    $token = $_COOKIE["token"];
    try {
        $stmt = $conn->prepare("SELECT * 
                            FROM users
                            WHERE user = ?"); // get user from username
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Error getting user data.";
    }
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($oldPassword, $row["password"])) {
            include(__DIR__ . "/randomValues.php");
            $token = RandomString(60);
            $cleanToken = htmlspecialchars($token);
            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users
                                            SET password = ?, token = ?
                                            WHERE user = ?");
            $stmt->bind_param("sss", $hash, $token, $username);
            $stmt->execute();
            $stmt->close();
            include(__DIR__ . "/getConfig.php");
            $expireTime = time() + $config["cookies_expire"];
            setcookie("token", $token, $expireTime, "/");
            echo "Password changed successfully.";
        } else {
            echo "Old password is incorrect.";
        }
    }
    else {
        echo "User not found.";
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
