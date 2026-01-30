<?php
require_once '../config/database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: lokasi_kelola.php");
    exit;
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM lokasi WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    header("Location: lokasi_kelola.php");
    exit;
}

$provinsis = $pdo->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC")->fetchAll();
$kategoris = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_tempat'];
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nama)));
    
    $provinsi_id = $_POST['provinsi_id'];
    $kategori_id = $_POST['kategori_id'];
    $deskripsi   = $_POST['deskripsi'];
    $link_maps   = $_POST['link_maps'];
    $nama_baru   = $data['foto_utama']; 

    if ($_FILES['foto']['name'] != "") {
        $ekstensi_diperbolehkan = ['png', 'jpg', 'jpeg', 'webp'];
        $x = explode('.', $_FILES['foto']['name']);
        $ekstensi = strtolower(end($x));
        $tmp = $_FILES['foto']['tmp_name'];
        
        if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
            $nama_baru = time() . '_' . preg_replace("/\s+/", "_", $_FILES['foto']['name']);
            
            if (move_uploaded_file($tmp, "../assets/uploads/" . $nama_baru)) {
                if ($data['foto_utama'] != "" && file_exists("../assets/uploads/" . $data['foto_utama'])) {
                    unlink("../assets/uploads/" . $data['foto_utama']);
                }
            }
        }
    }

    $sql = "UPDATE lokasi SET nama_tempat=?, slug=?, provinsi_id=?, kategori_id=?, deskripsi=?, foto_utama=?, link_maps=? WHERE id=?";
    $stmt_update = $pdo->prepare($sql);
    $stmt_update->execute([$nama, $slug, $provinsi_id, $kategori_id, $deskripsi, $nama_baru, $link_maps, $id]);
    
    header("Location: lokasi_kelola.php?status=sukses_edit");
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
    <title>Edit Lokasi - Admin SumateraJalan</title>
</head>
<body class="bg-slate-50">
    
    <?php include '../includes/admin_nav.php'; ?>

    <main class="container mx-auto px-4 md:px-6">
        <div class="max-w-4xl mx-auto bg-white shadow-2xl border-t-4 border-amber-500 p-6 md:p-10 mt-10">
            <div class="mb-10 border-b border-slate-100 pb-6 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                <div>
                    <h2 class="text-3xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                        Perbarui <span class="text-red-700">Jejak Lokasi</span>
                    </h2>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 italic">
                        Mengubah informasi destinasi: <span class="text-slate-700 font-black"><?= htmlspecialchars($data['nama_tempat']) ?></span>
                    </p>
                </div>
                <span class="text-[10px] font-black px-3 py-1 bg-slate-100 text-slate-400 uppercase tracking-widest border border-slate-200">
                    Database ID: #<?= $id ?>
                </span>
            </div>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Tempat / Destinasi</label>
                    <input type="text" name="nama_tempat" value="<?= htmlspecialchars($data['nama_tempat']) ?>" 
                           class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-bold text-slate-700 transition" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Wilayah Provinsi</label>
                        <select name="provinsi_id" class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-bold text-slate-700 transition appearance-none cursor-pointer">
                            <?php foreach($provinsis as $p): ?>
                                <option value="<?= $p['id'] ?>" <?= ($p['id'] == $data['provinsi_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p['nama_provinsi']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori Wisata</label>
                        <select name="kategori_id" class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-bold text-slate-700 transition appearance-none cursor-pointer">
                            <?php foreach($kategoris as $k): ?>
                                <option value="<?= $k['id'] ?>" <?= ($k['id'] == $data['kategori_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($k['nama_kategori']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Narasi Deskripsi</label>
                    <textarea name="deskripsi" required
                              class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-medium text-slate-600 h-40 transition leading-relaxed"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Koordinat Google Maps (URL)</label>
                    <input type="url" name="link_maps" value="<?= htmlspecialchars($data['link_maps']) ?>" 
                           class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-medium text-slate-600 transition" placeholder="https://maps.google.com/...">
                </div>

                <div class="space-y-4">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Visual Destinasi</label>
                    <div class="flex flex-col md:flex-row gap-8 items-start bg-slate-50 p-6 border-2 border-slate-100">
                        <div class="relative group">
                            <p class="text-[9px] font-bold text-slate-400 uppercase mb-2">Preview:</p>
                            <img id="imgPreview" src="../assets/uploads/<?= $data['foto_utama'] ?>" 
                                 class="w-full md:w-64 h-40 object-cover border-4 border-white shadow-xl transition group-hover:grayscale">
                        </div>
                        <div class="space-y-4 flex-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase italic leading-relaxed">
                                Biarkan kosong jika tidak ingin mengganti foto.<br>
                                Gunakan format: <span class="text-red-700">JPG, PNG, atau WEBP</span>.
                            </p>
                            <input type="file" name="foto" id="fotoInput" accept="image/*"
                                   class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-slate-900 file:text-white hover:file:bg-red-700 transition cursor-pointer">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 pt-6">
                    <button type="submit" class="w-full md:w-auto bg-red-700 text-white px-12 py-4 font-black uppercase tracking-widest text-xs hover:bg-slate-900 transition shadow-lg shadow-red-100">
                        Simpan Perubahan
                    </button>
                    <a href="lokasi_kelola.php" class="w-full md:w-auto bg-slate-900 text-center text-white px-8 py-4 font-black uppercase tracking-widest text-xs hover:bg-slate-700 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>

    <script>
        fotoInput.onchange = evt => {
            const [file] = fotoInput.files
            if (file) {
                imgPreview.src = URL.createObjectURL(file)
            }
        }
    </script>

</body>
</html>