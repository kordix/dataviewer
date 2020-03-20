<?php
require_once 'cred.php';

try {
    $dbh = new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8", $user, $pass);
}
catch(PDOException $exception){
    // http_response_code(400);
    echo "Connection error: " . $exception->getMessage();
}


$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
ini_set('mssql.charset', 'windows-1250');



 ?>
