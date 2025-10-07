<?php
include("../database.php");
if(empty($_COOKIE["username"]))
{
    setcookie("username", "", time() - 1, "/");
    setcookie("token", "", time() - 1, "/");
    header("Location: ../FrontPage/");
    mysqli_close($conn);
    return;
}
try {
    $stmt = $conn->prepare("SELECT * 
                            FROM users 
                            WHERE user = ?");
    $stmt->bind_param("s", $_COOKIE["username"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} catch (mysqli_sql_exception) {
    echo "Error when trying to log out";
}
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    if ($_COOKIE["token"] == $row["token"]) {
        try {
            $stmt = $conn->prepare("UPDATE users
                                SET token = ''
                                WHERE user = ?");
            $stmt->bind_param("s", $_COOKIE["username"]);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception) {
            echo "Error when trying to log out";
        }
    }
}
setcookie("username", "", time() - 1, "/");
setcookie("token", "", time() - 1, "/");
header("Location: ../FrontPage/");
mysqli_close($conn);
?>