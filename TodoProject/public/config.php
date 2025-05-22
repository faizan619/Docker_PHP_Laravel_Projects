<?php
$hostName = "db";
$dbName = "practise";
$userName = "devuser";
$password = "devpass";

$attempts = 5;
$connected = false;

while ($attempts > 0) {
    try {
        $conn = new PDO("mysql:host=$hostName;dbname=$dbName", $userName, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connected = true;
        break;
    } catch(PDOException $e) {
        echo "Waiting for DB... attempts left: $attempts<br>";
        sleep(3);
        $attempts--;
    }
}

if (!$connected) {
    echo "Error While Connecting With the Database. Please check DB container.";
    exit;
}
?>
