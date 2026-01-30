<?php
require_once '../config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM kuliner WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    header("Location: kuliner_kelola.php");
    exit;
}

$provinsi = $pdo->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_kuliner'];
    $provinsi_id = $_POST['asal_provinsi_id'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori_kuliner'];
    $status_halal = $_POST['status_halal'];
    $nama_foto = $data['foto'];

    if (isset($_FILES['foto']) && $_FILES['foto']['name'] != "") {
        $target_dir = "../assets/uploads/";
        
        if ($data['foto'] && file_exists($target_dir . $data['foto'])) {
            unlink($target_dir . $data['foto']);
        }
        
        $nama_foto = time() . '_' . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $nama_foto);
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
    <link rel="icon" href="../for_sumaterajalan/logo.png" type="/image/png/jpeg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Kuliner - Admin SumateraJalan</title>
</head>
<body class="bg-slate-50 pb-20">
    <?php include '../includes/admin_nav.php'; ?>

    <main class="container mx-auto px-4 md:px-6 max-w-4xl">
        <div class="bg-white shadow-2xl border-t-4 border-amber-500 p-6 md:p-10 mt-6 md:mt-10">
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-black uppercase tracking-tighter text-slate-900">
                    Perbarui <span class="text-red-700">Data Kuliner</span>
                </h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">
                    Modifikasi Cita Rasa Swarnadwipa #<?= $id ?>
                </p>
            </div>
            
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Kuliner</label>
                    <input type="text" name="nama_kuliner" required
                           value="<?= htmlspecialchars($data['nama_kuliner']) ?>" 
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
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori</label>
                        <select name="kategori_kuliner" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold focus:border-red-700 transition">
                            <?php $kats = ['Makanan Berat', 'Camilan', 'Minuman']; 
                            foreach($kats as $k): ?>
                                <option value="<?= $k ?>" <?= ($data['kategori_kuliner'] == $k) ? 'selected' : '' ?>><?= $k ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Status Sertifikasi</label>
                    <div class="flex flex-wrap gap-6 p-4 bg-slate-50 border-2 border-slate-100">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold uppercase tracking-wider">
                            <input type="radio" name="status_halal" value="Halal" <?= ($data['status_halal'] == 'Halal') ? 'checked' : '' ?> class="accent-red-700 w-4 h-4"> 
                            Halal
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold uppercase tracking-wider">
                            <input type="radio" name="status_halal" value="Non-Halal" <?= ($data['status_halal'] == 'Non-Halal') ? 'checked' : '' ?> class="accent-red-700 w-4 h-4"> 
                            Non-Halal
                        </label>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Deskripsi Kuliner</label>
                    <textarea name="deskripsi" rows="5" required
                              class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none focus:border-red-700 transition leading-relaxed"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                </div>

                <div class="flex flex-col md:flex-row items-start md:items-center gap-6 p-4 border-2 border-dashed border-slate-200">
                    <div class="relative group">
                        <img src="../assets/uploads/<?= $data['foto'] ?>" 
                             class="w-24 h-24 md:w-32 md:h-32 object-cover border-4 border-white shadow-lg">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <span class="text-[8px] text-white font-bold uppercase">Foto Aktif</span>
                        </div>
                    </div>
                    <div class="space-y-2 flex-1">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Ganti Foto Visual (Opsional)</label>
                        <input type="file" name="foto" accept="image/*" class="text-xs file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-slate-900 file:text-white hover:file:bg-red-700 file:transition cursor-pointer">
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="w-full md:w-auto bg-red-700 text-white px-10 py-4 font-black uppercase tracking-widest text-xs hover:bg-slate-900 transition shadow-xl">
                        Simpan Perubahan
                    </button>
                    <a href="kuliner_kelola.php" class="w-full md:w-auto text-center bg-slate-900 text-white px-10 py-4 font-black uppercase tracking-widest text-xs hover:bg-slate-700 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>