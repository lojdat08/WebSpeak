<?php
include("../database.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSpeak</title>
    <link rel="icon" type="image/png" href="logo.png">
</head>

<body>
    <br>
    <a href="index.php">
        <button>Zpátky</button>
    </a>
    <h1>Login</h1>
    <form action="login.php" method="post">
        Username: <br>
        <input type="text" name="username" autofocus><br>
        Password: <br>
        <input type="password" name="password"><br><br>
        <input type="submit" name="submit" value="Login">
    </form>
</body>

</html>
<?php
include("../MainPage/lib/randomValues.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (empty($username) || empty($password)) {
        echo "Name or password is empty";
    } else {
        try {
            $stmt = $conn->prepare("SELECT * 
                            FROM users
                            WHERE user = ?"); // get user from username
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        } catch (mysqli_sql_exception) {
            echo "Couldn't log in.";
        }
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row["user"] == $username) {
                if (password_verify($password, $row["password"])) {
                    $token = RandomString(60);
                    $cleanToken = htmlspecialchars($token);
                    $cleanUser  = htmlspecialchars($username);
                    $loginIP = "null (probably localhost)";
                    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                        $loginIP = $_SERVER["HTTP_CF_CONNECTING_IP"];
                    }
                    try {
                        $stmt = $conn->prepare("UPDATE users
                                            SET token = ?, loginDate = NOW(), loginIP = ?
                                            WHERE user = ?");
                        $stmt->bind_param("sss", $cleanToken, $loginIP, $cleanUser);
                        $stmt->execute();
                        $stmt->close();
                        include("../MainPage/lib/getConfig.php");
                        $expireTime = time() + $config["cookies_expire"];
                        setcookie("username", $username, $expireTime, "/");
                        setcookie("token", $token, $expireTime, "/");
                    } catch (mysqli_sql_exception) {
                        echo "Coudn't set token";
                    }
                    header("Location: ../MainPage/");
                } else {
                    echo "Wrong username or password.";
                }
            } else {
                echo "Wrong username or password.";
            }
        } else {
            echo "User with this name doesn't exist.";
        }
    }
}
if ($conn) {
    mysqli_close($conn);
}
?>