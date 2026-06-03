<?php
session_start();
include "koneksi.php";
/** @var mysqli $koneksi */

if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
    header("location: index.php?p=Silahkan login terlebih dahulu!");
    exit();
}

$param_url = $_GET['kd_prodi'] ?? ($_GET['id_prodi'] ?? ($_GET['id'] ?? ''));

if (empty($param_url)) {
    header("location: prodi.php?p=Parameter tidak ditemukan!");
    exit();
}


$q = mysqli_query($koneksi, "SELECT * FROM prodi WHERE kd_prodi = '$param_url'");
$dp = mysqli_fetch_assoc($q);

if (!$dp && is_numeric($param_url)) {
    $query_id = mysqli_query($koneksi, "SELECT * FROM prodi LIMIT 1 OFFSET " . ($param_url - 1));
    $dp = mysqli_fetch_assoc($query_id);
}

if (!$dp) {
    header("location: prodi.php?p=Data prodi tidak ditemukan!");
    exit();
}

$kd_prodi = $dp['kd_prodi'];


$cek = mysqli_query($koneksi, "SELECT * FROM siswa WHERE kd_prodi='$kd_prodi'");
if (mysqli_num_rows($cek) > 0){
    header("location: prodi.php?p=Data tidak bisa dihapus karena masih digunakan oleh siswa!");
} else {
    mysqli_query($koneksi, "DELETE FROM prodi WHERE kd_prodi='$kd_prodi'");
    header("location: prodi.php?p=Data prodi berhasil dihapus!");
}
exit();
?>