<?php 
require_once 'config/database.php'; 

$query = "SELECT lokasi.*, provinsi.nama_provinsi, kategori.nama_kategori 
          FROM lokasi 
          JOIN provinsi ON lokasi.provinsi_id = provinsi.id 
          JOIN kategori ON lokasi.kategori_id = kategori.id 
          ORDER BY lokasi.id DESC LIMIT 6";
$locations = $pdo->query($query)->fetchAll();

include 'includes/header.php';
?>

<header class="relative h-[500px] flex items-center justify-center text-white overflow-hidden">
    <div class="absolute inset-0 bg-black/50 z-10"></div>
    <img src="for_sumaterajalan/bg1.png" class="absolute inset-0 w-full h-full object-cover" alt="Budaya Sumatera">
    <div class="relative z-20 text-center px-6">
        <h1 class="text-5xl md:text-6xl font-black mb-4 tracking-tight">SUMATERA<span class="text-amber-400">JALAN</span></h1>
        <p class="text-xl font-light tracking-widest uppercase">Menelusuri Jejak Swarnadwipa</p>
    </div>
</header>

<section class="py-20 bg-[#1a1a1a] text-white">
    <div class="container mx-auto px-6 max-w-4xl text-center">
        <div class="flex justify-center gap-2 mb-8">
            <div class="h-2 w-12 bg-red-700"></div>
            <div class="h-2 w-12 bg-amber-500"></div>
            <div class="h-2 w-12 bg-white"></div>
        </div>
        
        <h2 class="text-3xl font-bold mb-8 text-amber-400">Tentang Pulau Sumatera</h2>
        
        <div class="text-lg leading-relaxed text-slate-300 space-y-6 text-justify">
            <p>
                <span class="text-5xl font-serif float-left mr-3 text-red-600">P</span>ulau Sumatera adalah salah satu pulau terbesar di dunia yang terletak di bagian barat Indonesia. Dikenal dengan sebutan <span class="text-amber-500 italic font-semibold">"Swarnadwipa"</span> atau Pulau Emas, Sumatera menyimpan kekayaan alam yang luar biasa, mulai dari gugusan pegunungan Bukit Barisan yang megah hingga hamparan hutan hujan tropis yang menjadi rumah bagi satwa endemik seperti Harimau Sumatera dan Gajah.
            </p>
            <p>
                Terdapat keberagaman budaya yang sangat kental di sini. Sumatera dihuni oleh berbagai suku besar seperti suku Minangkabau yang terkenal dengan Rumah Gadang dan filosofi adatnya, suku Batak yang kaya akan seni Gorga dan tradisi luhur di sekitar Danau Toba, hingga suku Melayu, Aceh, Palembang, dan Lampung yang masing-masing membawa corak warna tersendiri dalam kain tenun Songket maupun Ulos.
            </p>
            <p>
                Lebih dari sekadar tempat wisata, Sumatera adalah perpaduan harmonis antara situs sejarah kerajaan besar masa lalu seperti Sriwijaya, kekayaan kuliner yang telah mendunia, serta keramah-tamahan penduduknya. Di sinilah setiap perjalanan akan menjadi sebuah kisah yang tak terlupakan tentang warisan leluhur Nusantara.
            </p>
        </div>
    </div>
</section>

<section class="relative -mt-10 z-30 px-6">
    <form action="pencarian.php" method="GET" class="bg-white p-3 rounded-2xl flex shadow-2xl max-w-2xl mx-auto border-4 border-red-700">
        <input type="text" name="keyword" placeholder="Cari destinasi di Sumatera..." class="flex-1 p-3 text-slate-800 outline-none">
        <button class="bg-red-700 px-8 py-3 rounded-xl font-bold hover:bg-red-800 transition text-white">Cari</button>
    </form>
</section>

<main class="container mx-auto px-6 py-24">
    <div class="flex items-center gap-4 mb-12">
        <div class="h-10 w-2 bg-red-700"></div>
        <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter">Destinasi Terbaru</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <?php foreach($locations as $loc): ?>
        <div class="group bg-white rounded-none border-b-4 border-red-700 overflow-hidden shadow-xl flex flex-col hover:shadow-2xl transition-all">
            <div class="relative h-60">
                <img src="assets/uploads/<?= $loc['foto_utama'] ?>" class="w-full h-full object-cover grayscale-[30%] group-hover:grayscale-0 transition duration-500" alt="<?= $loc['nama_tempat'] ?>">
                <div class="absolute bottom-0 left-0 bg-amber-500 text-black font-bold px-4 py-1 text-xs">
                    <?= $loc['nama_provinsi'] ?>
                </div>
            </div>
            <div class="p-8">
                <span class="text-red-700 text-xs font-bold uppercase tracking-widest"><?= $loc['nama_kategori'] ?></span>
                <h3 class="text-xl font-bold mt-2 mb-4 text-slate-800 group-hover:text-red-700 transition"><?= $loc['nama_tempat'] ?></h3>
                <p class="text-slate-500 text-sm line-clamp-2 mb-6"><?= $loc['deskripsi'] ?></p>
                <a href="detail.php?slug=<?= $loc['slug'] ?>" class="text-sm font-black border-b-2 border-amber-500 pb-1 hover:text-red-700 transition">LIHAT DETAIL</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<?php 
include 'includes/footer.php'; 
?>