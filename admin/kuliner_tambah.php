<?php
require_once '../config/database.php';

$provinsi = $pdo->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_kuliner'];
    $provinsi_id = $_POST['asal_provinsi_id'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori_kuliner'];
    $status_halal = $_POST['status_halal'];
    
    $foto_name = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    
    $foto_baru = time() . '_' . preg_replace("/\s+/", "_", $foto_name);

    if (move_uploaded_file($tmp, "../assets/uploads/" . $foto_baru)) {
        $query = "INSERT INTO kuliner (nama_kuliner, asal_provinsi_id, deskripsi, foto, kategori_kuliner, status_halal) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nama, $provinsi_id, $deskripsi, $foto_baru, $kategori, $status_halal]);
        
        header("Location: kuliner_kelola.php");
        exit;
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
    <title>Tambah Kuliner - Admin SumateraJalan</title>
</head>
<body class="bg-slate-50">
    <?php include '../includes/admin_nav.php'; ?>

    <main class="container mx-auto px-4 md:px-6 max-w-4xl">
        <div class="bg-white shadow-2xl border-t-4 border-red-700 p-6 md:p-10 mt-6 md:mt-10">
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                    Tambah <span class="text-red-700">Warisan Rasa</span>
                </h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Daftarkan kuliner khas baru ke Database Swarnadwipa</p>
            </div>
            
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Kuliner</label>
                    <input type="text" name="nama_kuliner" required
                           class="w-full p-4 bg-slate-50 border-2 border-slate-100 focus:border-red-700 outline-none font-bold transition"
                           placeholder="Contoh: Rendang Daging">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Asal Provinsi</label>
                        <select name="asal_provinsi_id" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold focus:border-red-700 transition">
                            <?php foreach($provinsi as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama_provinsi']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Kategori</label>
                        <select name="kategori_kuliner" class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none font-bold focus:border-red-700 transition">
                            <option>Makanan Berat</option>
                            <option>Camilan</option>
                            <option>Minuman</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Status Sertifikasi</label>
                    <div class="flex flex-wrap gap-6 p-4 bg-slate-50 border-2 border-slate-100">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold uppercase tracking-wider">
                            <input type="radio" name="status_halal" value="Halal" checked class="accent-red-700 w-4 h-4"> 
                            Halal
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold uppercase tracking-wider">
                            <input type="radio" name="status_halal" value="Non-Halal" class="accent-red-700 w-4 h-4"> 
                            Non-Halal
                        </label>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Deskripsi Kuliner</label>
                    <textarea name="deskripsi" rows="5" required
                              class="w-full p-4 bg-slate-50 border-2 border-slate-100 outline-none focus:border-red-700 transition"
                              placeholder="Ceritakan sejarah atau keunikan rasa makanan ini..."></textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Foto Sajian</label>
                    <div class="flex flex-col gap-4 p-4 bg-slate-50 border-2 border-dashed border-slate-200">
                        <input type="file" name="foto" id="fotoInput" accept="image/*" required
                               class="text-xs file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-slate-900 file:text-white hover:file:bg-red-700 file:transition cursor-pointer">
                        
                        <div id="previewContainer" class="hidden">
                            <p class="text-[9px] font-bold text-slate-400 uppercase mb-2">Pratinjau Foto:</p>
                            <img id="imgPreview" src="#" class="h-40 w-full md:w-60 object-cover border-2 border-white shadow-md">
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex flex-col md:flex-row items-center gap-4">
                    <button type="submit" class="w-full md:w-auto bg-red-700 text-white px-10 py-4 font-black uppercase tracking-widest text-xs hover:bg-slate-900 transition shadow-lg">
                        Simpan Data Kuliner
                    </button>
                    <a href="kuliner_kelola.php" class="w-full md:w-auto text-center text-xs font-black uppercase tracking-widest text-slate-400 hover:text-red-700 transition">
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
                previewContainer.classList.remove('hidden');
                imgPreview.src = URL.createObjectURL(file)
            }
        }
    </script>
</body>
</html>