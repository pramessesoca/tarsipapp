<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
} 

if ($_SESSION['username'] === 'm45t3r') {
    $_SESSION['admin'] = true;
}

// Fungsi untuk mengenkripsi teks menggunakan AES
function encryptAES($text, $key) {
    $iv = random_bytes(16); // Generate IV (Initialization Vector)
    $cipherText = openssl_encrypt($text, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $cipherText);
}

// Fungsi untuk mendekripsi teks menggunakan AES
function decryptAES($cipherText, $key) {
    $cipherText = base64_decode($cipherText);
    $iv = substr($cipherText, 0, 16); // Extract IV from the ciphertext

    // Ensure the IV length is 16 bytes
    $iv = str_pad($iv, 16, "\0");

    $cipherText = substr($cipherText, 16);
    return openssl_decrypt($cipherText, 'aes-256-cbc', $key, 0, $iv);
}


// Simpan Laporan Keasramaan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_asrama'])) {
    $namaAsrama = encryptAES($_POST['nama_asrama'], 'encryption_key');
    $nomorKamarAsrama = encryptAES($_POST['nomor_kamar_asrama'], 'encryption_key');
    $keteranganAsrama = encryptAES($_POST['keterangan_asrama'], 'encryption_key');

    // Handle file upload
    $fotoAsrama = $_FILES['foto_asrama']['name'];
    $fotoAsrama_temp = $_FILES['foto_asrama']['tmp_name'];

    //Hash file
    $hashFoto = hash_file('sha256', $fotoAsrama_temp);

    // Simpan file hash
    $fotoAsrama_path = 'uploads/asrama/' . $hashFoto;

    move_uploaded_file($fotoAsrama_temp, $fotoAsrama_path);

    // Simpan ke dalam database
    try {
        $stmt = $conn->prepare("INSERT INTO laporan (nama, nomor_kamar, keterangan, foto) VALUES (:nama, :nomor_kamar, :keterangan, :foto)");
        $stmt->bindParam(':nama', $namaAsrama);
        $stmt->bindParam(':nomor_kamar', $nomorKamarAsrama);
        $stmt->bindParam(':keterangan', $keteranganAsrama);
        $stmt->bindParam(':foto', $fotoAsrama_path);

        if ($stmt->execute()) {
            $success_asrama = "Laporan Keasramaan berhasil disimpan.";
        } else {
            $error_asrama = "Error during laporan keasramaan submission.";
        }
    } catch (PDOException $e) {
        $error_asrama = "Error: " . $e->getMessage();
    }
}

