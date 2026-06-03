<?php
session_start();
include "koneksi.php";
/** @var mysqli $koneksi */

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");


if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
    header("location: index.php?p=Silahkan login terlebih dahulu!");
    exit();
}


$nis_target = $_GET['nis'] ?? ($_GET['id'] ?? ($_GET['id_prodi'] ?? ''));

if (empty($nis_target)) {
    die("Akses ditolak: Parameter NIS atau ID siswa tidak ditemukan di URL!");
}


$query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = '$nis_target'");
$data = mysqli_fetch_assoc($query);


if (!$data) {
    die("Data siswa dengan NIS " . htmlspecialchars($nis_target) . " tidak ditemukan di database!");
}

$prodi = mysqli_query($koneksi, "SELECT * FROM prodi");

if(isset($_POST['update'])){
    $nis          = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama         = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kelas        = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $tahun_ajaran = mysqli_real_escape_string($koneksi, $_POST['tahun_ajaran']);
    $kd_prodi     = mysqli_real_escape_string($koneksi, $_POST['kd_prodi']);
    $jk           = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    
   
    $query_update = "UPDATE siswa SET
                        nis          = '$nis',
                        nama         = '$nama',
                        kelas        = '$kelas',
                        tahun_ajaran = '$tahun_ajaran',
                        kd_prodi     = '$kd_prodi',
                        jenis_kelamin= '$jk'
                     WHERE nis = '$nis_target'";
                     
    if (mysqli_query($koneksi, $query_update)) {
        header("location:siswa.php?pesan=edit");
        exit();
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include "navigasi.php"; ?>

    <div id="main">
        <div class="container">
            <h2>EDIT DATA SISWA</h2>
            <hr>
            <form method="POST">
                <table>
                    <tr>
                        <td>NIS</td>
                        <td><input type="text" name="nis" value="<?php echo htmlspecialchars($data['nis']); ?>" required></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td><input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td><input type="text" name="kelas" value="<?php echo htmlspecialchars($data['kelas']); ?>" required></td>
                    </tr>
                    <tr>
                        <td>Tahun Ajaran</td>
                        <td><input type="text" name="tahun_ajaran" value="<?php echo htmlspecialchars($data['tahun_ajaran']); ?>" required></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>
                            <input type="radio" name="jenis_kelamin" value="L" <?php if($data['jenis_kelamin'] == 'L') echo "checked"; ?> required> Laki-Laki
                            <input type="radio" name="jenis_kelamin" value="P" <?php if($data['jenis_kelamin'] == 'P') echo "checked"; ?> required> Perempuan
                        </td>
                    </tr>
                    <tr>
                        <td>Program Studi</td>
                        <td>
                            <select name="kd_prodi" required>
                                <option value="">-- Pilih Prodi --</option>
                                <?php while ($p = mysqli_fetch_assoc($prodi)){ ?> 
                                    <option value="<?php echo $p['kd_prodi']; ?>" <?php if ($p['kd_prodi'] == $data['kd_prodi']) echo "selected"; ?>>
                                        <?php echo htmlspecialchars($p['nama_prodi']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>    
                        <td></td>
                        <td>
                            <button type="submit" name="update" class="submit">UPDATE</button>
                            <a href="siswa.php" style="margin-left:10px; text-decoration:none; color:gray;">BATAL</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>