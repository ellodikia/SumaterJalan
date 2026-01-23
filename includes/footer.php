<footer class="bg-[#1a1a1a] text-slate-400 py-16 border-t border-white/5">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12 text-center md:text-left">
                <div>
                    <a href="index.php" class="text-2xl font-black text-white uppercase mb-4 block">Sumatera<span class="text-amber-500">Jalan</span></a>
                    <p class="text-sm leading-relaxed italic">
                        Platform dokumentasi keindahan alam dan budaya Pulau Sumatera. Menelusuri sejarah dari ujung Aceh hingga Lampung.
                    </p>
                </div>
                
                <div class="flex flex-col space-y-3 uppercase text-[10px] font-bold tracking-widest">
                    <span class="text-white mb-2 text-xs">Navigasi</span>
                    <a href="index.php" class="hover:text-amber-500 transition">Beranda</a>
                    <a href="eksplor.php" class="hover:text-amber-500 transition">Eksplorasi</a>
                    <a href="#" class="hover:text-amber-500 transition">Galeri Budaya</a>
                </div>

                <div>
                    <span class="text-white mb-4 text-xs font-bold uppercase tracking-widest block">Terhubung Dengan Kami</span>
                    <div class="flex justify-center md:justify-start gap-4">
                        <div class="h-10 w-10 bg-white/5 rounded-full border border-white/10 flex items-center justify-center hover:bg-red-700 hover:border-red-700 transition cursor-pointer">
                            <span class="text-white text-xs">IG</span>
                        </div>
                        <div class="h-10 w-10 bg-white/5 rounded-full border border-white/10 flex items-center justify-center hover:bg-red-700 hover:border-red-700 transition cursor-pointer">
                            <span class="text-white text-xs">FB</span>
                        </div>
                        <div class="h-10 w-10 bg-white/5 rounded-full border border-white/10 flex items-center justify-center hover:bg-red-700 hover:border-red-700 transition cursor-pointer">
                            <span class="text-white text-xs">YT</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-white/5 text-center">
                <p class="text-[10px] uppercase tracking-[0.3em] font-medium">
                    &copy; <?= date('Y'); ?> SumateraJalan. Dibuat dengan semangat <span class="text-red-600 font-bold">Bhineka Tunggal Ika</span>.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>