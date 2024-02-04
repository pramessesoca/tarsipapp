<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Ambil data laporan asrama dari database
try {
    $stmtAsrama = $conn->prepare("SELECT * FROM laporan_asrama");
    $stmtAsrama->execute();
    $laporanAsramaData = $stmtAsrama->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching data from laporan_asrama: " . $e->getMessage();
}

// Ambil data laporan kesehatan dari database
try {
    $stmtKesehatan = $conn->prepare("SELECT * FROM laporan_kesehatan");
    $stmtKesehatan->execute();
    $laporanKesehatanData = $stmtKesehatan->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching data from laporan_kesehatan: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Laporan</title>
    <link rel="stylesheet" href="style-dashboard.css" type="text/css">
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

<!-- Pilihan Menu -->
<div class="menu">
    <a href="dashboard.php?type=asrama">Laporan Keasramaan</a> 
    <a href="dashboard.php?type=kesehatan">Laporan Kesehatan</a> 
    <a href="logout.php">Logout</a>
    <a href="view_laporan.php">View Laporan</a>
</div>

<!-- Tampilkan data laporan asrama -->
<div id="laporan_asrama">
    <h3>Laporan Keasramaan</h3>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Nomor Kamar</th>
            <th>Keterangan</th>
            <th>Foto</th>
        </tr>
        <?php foreach ($laporanAsramaData as $laporan) : ?>
            <tr>
                <td><?php echo $laporan['nama']; ?></td>
                <td><?php echo $laporan['nomor_kamar']; ?></td>
                <td><?php echo $laporan['keterangan']; ?></td>
                <td><img src="<?php echo $laporan['foto']; ?>" alt="Foto"></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<!-- Tampilkan data laporan kesehatan -->
<div id="laporan_kesehatan">
    <h3>Laporan Kesehatan</h3>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Tingkat</th>
            <th>Nomor Kamar</th>
            <th>Keterangan</th>
        </tr>
        <?php foreach ($laporanKesehatanData as $laporan) : ?>
            <tr>
                <td><?php echo $laporan['nama']; ?></td>
                <td><?php echo $laporan['tingkat']; ?></td>
                <td><?php echo $laporan['nomor_kamar']; ?></td>
                <td><?php echo $laporan['keterangan']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
