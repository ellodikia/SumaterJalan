<?php
require_once '../config/database.php';

$provinsis = $pdo->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC")->fetchAll();
$kategoris = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_tempat'];
    
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nama)));
    
    $provinsi_id = $_POST['provinsi_id'];
    $kategori_id = $_POST['kategori_id'];
    $deskripsi   = $_POST['deskripsi'];
    $link_maps   = $_POST['link_maps'];
    
    $nama_foto = $_FILES['foto']['name'];
    $tmp_foto  = $_FILES['foto']['tmp_name'];
    $ekstensi_diperbolehkan = ['jpg', 'jpeg', 'png', 'webp'];
    $x = explode('.', $nama_foto);
    $ekstensi = strtolower(end($x));

    if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
        $nama_baru = time() . '_' . preg_replace("/\s+/", "_", $nama_foto);
        
        if (move_uploaded_file($tmp_foto, "../assets/uploads/" . $nama_baru)) {
            $sql = "INSERT INTO lokasi (nama_tempat, slug, provinsi_id, kategori_id, deskripsi, foto_utama, link_maps) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nama, $slug, $provinsi_id, $kategori_id, $deskripsi, $nama_baru, $link_maps]);
            
            header("Location: lokasi_kelola.php?status=sukses_tambah");
            exit;
        }
    } else {
        $error = "Format file tidak didukung! Gunakan JPG, PNG, atau WEBP.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../for_sumaterajalan/logo.png" type="/image/png/jpeg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tambah Lokasi - Admin SumateraJalan</title>
</head>
<body class="bg-slate-50 pb-20">
    
    <?php include '../includes/admin_nav.php'; ?>

    <main class="container mx-auto px-4 md:px-6 mt-10">
        <div class="max-w-4xl mx-auto bg-white shadow-2xl border-t-4 border-red-700 p-6 md:p-10">
            <div class="mb-10 border-b border-slate-100 pb-6">
                <h2 class="text-3xl font-black uppercase tracking-tighter text-slate-900">Tambah <span class="text-red-700">Jejak Lokasi</span></h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Dokumentasikan Keindahan Baru di Swarnadwipa</p>
            </div>

            <?php if(isset($error)): ?>
                <div class="mb-6 p-4 bg-red-100 text-red-700 text-xs font-bold uppercase tracking-widest border-l-4 border-red-700">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Tempat / Destinasi</label>
                    <input type="text" name="nama_tempat" placeholder="Contoh: Ngarai Sianok" 
                           class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-bold text-slate-700 transition" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Wilayah Provinsi</label>
                        <select name="provinsi_id" class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-bold text-slate-700 transition cursor-pointer appearance-none">
                            <?php foreach($provinsis as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama_provinsi']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori Wisata</label>
                        <select name="kategori_id" class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-bold text-slate-700 transition cursor-pointer appearance-none">
                            <?php foreach($kategoris as $k): ?>
                                <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Narasi Deskripsi</label>
                    <textarea name="deskripsi" placeholder="Ceritakan keunikan lokasi ini..." 
                              class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-medium text-slate-600 h-40 transition leading-relaxed" required></textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Koordinat Google Maps (Link)</label>
                    <input type="url" name="link_maps" placeholder="https://goo.gl/maps/..." 
                           class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-medium text-slate-600 transition">
                </div>

                <div class="space-y-4">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Foto Utama Destinasi</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2 relative bg-slate-50 border-2 border-dashed border-slate-200 p-8 text-center group hover:border-red-700 transition">
                            <input type="file" name="foto" id="fotoInput" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                            <div class="space-y-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-slate-300 group-hover:text-red-700 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-[10px] font-black uppercase tracking-tighter text-slate-400 group-hover:text-red-700 transition">Klik untuk memilih foto utama</p>
                            </div>
                        </div>
                        <div class="bg-slate-100 border-2 border-slate-200 flex items-center justify-center overflow-hidden">
                            <img id="previewImg" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                            <span id="previewText" class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">No Preview</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4 pt-6 border-t border-slate-100">
                    <button type="submit" class="bg-red-700 text-white px-12 py-4 font-black uppercase tracking-widest text-xs hover:bg-slate-900 transition shadow-lg shadow-red-100">
                        Simpan Destinasi
                    </button>
                    <a href="lokasi_kelola.php" class="bg-slate-900 text-white text-center px-8 py-4 font-black uppercase tracking-widest text-xs hover:bg-slate-700 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
        const fotoInput = document.getElementById('fotoInput');
        const previewImg = document.getElementById('previewImg');
        const previewText = document.getElementById('previewText');

        fotoInput.onchange = evt => {
            const [file] = fotoInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
                previewImg.classList.remove('hidden');
                previewText.classList.add('hidden');
            }
        }
    </script>

</body>
</html>