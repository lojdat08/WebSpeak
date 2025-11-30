<?php
$username = "username";
if(isset($_COOKIE["username"]))
{
    $username = $_COOKIE["username"];
}
include("lib/getUserImage.php");
$userImgPath = GetUserImagePath($username);
echo "<a href=\"profileSettings.php\" style=\"text-decoration: none; color: inherit;\">";
echo "<div class=\"profileSettingsButton\">";
echo "<img class=\"profileSettingsImg\" src=\"$userImgPath\"/>";
echo "<p>$username</p>";
echo "</div>";
echo "</a>";