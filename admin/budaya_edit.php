<?php
require_once '../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM budaya WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    header("Location: budaya_kelola.php");
    exit;
}

$provinsi = $pdo->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_budaya'];
    $provinsi_id = $_POST['asal_provinsi_id'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori_budaya'];
    $nama_foto = $data['foto'];

    if (isset($_FILES['foto']) && $_FILES['foto']['name'] != "") {
        $target_dir = "../assets/uploads/";
        
        if ($data['foto'] && file_exists($target_dir . $data['foto'])) {
            unlink($target_dir . $data['foto']);
        }
        
        $nama_foto = time() . '_' . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $nama_foto);
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
    <link rel="icon" href="../for_sumaterajalan/logo.png" type="/image/png/jpeg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Budaya - Admin SumateraJalan</title>
</head>
<body class="bg-slate-50">
    <?php include '../includes/admin_nav.php'; ?>

    <main class="container mx-auto px-4 md:px-6 max-w-4xl">
        <div class="bg-white shadow-2xl border-t-4 border-amber-500 p-6 md:p-10 mt-6 md:mt-10">
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-black uppercase tracking-tighter text-slate-900">
                    Perbarui <span class="text-red-700">Data Budaya</span>
                </h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">ID Arsip: #<?= $id ?></p>
            </div>
            
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Budaya</label>
                    <input type="text" name="nama_budaya" required 
                           value="<?= htmlspecialchars($data['nama_budaya']) ?>" 
                           class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold focus:border-red-700 transition">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Asal Provinsi</label>
                        <select name="asal_provinsi_id" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold focus:border-red-700 transition">
                            <?php foreach($provinsi as $p): ?>
                                <option value="<?= $p['id'] ?>" <?= ($p['id'] == $data['asal_provinsi_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p['nama_provinsi']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori Budaya</label>
                        <select name="kategori_budaya" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold focus:border-red-700 transition">
                            <?php 
                            $kats = ['Tarian', 'Upacara Adat', 'Alat Musik', 'Pakaian Adat', 'Seni Pertunjukan']; 
                            foreach($kats as $k): ?>
                                <option value="<?= $k ?>" <?= ($data['kategori_budaya'] == $k) ? 'selected' : '' ?>>
                                    <?= $k ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Deskripsi & Filosofi</label>
                    <textarea name="deskripsi" rows="8" required 
                              class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none focus:border-red-700 transition text-slate-700 leading-relaxed"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                </div>

                <div class="flex flex-col md:flex-row items-start md:items-center gap-6 p-4 bg-slate-50 border-2 border-dashed border-slate-200">
                    <div class="relative group">
                        <img src="../assets/uploads/<?= $data['foto'] ?>" 
                             class="w-32 h-20 md:w-40 md:h-24 object-cover border-2 border-white shadow-lg">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <span class="text-[8px] text-white font-bold uppercase">Foto Saat Ini</span>
                        </div>
                    </div>
                    
                    <div class="space-y-2 flex-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Ganti Foto Visual</label>
                        <input type="file" name="foto" accept="image/*" class="text-xs file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-slate-900 file:text-white hover:file:bg-red-700 file:transition cursor-pointer">
                        <p class="text-[9px] text-slate-400 italic">*Biarkan kosong jika tidak ingin mengubah foto.</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="bg-slate-900 text-white px-10 py-4 font-black uppercase tracking-widest text-xs hover:bg-red-700 transition shadow-xl">
                        Simpan Perubahan
                    </button>
                    <a href="budaya_kelola.php" class="flex items-center justify-center px-10 py-4 text-xs font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition">
                        Batal & Kembali
                    </a>
                </div>
            </form>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>

</body>
</html>