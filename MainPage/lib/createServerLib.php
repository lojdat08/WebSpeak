<?php
include("getConfig.php");
if(empty($config["serverImages_dir"])){
    die("Upload directory is not set in config.json");
}
if (!is_dir($config["serverImages_dir"])) {
    mkdir($config["serverImages_dir"], 0777, true);
}

if (isset($_POST['serverName']) && isset($_FILES['serverImage'])) {

    $serverName = $_POST['serverName'];
    $file = $_FILES['serverImage'];
    $username = $_COOKIE["username"];

    $info = getimagesize($file['tmp_name']);
    if ($info === false) {
        die("File is not an image.");
    }

    $width = $info[0];
    $height = $info[1];
    $type = $info[2];

    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = imagecreatefromjpeg($file['tmp_name']);
            break;
        case IMAGETYPE_PNG:
            $src = imagecreatefrompng($file['tmp_name']);
            break;
        case IMAGETYPE_GIF:
            $src = imagecreatefromgif($file['tmp_name']);
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
    $filename = $config["serverImages_dir"] . $time . ".jpg";
    $serverImagePath = $config["serverImages_dir_relative"] . $time . ".jpg";
    imagejpeg($dst, $filename, 90);

    include("../../database.php");
    include_once("getUserid.php");
    $userId = GetUserIdFromName($username, $conn);
    try {
        $stmt = $conn->prepare("INSERT INTO `servers`
                                (`serverName`, `img`, `authorId`)
                                VALUES (?, ?, ?)"); // create new server
        $stmt->bind_param("ssi", $serverName, $serverImagePath, $userId);
        $stmt->execute();
        $serverId = $conn->insert_id;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO `usersinserver`
                                (`userId`, `serverId`)
                                VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $serverId);
        $stmt->execute();
        $stmt->close();
    } catch (mysqli_sql_exception) {
        echo "Coudn't create server";
    }
    if ($conn) {
        mysqli_close($conn);
    }
}
