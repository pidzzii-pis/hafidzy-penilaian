<?php
session_start();
include "koneksi.php";
/** @var mysqli $koneksi */

if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
    header("location: index.php?p=Silahkan login terlebih dahulu!");
    exit();
}

$error = "";

if (isset($_POST['simpan'])) {
    $kd_prodi   = mysqli_real_escape_string($koneksi, $_POST['kd_prodi']);
    $nama_prodi = mysqli_real_escape_string($koneksi, $_POST['nama_prodi']);
    
    $cek = mysqli_query($koneksi, "SELECT * FROM prodi WHERE kd_prodi='$kd_prodi'");
    if(mysqli_num_rows($cek) > 0){
        $error = "Kode Prodi sudah digunakan!";
    } else {  
        $query_insert = "INSERT INTO prodi (kd_prodi, nama_prodi) VALUES ('$kd_prodi', '$nama_prodi')";
        
        if(mysqli_query($koneksi, $query_insert)) {
            header("location: prodi.php?pesan=tambah");
            exit();
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($koneksi);
        }
    }
}   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Prodi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include "navigasi.php"; ?>

    <div id="main">
        <div class="container">
            <h2>TAMBAH DATA PROGRAM STUDI</h2>
            <hr>
            
            <?php if(!empty($error)) { echo "<p style='color:red; font-weight:bold;'>$error</p>"; } ?>

            <form method="POST">
                <table>
                    <tr>
                        <td>Kode Prodi</td>
                        <td><input type="text" name="kd_prodi" required></td>
                    </tr>
                    <tr>
                        <td>Nama Prodi</td>
                        <td><input type="text" name="nama_prodi" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" name="simpan" class="submit">SIMPAN</button>
                            <a href="prodi.php" class="batal" style="margin-left: 10px; text-decoration: none;">BATAL</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>