<?php
session_start();
include "koneksi.php";
/** @var mysqli $koneksi */
if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
    header("location: index.php?p=Silahkan login terlebih dahulu!");
    exit();
}
$param_url = $_GET['nis'] ?? ($_GET['id'] ?? ($_GET['id_prodi'] ?? ''));

if (empty($param_url)) {
    header("location: siswa.php?p=Parameter ID atau NIS tidak ditemukan!");
    exit();
}


$cek = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = '$param_url'");
$data = mysqli_fetch_assoc($cek);

if (!$data && is_numeric($param_url)) {
    $query_id = mysqli_query($koneksi, "SELECT * FROM siswa LIMIT 1 OFFSET " . ($param_url - 1));
    $data = mysqli_fetch_assoc($query_id);
}

if(!$data){
    header("location: siswa.php?p=Data siswa tidak ditemukan di database!");
    exit();
}


$nis_hapus = $data['nis'];


$hapus = mysqli_query($koneksi, "DELETE FROM siswa WHERE nis = '$nis_hapus'");

if ($hapus) {

    if (!empty($data['foto']) && $data['foto'] != 'default.png' && file_exists("uploads/" . $data['foto'])) {
        unlink("uploads/" . $data['foto']);
    }
    
    header("location: siswa.php?p=Data berhasil dihapus!");
    exit();
} else {
    header("location: siswa.php?p=Gagal menghapus data dari database!");
    exit();
}
?>