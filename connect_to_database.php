<?php
$server     ="localhost";
$username   ="root";
$password   ="";
$database   ="car dealer";
$port       ="3306";

$conCD = mysqli_connect($server, $username, $password, $database, $port);

require 'vendor/autoload.php';
use Cloudinary\Configuration\Configuration;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Configuration::instance([
    'cloud' => [
        'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'], 
        'api_key' => $_ENV['CLOUDINARY_API_KEY'], 
        'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
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