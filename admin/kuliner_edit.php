<?php
require_once '../config/database.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM kuliner WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

$provinsi = $pdo->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_kuliner'];
    $provinsi_id = $_POST['asal_provinsi_id'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori_kuliner'];
    $status_halal = $_POST['status_halal'];
    $nama_foto = $data['foto'];

    if ($_FILES['foto']['name'] != "") {
        if (file_exists("../assets/uploads/" . $data['foto'])) {
            unlink("../assets/uploads/" . $data['foto']);
        }
        $nama_foto = time() . '_' . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/uploads/" . $nama_foto);
    }

    $sql = "UPDATE kuliner SET nama_kuliner=?, asal_provinsi_id=?, deskripsi=?, foto=?, kategori_kuliner=?, status_halal=? WHERE id=?";
    $pdo->prepare($sql)->execute([$nama, $provinsi_id, $deskripsi, $nama_foto, $kategori, $status_halal, $id]);
    header("Location: kuliner_kelola.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Kuliner - Admin</title>
</head>
<body class="bg-slate-50 pb-20">
    <?php include '../includes/admin_nav.php'; ?>
    <main class="container mx-auto px-6 max-w-4xl">
        <div class="bg-white shadow-2xl border-t-4 border-amber-500 p-10 mt-10">
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-8 text-slate-900">Perbarui <span class="text-red-700">Data Kuliner</span></h2>
            
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Kuliner</label>
                    <input type="text" name="nama_kuliner" value="<?= $data['nama_kuliner'] ?>" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold">
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
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori</label>
                        <select name="kategori_kuliner" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold">
                            <?php $kats = ['Makanan Berat', 'Camilan', 'Minuman']; 
                            foreach($kats as $k): ?>
                                <option <?= ($data['kategori_kuliner'] == $k) ? 'selected' : '' ?>><?= $k ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Status Sertifikasi</label>
                    <div class="flex gap-6 p-4 bg-slate-50 border-2 border-slate-100">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold"><input type="radio" name="status_halal" value="Halal" <?= ($data['status_halal'] == 'Halal') ? 'checked' : '' ?> class="accent-red-700"> Halal</label>
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold"><input type="radio" name="status_halal" value="Non-Halal" <?= ($data['status_halal'] == 'Non-Halal') ? 'checked' : '' ?> class="accent-red-700"> Non-Halal</label>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Deskripsi</label>
                    <textarea name="deskripsi" rows="5" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none"><?= $data['deskripsi'] ?></textarea>
                </div>

                <div class="flex items-center gap-6">
                    <img src="../assets/uploads/<?= $data['foto'] ?>" class="w-24 h-24 object-cover border-2 border-slate-200">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Ganti Foto (Opsional)</label>
                        <input type="file" name="foto" class="text-xs">
                    </div>
                </div>

                <div class="pt-6 flex gap-4">
                    <button type="submit" class="bg-red-700 text-white px-10 py-4 font-black uppercase tracking-widest text-xs hover:bg-slate-900 transition">Update Data</button>
                    <a href="kuliner_kelola.php" class="bg-slate-900 text-white px-10 py-4 font-black uppercase tracking-widest text-xs">Batal</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>