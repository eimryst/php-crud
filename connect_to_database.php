<?php
$server     ="localhost";
$username   ="root";
$password   ="";
$database   ="car dealer";
$port       ="3306";

$conCD = mysqli_connect($server, $username, $password, $database, $port);

require 'vendor/autoload.php';
use Cloudinary\Configuration\Configuration;

Configuration::instance([
    'cloud' => [
        'cloud_name' => getenv("CLOUDINARY_CLOUD_NAME"), 
        'api_key' => getenv("CLOUDINARY_API_KEY"), 
        'api_secret' => getenv("CLOUDINARY_API_SECRET"),
    ],
    'url' => [
        'secure' => true
    ]
]);

if($conCD->connect_error){
    die("Connection Error, Check Database Credentials.".$conCD->connect_error);
} else {
    // echo "Connection success!";
}
?>
