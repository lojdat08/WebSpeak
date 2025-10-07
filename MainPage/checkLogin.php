<?php
if (empty($_COOKIE["username"]) || empty($_COOKIE["token"])) { // check existing cookies
    setcookie("username", "", time() - 1, "/");
    setcookie("token", "", time() - 1, "/");
    header("Location: ../FrontPage/");
    return;
}
include("../database.php");
try {
    $stmt = $conn->prepare("SELECT * 
                            FROM users 
                            WHERE user = ?"); // check database for user
    $stmt->bind_param("s", $_COOKIE["username"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} catch (mysqli_sql_exception) {
    echo "Error when trying to log out";
}
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($_COOKIE["token"] != $row["token"]) { // if cookie doesn't match then kick
        setcookie("username", "", time() - 1, "/");
        setcookie("token", "", time() - 1, "/");
        header("Location: ../FrontPage/");
    }
    else if((strtotime($row["loginDate"]) + (60 * 15)) < time()) // check last time login expire
    {
        setcookie("username", "", time() - 1, "/");
        setcookie("token", "", time() - 1, "/");
        header("Location: ../FrontPage/");
    }
}
mysqli_close($conn);
return;
?>