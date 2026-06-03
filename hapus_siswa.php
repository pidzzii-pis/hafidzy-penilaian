<?php
session_start();
include "koneksi.php";
/** @var mysqli $koneksi */
if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
    header("location: index.php?p=Silahkan login terlebih dahulu!");
    exit();
}
$id = $_GET['id_prodi'];

//cek apakah ada data
$cek = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$id'");
$data = mysqli_fetch_assoc($cek);
if(!$data){
    header("location: siswa.php?p=Data tidak ditemukan");
    exit();
}
//proses hapus
$hapus = mysqli_query($koneksi, "DELETE FROM siswa WHERE id='$id'");
if ($hapus) {
    header("location: siswa.php?p=Data berhasil dihapus!");
    exit();
} else {
    header("location: siswa.php?p=Gagal menghapus data!");
    exit();
}
?>