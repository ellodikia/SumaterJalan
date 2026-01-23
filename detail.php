<?php
require_once 'config/database.php';

if (!isset($_GET['slug'])) {
    header("Location: index.php");
    exit;
}

$slug = $_GET['slug'];

$query = "SELECT lokasi.*, provinsi.nama_provinsi, kategori.nama_kategori 
          FROM lokasi 
          JOIN provinsi ON lokasi.provinsi_id = provinsi.id 
          JOIN kategori ON lokasi.kategori_id = kategori.id 
          WHERE lokasi.slug = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$slug]);
$data = $stmt->fetch();

if (!$data) {
    header("Location: index.php");
    exit;
}

include 'includes/header.php';
?>

<main class="container mx-auto px-6 py-12">
    <nav class="flex text-sm text-slate-500 mb-8 font-medium">
        <a href="index.php" class="hover:text-red-700 transition">Beranda</a>
        <span class="mx-2">/</span>
        <span class="text-slate-400"><?= $data['nama_provinsi'] ?></span>
        <span class="mx-2">/</span>
        <span class="font-bold text-slate-800 tracking-tight"><?= $data['nama_tempat'] ?></span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2">
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 mb-8 leading-tight tracking-tighter uppercase">
                <?= $data['nama_tempat'] ?>
            </h1>
            
            <div class="mb-10 rounded-none border-l-8 border-red-700 overflow-hidden shadow-2xl">
                <img src="assets/uploads/<?= $data['foto_utama'] ?>" 
                     class="w-full h-[400px] md:h-[600px] object-cover" 
                     alt="<?= $data['nama_tempat'] ?>">
            </div>

            <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed">
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-8 w-1.5 bg-amber-500"></div>
                    <h3 class="text-2xl font-black uppercase tracking-widest text-slate-900">Tentang Destinasi</h3>
                </div>
                <p class="whitespace-pre-line text-lg text-justify font-light italic border-l-4 border-slate-100 pl-6">
                    <?= $data['deskripsi'] ?>
                </p>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-none border-t-4 border-red-700 shadow-xl sticky top-28">
                <h3 class="text-xl font-black uppercase tracking-tighter text-slate-900 mb-8 border-b pb-4">Informasi Wisata</h3>
                
                <div class="space-y-8">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-red-50 text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Provinsi</p>
                            <p class="font-bold text-slate-800 text-lg"><?= $data['nama_provinsi'] ?></p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-amber-50 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kategori Wisata</p>
                            <p class="font-bold text-slate-800 text-lg"><?= $data['nama_kategori'] ?></p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 space-y-4">
                    <?php if(!empty($data['link_maps'])): ?>
                    <a href="<?= $data['link_maps'] ?>" target="_blank" class="w-full bg-red-700 text-white font-black uppercase tracking-widest py-4 rounded-none hover:bg-red-800 transition shadow-lg flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        Petunjuk Jalan
                    </a>
                    <?php endif; ?>

                    <button onclick="window.print()" class="w-full bg-slate-900 text-white font-black uppercase tracking-widest py-4 rounded-none hover:bg-slate-800 transition flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Bagikan
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php 
include 'includes/footer.php'; 
?>