<?php
session_start();
include "koneksi.php";
/** @var mysqli $koneksi */
$prodi = mysqli_query($koneksi, "SELECT * FROM prodi");
$error = "";

if (isset($_POST['simpan'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $kd_prodi = $_POST['kd_prodi'];
    $jk = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
    
    // Ambil Data File Foto
    $foto_name = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    
    //  Validasi Semua Field Tidak Boleh Kosong
    if (empty($nis) || empty($nama) || empty($kelas) || empty($tahun_ajaran) || empty($kd_prodi) || empty($jk)) {
        $error = "Semua data wajib diisi, tidak boleh ada yang kosong!";
    } else {
        //  Proses Upload Foto Profil
        if (!empty($foto_name)) {
            $ekstensi = pathinfo($foto_name, PATHINFO_EXTENSION);
            $nama_foto_baru = $nis . "_" . time() . "." . $ekstensi; // Rename unik
            move_uploaded_file($foto_tmp, "uploads/" . $nama_foto_baru);
        } else {
            $nama_foto_baru = "default.png"; // Default jika tidak upload
        }

        mysqli_query($koneksi, "INSERT INTO siswa (nis, nama, kelas, tahun_ajaran, kd_prodi, jenis_kelamin, foto) 
        VALUES ('$nis', '$nama', '$kelas', '$tahun_ajaran', '$kd_prodi', '$jk', '$nama_foto_baru')");
        
        header("location: siswa.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Siswa</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include "navigasi.php"; ?>
<div id="main">
    <div class="container">
        <h2>TAMBAH DATA SISWA</h2>
        <hr>
        <?php if(!empty($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        
        <form method="POST" enctype="multipart/form-data">
            <table>
                <tr><td>NIS</td><td><input type="text" name="nis" required></td></tr>
                <tr><td>Nama</td><td><input type="text" name="nama" required></td></tr>
                <tr><td>Kelas</td><td><input type="text" name="kelas" required></td></tr>
                <tr><td>Tahun Ajaran</td><td><input type="text" name="tahun_ajaran" required></td></tr>
                <tr>
                    <td>Prodi</td>
                    <td>
                        <select name="kd_prodi" required>
                            <option value="">-- Pilih Prodi --</option>
                            <?php while ($p = mysqli_fetch_assoc($prodi)) { ?>
                                <option value="<?php echo $p['kd_prodi']; ?>"><?php echo $p['nama_prodi']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>
                        <input type="radio" name="jenis_kelamin" value="L" required> Laki-Laki 
                        <input type="radio" name="jenis_kelamin" value="P" required> Perempuan
                    </td>
                </tr>
                <tr><td>Foto Profil</td><td><input type="file" name="foto" accept="image/*"></td></tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" name="simpan" class="submit">SUBMIT</button>
                        <a href="siswa.php" class="batal">BATAL</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>