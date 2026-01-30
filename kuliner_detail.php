<?php
require_once 'config/database.php';
include 'includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT kuliner.*, provinsi.nama_provinsi 
          FROM kuliner 
          LEFT JOIN provinsi ON kuliner.asal_provinsi_id = provinsi.id 
          WHERE kuliner.id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$k = $stmt->fetch();

if (!$k) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='kuliner.php';</script>";
    exit;
}

$tempat_stmt = $pdo->prepare("SELECT * FROM kuliner_tempat WHERE kuliner_id = ? ORDER BY nama_toko ASC");
$tempat_stmt->execute([$id]);
$daftar_tempat = $tempat_stmt->fetchAll();
?>

<main class="container mx-auto px-6 py-8 md:py-12">
    <nav class="flex flex-wrap text-[10px] md:text-sm text-slate-500 mb-6 md:mb-8 font-medium uppercase tracking-wider">
        <a href="index.php" class="hover:text-red-700 transition">Beranda</a>
        <span class="mx-2">/</span>
        <a href="kuliner.php" class="hover:text-red-700 transition">Kuliner</a>
        <span class="mx-2">/</span>
        <span class="font-bold text-slate-800 tracking-tight"><?= $k['nama_kuliner'] ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
        <div class="lg:col-span-2">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-slate-900 mb-6 md:mb-8 leading-tight tracking-tighter uppercase">
                <?= $k['nama_kuliner'] ?>
            </h1>
            
            <div class="mb-8 md:mb-10 rounded-none border-l-4 md:border-l-8 border-red-700 overflow-hidden shadow-2xl">
                <img src="assets/uploads/<?= $k['foto'] ?>" 
                     class="w-full h-[250px] sm:h-[400px] md:h-[550px] object-cover" 
                     alt="<?= $k['nama_kuliner'] ?>">
            </div>

            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed mb-12 md:mb-16">
                <div class="flex items-center gap-3 mb-4 md:mb-6">
                    <div class="h-6 md:h-8 w-1.5 bg-amber-500"></div>
                    <h3 class="text-xl md:text-2xl font-black uppercase tracking-widest text-slate-900">Narasi Rasa</h3>
                </div>
                <p class="whitespace-pre-line text-base md:text-lg text-justify font-light italic border-l-4 border-slate-100 pl-4 md:pl-6">
                    <?= htmlspecialchars($k['deskripsi']) ?>
                </p>
            </div>

            <div class="mt-8 md:mt-12">
                <div class="flex items-center gap-3 mb-6 md:mb-8">
                    <div class="h-6 md:h-8 w-1.5 bg-red-700"></div>
                    <h3 class="text-xl md:text-2xl font-black uppercase tracking-widest text-slate-900">Tempat Menikmati</h3>
                </div>

                <?php if(empty($daftar_tempat)): ?>
                    <div class="p-8 border-2 border-dashed border-slate-200 text-center text-slate-400 uppercase text-[10px] font-bold tracking-widest">
                        Belum ada lokasi rekomendasi yang terdaftar.
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 gap-4">
                        <?php foreach($daftar_tempat as $t): ?>
                        <div class="bg-white p-5 md:p-6 border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center group hover:border-red-700 transition gap-4">
                            <div class="flex-1">
                                <h4 class="font-black text-slate-900 uppercase group-hover:text-red-700 transition text-sm md:text-base"><?= htmlspecialchars($t['nama_toko']) ?></h4>
                                <p class="text-xs md:text-sm text-slate-500 mt-1"><?= htmlspecialchars($t['alamat']) ?></p>
                            </div>
                            <?php if($t['link_maps']): ?>
                            <a href="<?= $t['link_maps'] ?>" target="_blank" class="w-full md:w-auto px-6 py-2 bg-slate-900 text-white text-[9px] md:text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                Petunjuk Jalan
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white p-6 md:p-8 rounded-none border-t-4 border-red-700 shadow-xl lg:sticky lg:top-28">
                <h3 class="text-lg md:text-xl font-black uppercase tracking-tighter text-slate-900 mb-6 md:mb-8 border-b pb-4">Informasi Sajian</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-6 md:gap-8">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-red-50 text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Wilayah Asal</p>
                            <p class="font-bold text-slate-800 text-base md:text-lg"><?= $k['nama_provinsi'] ?></p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-amber-50 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Klasifikasi</p>
                            <p class="font-bold text-slate-800 text-base md:text-lg"><?= $k['kategori_kuliner'] ?></p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-3 <?= $k['status_halal'] == 'Halal' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-600' ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Sertifikasi Halal</p>
                            <p class="font-bold <?= $k['status_halal'] == 'Halal' ? 'text-emerald-600' : 'text-slate-800' ?> text-base md:text-lg"><?= $k['status_halal'] ?></p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 md:mt-12 space-y-3 md:space-y-4">
                    <button onclick="window.print()" class="w-full bg-slate-900 text-white font-black uppercase tracking-widest py-3 md:py-4 rounded-none hover:bg-slate-800 transition flex items-center justify-center gap-2 shadow-lg text-[10px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Bagikan Narasi
                    </button>
                    
                    <a href="kuliner.php" class="w-full border-2 border-slate-900 text-slate-900 font-black uppercase tracking-widest py-3 md:py-4 rounded-none hover:bg-slate-900 hover:text-white transition flex items-center justify-center gap-2 text-[10px]">
                        ← Kembali ke Galeri
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>