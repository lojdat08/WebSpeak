<?php
include("getConfig.php");
if(empty($config["profileImages_dir"])){
    die("Upload directory is not set in config.json");
}
if (!is_dir($config["profileImages_dir"])) {
    mkdir($config["profileImages_dir"], 0777, true);
}

if (isset($_FILES['newProfileImage']) && isset($_COOKIE['username'])) {
    include("../checkLogin.php");
    $newProfileFile = $_FILES['newProfileImage'];

    $info = getimagesize($newProfileFile['tmp_name']);
    if ($info === false) {
        die("File is not an image.");
    }

    $width = $info[0];
    $height = $info[1];
    $type = $info[2];

    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = imagecreatefromjpeg($newProfileFile['tmp_name']);
            break;
        case IMAGETYPE_PNG:
            $src = imagecreatefrompng($newProfileFile['tmp_name']);
            break;
        case IMAGETYPE_GIF:
            $src = imagecreatefromgif($newProfileFile['tmp_name']);
            break;
        default:
            die("Unsupported image type.");
    }

    $maxSize = 256;
    $scale = min($maxSize / $width, $maxSize / $height);
    $newWidth = intval($width * $scale);
    $newHeight = intval($height * $scale);

    $dst = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    $time = time();
    $filename = $config["profileImages_dir"] . $time . ".jpg";
    $profileImagePath = $config["profileImages_dir_relative"] . $time . ".jpg";
    imagejpeg($dst, $filename, 90);

    include("../../database.php");
    $username = $_COOKIE["username"];
    try {
        $stmt = $conn->prepare("UPDATE users
                                SET userImg = ?
                                WHERE user = ?"); // create new server
        $stmt->bind_param("ss", $profileImagePath, $username);
        $stmt->execute();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Coudn't change profile image";
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
