<?php

$hostName = "127.0.0.1";
$dbName = "practise-billSpliter";
$userName = "root";
$pass = "";

try{
    $conn = new PDO("mysql:host=$hostName;dbname=$dbName",$userName,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
    echo "Error While Connecting with the Database".$e->getMessage();
    exit;
}

?>