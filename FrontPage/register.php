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
body {
    margin: 0;
    padding: 0;
    font-family: sans-serif;
    background-color: #1b1b1b;
    color: #ffffff;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
}

.backButton {
    background-color: #292929;
    border: 1px solid #808080;
    color: #ffffff;
    padding: 0.6vw 1.2vw;
    border-radius: 0.6vw;
    font-size: 1.1vw;
    cursor: pointer;
    transition: 0.2s ease;
    margin-top: 2vw;
}

.backButton:hover {
    background-color: #323232;
}

h1 {
    margin-top: 1.5vw;
    font-size: 2.4vw;
    color: #ffffff;
    text-align: center;
}

form {
    background-color: #292929;
    padding: 2.2vw;
    border-radius: 1vw;
    display: flex;
    flex-direction: column;
    width: 22vw;
    margin-top: 1vw;
    box-shadow: 0 0 25px rgba(0,0,0,0.4);
}

form label,
form span,
form p {
    font-size: 1.2vw;
    color: #ffffff;
    margin-bottom: 0.4vw;
}

form input[type="text"],
form input[type="password"],
form input[type="email"] {
    width: 100%;
    padding: 0.6vw 0.7vw;
    margin-bottom: 1.2vw;
    border: 1px solid #444;
    border-radius: 0.6vw;
    background-color: #1b1b1b;
    color: #ffffff;
    font-size: 1.1vw;
    outline: none;
    transition: 0.2s ease;
}

form input:focus {
    border-color: #fea319;
    box-shadow: 0 0 8px rgba(254,163,25,0.4);
}

form input[type="submit"] {
    background-color: #fea319;
    color: #1b1b1b;
    padding: 0.8vw 0;
    border: none;
    border-radius: 0.6vw;
    font-size: 1.2vw;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s ease;
}

form input[type="submit"]:hover {
    background-color: #ffb93f;
}

@media (max-width: 768px) {
    form {
        width: 70%;
    }

    h1 {
        font-size: 6vw;
    }

    .backButton {
        font-size: 4vw;
        padding: 2vw 4vw;
    }

    form input[type="submit"] {
        font-size: 4vw;
        padding: 3vw;
    }

    form input[type="text"],
    form input[type="password"],
    form input[type="email"] {
        font-size: 4vw;
    }
}

    </style>
</head>

<body>
    <br>
    <a href="index.php">
        <button>Zpátky</button>
    </a>
    <h1>Register</h1>
    <form action="register.php" method="post">
        Username: <br>
        <input type="text" name="username" autofocus><br>
        Email: <br>
        <input type="text" name="email"><br>
        Password: <br>
        <input type="password" name="password"><br>
        Confirm password: <br>
        <input type="password" name="passwordCheck"><br><br>
        <input type="submit" name="submit" value="Register"><br><br>
    </form>
</body>

</html>
<?php
include("../MainPage/lib/randomValues.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordCheck = $_POST["passwordCheck"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Wrong email";
    } else if (empty($username) || empty($password)) {
        echo "Name or password is empty";
    } else if ($password != $passwordCheck) {
        echo "Wrong confirm password.";
    } else if (strlen($username) > 30) {
        echo "Username can't be longer then 30 characters.";
    } else {
        $canRegister = true;
        try { //check if username is taken
            $stmt = $conn->prepare("SELECT * 
                            FROM users 
                            WHERE user = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if (mysqli_num_rows($result) > 0) {
                $canRegister = false;
                echo "Username is already taken.<br>";
            }
        } catch (mysqli_sql_exception) {
            echo "Coudn't check register.<br>";
        }

        try { //check if email is taken
            $stmt = $conn->prepare("SELECT * 
                            FROM users 
                            WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if (mysqli_num_rows($result) > 0) {
                $canRegister = false;
                echo "This email is in use.<br>";
            }
        } catch (mysqli_sql_exception) {
            echo "Coudn't check register.<br>";
        }

        if ($canRegister) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $conn->prepare("INSERT INTO users 
                                        (user, password, email)
                                        VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $hash, $email);
                $stmt->execute();
                $stmt->close();
                try {
                    $token = RandomString(60);
                    $stmt = $conn->prepare("UPDATE users
                                            SET token = ?, loginDate = NOW()
                                            WHERE user = ?");
                    $stmt->bind_param("ss", $token, $username);
                    $stmt->execute();
                    $stmt->close();
                } catch (mysqli_sql_exception) {
                    echo "Coudn't set token";
                }
                $expireTime = time() + $config["cookies_expire"];
                setcookie("username", $username, $expireTime, "/");
                setcookie("token", $token, $expireTime, "/");
                header("Location: ../MainPage/");
            } catch (mysqli_sql_exception) {
                echo "Coudn't register.<br>";
            }
        }
    }
}
if ($conn) {
    mysqli_close($conn);
}
?>