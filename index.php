<?php
require_once 'config/database.php';

$stmt = $pdo->query("SELECT * FROM barang ORDER BY id DESC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .btn-pink {
        background-color: #ff69b4;
        color: white;
    }
    .btn-pink:hover {
        background-color: #ff1493;
    }
    </style>
</head>

<body class="container mt-5">

<h2>Data Barang</h2>

<a href="create.php" class="btn btn-pink mb-3">+ Tambah Data</a>

<table class="table table-bordered table-striped">
<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Kategori</th>
    <th>Jumlah</th>
    <th>Harga</th>
    <th>Lokasi</th>
    <th>Waktu Ditambahkan</th>
    <th>Aksi</th>
</tr>

<?php if (empty($data)): ?>
<tr>
    <td colspan="8" class="text-center">Data tidak ada</td>
</tr>
<?php endif; ?>

<?php foreach ($data as $row): ?>
<tr>
    <td><?= (int)$row['id'] ?></td>
    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
    <td><?= htmlspecialchars($row['kategori']) ?></td>
    <td><?= htmlspecialchars($row['jumlah']) ?></td>
    <td><?= "Rp " . number_format($row['harga'], 0, ',', '.') ?></td>
    <td><?= htmlspecialchars($row['lokasi']) ?></td>
    <td><?= htmlspecialchars($row['created_at'] ?? '-') ?></td>
    <td>
        <a href="edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
        <a href="delete.php?id=<?= (int)$row['id'] ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Yakin hapus?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>