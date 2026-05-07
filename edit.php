<?php
require_once 'config/database.php';

$pesan = '';
$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM barang WHERE id = :id");
$stmt->execute([':id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama     = trim($_POST['nama_barang'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $jumlah   = trim($_POST['jumlah'] ?? '');
    $harga    = trim($_POST['harga'] ?? '');
    $lokasi   = trim($_POST['lokasi'] ?? '');

    if (!empty($nama) && !empty($kategori) && !empty($harga)) {

        $stmt = $pdo->prepare("
            UPDATE barang 
            SET nama_barang = :nama,
                kategori   = :kategori,
                jumlah     = :jumlah,
                harga      = :harga,
                lokasi     = :lokasi
            WHERE id = :id
        ");

        $stmt->execute([
            ':nama'     => $nama,
            ':kategori' => $kategori,
            ':jumlah'   => $jumlah,
            ':harga'    => $harga,
            ':lokasi'   => $lokasi,
            ':id'       => $id
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
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
<h3>Edit Data</h3>

<?php if ($pesan): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($pesan) ?></div>
<?php endif; ?>

<form method="POST">

    <input class="form-control mb-2" name="nama_barang" value="<?= htmlspecialchars($data['nama_barang']) ?>">
    <input class="form-control mb-2" name="kategori" value="<?= htmlspecialchars($data['kategori']) ?>">
    <input class="form-control mb-2" type="number" name="jumlah" value="<?= htmlspecialchars($data['jumlah']) ?>">
    <input class="form-control mb-2" type="number" name="harga" value="<?= htmlspecialchars($data['harga']) ?>">
    <input class="form-control mb-2" name="lokasi" value="<?= htmlspecialchars($data['lokasi']) ?>">

    <p><strong>Waktu Ditambahkan:</strong> <?= $data['created_at'] ?></p>

    <button class="btn btn-warning" name="update">Update</button>
</form>

</body>
</html>