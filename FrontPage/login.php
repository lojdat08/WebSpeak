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
    <style>
        /* DARK THEME COLORS */
        :root {
            --bg: #1b1b1b;
            --surface: #292929;
            --accent: #fea319;
            --text: #ffffff;
            --muted: #808080;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        a button {
            background-color: var(--accent);
            color: #1b1b1b;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 1rem;
            font-weight: bold;
            transition: 0.2s ease;
        }

        a button:hover {
            background-color: #ffb93f;
        }

        .login-box {
            background-color: var(--surface);
            padding: 2.5rem 3rem;
            border-radius: 14px;
            width: 90%;
            max-width: 420px;
            box-shadow: 0 0 18px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 1.8rem;
            color: var(--text);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            margin-top: 0.4rem;
            margin-bottom: 1rem;
            background-color: #1f1f1f;
            border: 1px solid #333;
            border-radius: 8px;
            color: var(--text);
            font-size: 1rem;
            outline: none;
            transition: 0.2s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: var(--accent);
            box-shadow: 0 0 6px rgba(254, 163, 25, 0.4);
        }

        label {
            display: block;
            text-align: left;
            font-size: 0.95rem;
            color: var(--muted);
            margin-bottom: 0.2rem;
        }

        input[type="submit"] {
            width: 100%;
            padding: 0.9rem;
            background-color: var(--accent);
            border: none;
            border-radius: 8px;
            color: #1b1b1b;
            font-weight: bold;
            cursor: pointer;
            font-size: 1.05rem;
            transition: 0.2s ease;
        }

        input[type="submit"]:hover {
            background-color: #ffb93f;
        }
    </style>
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