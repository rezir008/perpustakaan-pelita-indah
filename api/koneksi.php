<?php 
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'perpus_pelita_ilmu';
 
$conn = mysqli_connect($hostname,$username,$password,$database);
if(!$conn){
    echo "gagal";
}
 
?>