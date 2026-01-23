<?php
require_once '../config/database.php';
$provinsi = $pdo->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_budaya'];
    $provinsi_id = $_POST['asal_provinsi_id'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori_budaya'];
    
    $foto_name = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $foto_baru = time() . '_' . str_replace(' ', '_', $foto_name);

    if (move_uploaded_file($tmp, "../assets/uploads/" . $foto_baru)) {
        $query = "INSERT INTO budaya (nama_budaya, asal_provinsi_id, deskripsi, foto, kategori_budaya) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nama, $provinsi_id, $deskripsi, $foto_baru, $kategori]);
        header("Location: budaya_kelola.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tambah Budaya - Admin</title>
</head>
<body class="bg-slate-50 pb-20">
    <?php include '../includes/admin_nav.php'; ?>
    <main class="container mx-auto px-6 max-w-4xl">
        <div class="bg-white shadow-2xl border-t-4 border-red-700 p-10 mt-10">
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-8 text-slate-900">Input <span class="text-red-700">Warisan Budaya</span></h2>
            
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Budaya</label>
                    <input type="text" name="nama_budaya" class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-bold" required>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Asal Provinsi</label>
                        <select name="asal_provinsi_id" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold">
                            <?php foreach($provinsi as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= $p['nama_provinsi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori Budaya</label>
                        <select name="kategori_budaya" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold">
                            <option>Tarian</option>
                            <option>Upacara Adat</option>
                            <option>Alat Musik</option>
                            <option>Pakaian Adat</option>
                            <option>Seni Pertunjukan</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Deskripsi & Filosofi</label>
                    <textarea name="deskripsi" rows="6" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none" placeholder="Tuliskan sejarah dan makna budaya ini..."></textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Foto Dokumentasi</label>
                    <input type="file" name="foto" class="text-xs" required>
                </div>

                <div class="pt-6">
                    <button type="submit" class="bg-red-700 text-white px-10 py-4 font-black uppercase tracking-widest text-xs hover:bg-slate-900 transition">Simpan Arsip Budaya</button>
                    <a href="budaya_kelola.php" class="ml-4 text-xs font-black uppercase tracking-widest text-slate-400">Batal</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>