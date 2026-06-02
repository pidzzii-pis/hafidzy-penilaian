<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "hafidzy_penilaian";

$koneksi=mysqli_connect($hostname, $username, $password);

if ($koneksi){
    //memilih database
    $pilih_db = mysqli_select_db($koneksi, $database);
    if($pilih_db){
        // echo "Database Terpilih";
    }
} else {
    echo "Koneksi gagal, diperiksa lagi!";
}
?>