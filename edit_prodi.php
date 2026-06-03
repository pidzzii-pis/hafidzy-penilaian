<?php
session_start();
include "koneksi.php";
$id_prodi = $_GET['id_prodi'];
$query = mysqli_query($koneksi, "SELECT * FROM prodi WHERE id_prodi='$id_prodi'");
$data = mysqli_fetch_assoc($query);

$error = "";
if(isset($_POST['update'])) {
    $kd_prodi = $_POST['kd_prodi'];
    $nama_prodi = $_POST['nama_prodi'];
    mysqli_query($koneksi, "UPDATE prodi SET kd_prodi='$kd_prodi', nama_prodi='$nama_prodi' WHERE id_prodi='$id_prodi'");
    header("location: prodi.php?pesan=edit");
    exit();
    }
?>

<!-- Form dengan value terisi data lama -->
 <form method="POST">
    <label>Kode Prodi</label>
    <input type="text" name="kd_prodi" value="<?php echo $data['kd_prodi']; ?>" required><br><br>
    <label>Nama Prodi</label>
    <input type="text" name="nama_prodi" value="<?php echo $data['nama_prodi']; ?>" required><br><br>
    <button type="submit" name="update" class="submit">UPDATE</button>
    <a href="prodi.php" class="batal">BATAL</a>
 </form>
