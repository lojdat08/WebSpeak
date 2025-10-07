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
        <input type="text" name="username"><br>
        Password: <br>
        <input type="password" name="password"><br><br>
        <input type="submit" name="submit" value="Login">
    </form>
</body>

</html>
<?php
include("randomValues.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (empty($username) || empty($password)) {
        echo "Name or password is empty";
    } else {
        $sql = "SELECT * FROM users WHERE user = '$username'";
        try {
            $result = mysqli_query($conn, $sql);
        } catch (mysqli_sql_exception) {
            echo "Couldn't log in.";
        }

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row["user"] == $username) {
                if (password_verify($password, $row["password"])) {
                    $token = RandomString(60);
                    try {
                        $stmt = $conn->prepare("UPDATE users
                                            SET token = ?, loginDate = NOW()
                                            WHERE user = ?");
                        $stmt->bind_param("ss", $token, $username);
                        $stmt->execute();
                        $stmt->close();
                        $expireTime = time() + (60 * 15);
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
if($conn)
{
    mysqli_close($conn);
}
?>