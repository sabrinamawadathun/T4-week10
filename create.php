<?php
require_once 'config/database.php';

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama_barang'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $jumlah   = trim($_POST['jumlah'] ?? '');
    $harga    = trim($_POST['harga'] ?? '');
    $lokasi   = trim($_POST['lokasi'] ?? '');

    if (!empty($nama) && !empty($kategori) && !empty($harga)) {

        $stmt = $pdo->prepare("
            INSERT INTO barang (nama_barang, kategori, jumlah, harga, lokasi)
            VALUES (:nama, :kategori, :jumlah, :harga, :lokasi)
        ");

        $stmt->execute([
            ':nama' => $nama,
            ':kategori' => $kategori,
            ':jumlah' => $jumlah,
            ':harga' => $harga,
            ':lokasi' => $lokasi
        ]);

        header("Location: index.php");
        exit;

    } else {
        $pesan = "Semua field wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">
<div class="card shadow">
<div class="card-body">

<h3>Tambah Data Barang</h3>
<?php if ($pesan): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($pesan) ?></div>
<?php endif; ?>

<form method="POST">
    <input class="form-control mb-2" name="nama_barang" placeholder="Nama Barang" required>
    <input class="form-control mb-2" name="kategori" placeholder="Kategori" required>
    <input class="form-control mb-2" type="number" name="jumlah" placeholder="Jumlah">
    <input class="form-control mb-2" type="number" name="harga" placeholder="Harga" required>
    <input class="form-control mb-2" name="lokasi" placeholder="Lokasi">

    <button class="btn btn-success" name="submit">Simpan</button>
    <a href="index.php" class="btn btn-secondary">Kembali</a>

</form>

</div>
</div>
</div>
</body>
</html>