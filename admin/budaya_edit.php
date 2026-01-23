<?php
require_once '../config/database.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM budaya WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

$provinsi = $pdo->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_budaya'];
    $provinsi_id = $_POST['asal_provinsi_id'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori_budaya'];
    $nama_foto = $data['foto'];

    if ($_FILES['foto']['name'] != "") {
        if (file_exists("../assets/uploads/" . $data['foto'])) {
            unlink("../assets/uploads/" . $data['foto']);
        }
        $nama_foto = time() . '_' . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/uploads/" . $nama_foto);
    }

    $sql = "UPDATE budaya SET nama_budaya=?, asal_provinsi_id=?, deskripsi=?, foto=?, kategori_budaya=? WHERE id=?";
    $pdo->prepare($sql)->execute([$nama, $provinsi_id, $deskripsi, $nama_foto, $kategori, $id]);
    header("Location: budaya_kelola.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Budaya - Admin</title>
</head>
<body class="bg-slate-50 pb-20">
    <?php include '../includes/admin_nav.php'; ?>
    <main class="container mx-auto px-6 max-w-4xl">
        <div class="bg-white shadow-2xl border-t-4 border-amber-500 p-10 mt-10">
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-8 text-slate-900">Perbarui <span class="text-red-700">Data Budaya</span></h2>
            
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Budaya</label>
                    <input type="text" name="nama_budaya" value="<?= htmlspecialchars($data['nama_budaya']) ?>" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Asal Provinsi</label>
                        <select name="asal_provinsi_id" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold">
                            <?php foreach($provinsi as $p): ?>
                                <option value="<?= $p['id'] ?>" <?= ($p['id'] == $data['asal_provinsi_id']) ? 'selected' : '' ?>><?= $p['nama_provinsi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori Budaya</label>
                        <select name="kategori_budaya" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold">
                            <?php 
                            $kats = ['Tarian', 'Upacara Adat', 'Alat Musik', 'Pakaian Adat', 'Seni Pertunjukan']; 
                            foreach($kats as $k): ?>
                                <option <?= ($data['kategori_budaya'] == $k) ? 'selected' : '' ?>><?= $k ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Deskripsi & Filosofi</label>
                    <textarea name="deskripsi" rows="6" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                </div>

                <div class="flex items-center gap-6">
                    <img src="../assets/uploads/<?= $data['foto'] ?>" class="w-32 h-20 object-cover border-2 border-slate-200 shadow-md">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Ganti Foto (Opsional)</label>
                        <input type="file" name="foto" class="text-xs">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="bg-slate-900 text-white px-10 py-4 font-black uppercase tracking-widest text-xs hover:bg-red-700 transition">Update Arsip</button>
                    <a href="budaya_kelola.php" class="ml-4 text-xs font-black uppercase tracking-widest text-slate-400">Batal</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>