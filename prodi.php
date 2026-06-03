<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
if(!isset($_SESSION['login']) || $_SESSION['login'] != true){
    header("location: index.php?p=Silahkan login terlebih dahulu!");
    exit();
}
include "koneksi.php";
/** @var mysqli $koneksi */

// TUGAS 3: Menangkap kata kunci pencarian jika ada
$search = isset($_GET['cari']) ? $_GET['cari'] : '';

// Jika kolom pencarian diisi, filter query berdasarkan kode atau nama prodi
if (!empty($search)) {
    $data = mysqli_query($koneksi, "SELECT * FROM prodi WHERE kd_prodi LIKE '%$search%' OR nama_prodi LIKE '%$search%'");
} else {
    // Jika tidak sedang mencari, tampilkan semua data seperti semula
    $data = mysqli_query($koneksi, "SELECT * FROM prodi");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Prodi</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js"></script>
</head>
<body>
    <?php include "navigasi.php"; ?> 
    <div id="main"> <div class="container">
            <h2>Data Prodi</h2>
            
            <?php if (isset($_GET['pesan'])): ?>
                <div class="pesan" style="margin-bottom: 15px; color: green; font-weight: bold;">
                    <?php 
                    if ($_GET['pesan'] == 'tambah') {
                        echo "Data Prodi berhasil ditambahkan!";
                    } elseif ($_GET['pesan'] == 'edit') {
                        echo "Data Prodi berhasil diubah!";
                    }
                    ?>
                </div>
            <?php endif; ?>

            <hr>

            <form method="GET" action="prodi.php" style="margin-bottom: 20px; display: flex; gap: 5px;">
                <input type="text" name="cari" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari kode atau nama prodi..." style="padding: 8px; width: 250px; border: 1px solid #ccc; border-radius: 4px;">
                <button type="submit" style="padding: 8px 15px; background-color: #1F4E79; color: white; border: none; border-radius: 4px; cursor: pointer;">Cari</button>
                <?php if(!empty($search)): ?>
                    <a href="prodi.php" style="padding: 8px 10px; color: red; text-decoration: none; align-self: center;">Reset</a>
                <?php endif; ?>
            </form>

            <a href="tambah_prodi.php" class="tambah">Tambah Data Prodi</a>
            <br><br>
            <table>
                <tr>
                    <th>Kode Prodi</th>
                    <th>Nama Prodi</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($data)) { ?>
                <tr> 
                    <td><?php echo $row['kd_prodi']; ?></td>
                    <td><?php echo $row['nama_prodi']; ?></td>
                    <td>
                        <a href="edit_prodi.php?id_prodi=<?php echo $row['id_prodi']; ?>">EDIT</a> | 
                        <a href="hapus_prodi.php?id_prodi=<?php echo $row['id_prodi']; ?>" onclick="return confirm('Yakin ingin hapus?')">DELETE</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>