// Simpan Laporan Kesehatan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_kesehatan'])) {
    $namaKesehatan = $_POST['nama_kesehatan'];
    $tingkatKesehatan = $_POST['tingkat_kesehatan'];
    $nomorKamarKesehatan = $_POST['nomor_kamar_kesehatan'];
    $keteranganKesehatan = $_POST['keterangan_kesehatan'];

    // Enkripsi data sebelum disimpan ke database
    $encryptedNamaKesehatan = encryptAES($namaKesehatan, 'encryption_key');
    $encryptedTingkatKesehatan = encryptAES($tingkatKesehatan, 'encryption_key');
    $encryptedNomorKamarKesehatan = encryptAES($nomorKamarKesehatan, 'encryption_key');
    $encryptedKeteranganKesehatan = encryptAES($keteranganKesehatan, 'encryption_key');

    // Simpan ke dalam database
    try {
        $stmt = $conn->prepare("INSERT INTO kesehatan (nama, tingkat, nomor_kamar, keterangan) VALUES (:nama, :tingkat, :nomor_kamar, :keterangan)");
        $stmt->bindParam(':nama', $encryptedNamaKesehatan);
        $stmt->bindParam(':tingkat', $encryptedTingkatKesehatan);
        $stmt->bindParam(':nomor_kamar', $encryptedNomorKamarKesehatan);
        $stmt->bindParam(':keterangan', $encryptedKeteranganKesehatan);

        if ($stmt->execute()) {
            $success_kesehatan = "Laporan Kesehatan berhasil disimpan.";
        } else {
            $error_kesehatan = "Error during laporan kesehatan submission.";
        }
    } catch (PDOException $e) {
        $error_kesehatan = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style-dashboard.css" type="text/css">
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>

<!-- Pilihan Menu -->
<div class="menu">
    <a href="dashboard.php?type=asrama">Laporan Keasramaan</a> 
    <a href="dashboard.php?type=kesehatan">Laporan Kesehatan</a> 
    <a href="dashboard.php?type=view_laporan">Rekapitulasi</a>
    <a href="logout.php">Logout</a>
</div>

<?php
if (isset($_GET['type']) && $_GET['type'] == 'asrama') {
    // Formulir Laporan Keasramaan
    echo "<div id='asrama'>";
    echo "<h3>Laporan Keasramaan</h3>";
    if (isset($success_asrama)) echo "<p style='color:green;'>$success_asrama</p>";
    if (isset($error_asrama)) echo "<p style='color:red;'>$error_asrama</p>";
    echo "<form method='post' action='' enctype='multipart/form-data'>";
    echo "<label for='nama_asrama'>Nama:</label>";
    echo "<input type='text' name='nama_asrama' required><br>";
    echo "<label for='nomor_kamar_asrama'>Nomor Kamar:</label>";
    echo "<input type='text' name='nomor_kamar_asrama' required><br>";
    echo "<label for='keterangan_asrama'>Keterangan:</label>";
    echo "<textarea name='keterangan_asrama' required></textarea><br>";
    echo "<label for='foto_asrama'>Foto:</label>";
    echo "<input type='file' name='foto_asrama' accept='image/*' required><br>";
    echo "<input type='submit' name='submit_asrama' value='Submit'>";
    echo "</form>";
    echo "</div>";
} elseif (isset($_GET['type']) && $_GET['type'] == 'kesehatan') {
    // Formulir Laporan Kesehatan
    echo "<div id='kesehatan'>";
    echo "<h3>Laporan Kesehatan</h3>";
    if (isset($success_kesehatan)) echo "<p style='color:green;'>$success_kesehatan</p>";
    if (isset($error_kesehatan)) echo "<p style='color:red;'>$error_kesehatan</p>";
    echo "<form method='post' action=''>";
    echo "<label for='nama_kesehatan'>Nama:</label>";
    echo "<input type='text' name='nama_kesehatan' required><br>";
    echo "<label for='tingkat_kesehatan'>Tingkat:</label>";
    echo "<input type='text' name='tingkat_kesehatan' required><br>";
    echo "<label for='nomor_kamar_kesehatan'>Nomor Kamar:</label>";
    echo "<input type='text' name='nomor_kamar_kesehatan' required><br>";
    echo "<label for='keterangan_kesehatan'>Keterangan:</label>";
    echo "<textarea name='keterangan_kesehatan' required></textarea><br>";
    echo "<input type='submit' name='submit_kesehatan' value='Submit'>";
    echo "</form>";
    echo "</div>";
} elseif (isset($_GET["type"]) && $_GET["type"] == "view_laporan") {
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
        try {
            // Query untuk mengambil data laporan Keasramaan
            $stmt_asrama = $conn->prepare("SELECT * FROM laporan");
            $stmt_asrama->execute();
            $laporan_asrama = $stmt_asrama->fetchAll(PDO::FETCH_ASSOC);

            // Query untuk mengambil data laporan Kesehatan
            $stmt_kesehatan = $conn->prepare("SELECT * FROM kesehatan");
            $stmt_kesehatan->execute();
            $laporan_kesehatan = $stmt_kesehatan->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error_rekapitulasi = "Error: " . $e->getMessage();
        }

        echo "<div id='rekapitulasi'>";
        echo "<h3>Rekapitulasi Laporan</h3>";

        if (isset($error_rekapitulasi)) {
            echo "<p style='color:red;'>$error_rekapitulasi</p>";
        } else {
            // Tampilkan tabel laporan Keasramaan
            echo "<h4>Laporan Keasramaan</h4>";
            if (!empty($laporan_asrama)) {
                echo "<table border='1'>";
                echo "<tr><th>Nama</th><th>Nomor Kamar</th><th>Keterangan</th><th>Foto</th></tr>";
                
                foreach ($laporan_asrama as $laporan) {
                    // Dekripsi data sebelum ditampilkan
                    $namaAsrama = decryptAES($laporan['nama'], 'encryption_key');
                    $nomorKamarAsrama = decryptAES($laporan['nomor_kamar'], 'encryption_key');
                    $keteranganAsrama = decryptAES($laporan['keterangan'], 'encryption_key');
                    
                    echo "<tr>";
                    echo "<td>{$namaAsrama}</td>";
                    echo "<td>{$nomorKamarAsrama}</td>";
                    echo "<td>{$keteranganAsrama}</td>";
                    echo "<td><img src='{$laporan['foto']}' alt='Foto'></td>";
                    echo "</tr>";
                }
                
                echo "</table>";
            } else {
                echo "<p>Tidak ada laporan Keasramaan yang ditemukan.</p>";
            }

            // Tampilkan tabel laporan Kesehatan
            echo "<h4>Laporan Kesehatan</h4>";
            if (!empty($laporan_kesehatan)) {
                echo "<table border='1'>";
                echo "<tr><th>Nama</th><th>Tingkat</th><th>Nomor Kamar</th><th>Keterangan</th></tr>";

                foreach ($laporan_kesehatan as $laporan) {
                    // Dekripsi data sebelum ditampilkan
                    $namaKesehatan = decryptAES($laporan['nama'], 'encryption_key');
                    $tingkatKesehatan = decryptAES($laporan['tingkat'], 'encryption_key');
                    $nomorKamarKesehatan = decryptAES($laporan['nomor_kamar'], 'encryption_key');
                    $keteranganKesehatan = decryptAES($laporan['keterangan'], 'encryption_key');

                    echo "<tr>";
                    echo "<td>$namaKesehatan</td>";
                    echo "<td>$tingkatKesehatan</td>";
                    echo "<td>$nomorKamarKesehatan</td>";
                    echo "<td>$keteranganKesehatan</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<p>Tidak ada laporan Kesehatan yang ditemukan.</p>";
            }
        }

        echo "</div>";
    } else {
        echo "<p style='color:red;'>Anda tidak memiliki izin untuk mengakses rekapitulasi.</p>";
    }
}
?>

</body>
</html>
