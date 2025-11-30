<?php 
$configPath = __DIR__ . "/../../config.json";
if (!file_exists($configPath)) {
    file_put_contents($configPath, "");
}
$config = json_decode(file_get_contents($configPath), true);
?>