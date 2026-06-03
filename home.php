<?php
session_start();
header("Cache-Control: no-store, no-chache, must-revilidate, max-age=0");
if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
    header("location: index.php?p=Silahkan login terlebih dahulu!");
    exit();
}
 date_default_timezone_set("Asia/Jakarta");
$jam = date("H");
 if($jam < 12) {
    $msg = "Selamat Pagi!";
 } else if ($jam < 15){
    $msg = "Selamat Siang!";
 } else if ($jam < 18){
    $msg = "Selamat Sore!";
 } else {
    $msg = "Selamat Malam!";
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Home</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js"></script>
</head>
<body>
    <?php include "navigasi.php"; ?>
    <div id="main">
        <div class="container">
            <?php echo date("l, d F Y"); ?>
            <h2>APLIKASI MANAJEMEN</h2>
            <hr>
            <p><?php echo $msg ?></p>
            <p>Selamat Datang di aplikasi Data Siswa SMKS PGRI 3 MALANG</p>
        </div>
    </div>
</body>
</html>