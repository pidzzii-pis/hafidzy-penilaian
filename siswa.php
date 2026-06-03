<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
    header("location: index.php?p=Silahkan login terlebih dahulu!");
    exit();
}
include "koneksi.php";
/** @var mysqli $koneksi */

//  Menangkap kata kunci pencarian jika ada
$search = isset($_GET['cari']) ? $_GET['cari'] : '';

//  Jika kolom pencarian diisi, filter data berdasarkan Nama, NIS, atau Nama Prodi
if (!empty($search)) {
    $data = mysqli_query($koneksi, "SELECT s.*, p.nama_prodi 
        FROM siswa s 
        JOIN prodi p ON s.kd_prodi = p.kd_prodi 
        WHERE s.nama LIKE '%$search%' OR s.nis LIKE '%$search%' OR p.nama_prodi LIKE '%$search%'");
} else {
    // Jika tidak mencari, ambil semua data seperti semula
    $data = mysqli_query($koneksi, "SELECT s.*, p.nama_prodi FROM siswa s JOIN prodi p ON s.kd_prodi = p.kd_prodi");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js"></script>
</head>
<body>
    <?php include "navigasi.php"; ?>
    <div id="main">
        <div class="container">
            <h2>DATA SISWA</h2>
            
            <?php if (isset($_GET['pesan'])): ?>
                <div class="pesan" style="margin-bottom: 15px; color: green; font-weight: bold;">
                    <?php 
                    if ($_GET['pesan'] == 'tambah') {
                        echo "Data Siswa berhasil ditambahkan!";
                    } elseif ($_GET['pesan'] == 'edit') {
                        echo "Data Siswa berhasil diubah!";
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <hr>

            <form method="GET" action="siswa.php" style="margin-bottom: 20px; display: flex; gap: 5px;">
                <input type="text" name="cari" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari nama, NIS, atau prodi..." style="padding: 8px; width: 250px; border: 1px solid #ccc; border-radius: 4px;">
                <button type="submit" style="padding: 8px 15px; background-color: #1F4E79; color: white; border: none; border-radius: 4px; cursor: pointer;">Cari</button>
                <?php if(!empty($search)): ?>
                    <a href="siswa.php" style="padding: 8px 10px; color: red; text-decoration: none; align-self: center;">Reset</a>
                <?php endif; ?>
            </form>

            <a href="tambah_siswa.php" class="tambah">TAMBAH DATA SISWA</a>
            
            <br><br>
            <table>
                <tr>
                    <th>Foto</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Tahun Ajaran</th>
                    <th>Prodi</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($data)) { ?>
                <tr>    
                    <td style="text-align: center;">
                        <img src="uploads/<?php echo !empty($row['foto']) ? $row['foto'] : 'default.png'; ?>" width="50" height="50" style="border-radius: 50%; object-fit: cover; border: 1px solid #ccc;">
                    </td>
                    <td><?php echo $row['nis']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['kelas']; ?></td>
                    <td><?php echo $row['tahun_ajaran']; ?></td>
                    <td><?php echo $row['nama_prodi']; ?></td>
                    <td>
                        <a href="edit_siswa.php?id=<?php echo $row['id']; ?>">EDIT</a> | 
                        <a href="hapus_siswa.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin hapus?')">DELETE</a>
                    </td>
                </tr>
                <?php } ?>
            </table> 
        </div>
    </div>
</body>
</html>