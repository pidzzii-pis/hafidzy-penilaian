<?php
session_start();
include "koneksi.php";
/** @var mysqli $koneksi */

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
    header("location: index.php?p=Silahkan login terlebih dahulu!");
    exit();
}

$param_url = $_GET['kd_prodi'] ?? ($_GET['id_prodi'] ?? ($_GET['id'] ?? ''));

if (empty($param_url)) {
    die("Akses ditolak: Parameter Kode Prodi atau ID tidak ditemukan di URL!");
}

$query = mysqli_query($koneksi, "SELECT * FROM prodi WHERE kd_prodi = '$param_url'");
$data = mysqli_fetch_assoc($query);

if (!$data && is_numeric($param_url)) {
    $query_id = mysqli_query($koneksi, "SELECT * FROM prodi LIMIT 1 OFFSET " . ($param_url - 1));
    $data = mysqli_fetch_assoc($query_id);
}

if (!$data) {
    die("Data program studi dengan parameter '" . htmlspecialchars($param_url) . "' tidak ditemukan di database!");
}

$kd_prodi_target = $data['kd_prodi'];
$error = "";

// 2. Proses pengiriman form update data ke database
if(isset($_POST['update'])) {
    $kd_prodi   = mysqli_real_escape_string($koneksi, $_POST['kd_prodi']);
    $nama_prodi = mysqli_real_escape_string($koneksi, $_POST['nama_prodi']);
    
    if (empty($kd_prodi) || empty($nama_prodi)) {
        $error = "Semua kolom wajib diisi!";
    } else {
        $query_update = "UPDATE prodi SET 
                            kd_prodi='$kd_prodi', 
                            nama_prodi='$nama_prodi' 
                         WHERE kd_prodi='$kd_prodi_target'";
                         
        if (mysqli_query($koneksi, $query_update)) {
            header("location: prodi.php?pesan=edit");
            exit();
        } else {
            $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Prodi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include "navigasi.php"; ?>

    <div id="main">
        <div class="container">
            <h2>EDIT DATA PROGRAM STUDI</h2>
            <hr>
            
            <?php if(!empty($error)) { echo "<p style='color:red; font-weight:bold;'>$error</p>"; } ?>

            <form method="POST">
                <table>
                    <tr>
                        <td>Kode Prodi</td>
                        <td><input type="text" name="kd_prodi" value="<?php echo htmlspecialchars($data['kd_prodi']); ?>" required></td>
                    </tr>
                    <tr>
                        <td>Nama Prodi</td>
                        <td><input type="text" name="nama_prodi" value="<?php echo htmlspecialchars($data['nama_prodi']); ?>" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" name="update" class="submit">UPDATE</button>
                            <a href="prodi.php" class="batal" style="margin-left: 10px; text-decoration: none;">BATAL</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>