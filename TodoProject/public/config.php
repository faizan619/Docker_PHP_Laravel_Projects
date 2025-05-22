<?php
$hostName = "db";
$dbName = "practise";
$userName = "devuser";
$password = "devpass";

try{
    $conn = new PDO("mysql:host=$hostName;dbname=$dbName",$userName,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Error While Connecting With the Database. \n Error : ",$e->getMessage();
    exit;
}
?>