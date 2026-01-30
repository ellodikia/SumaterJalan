<?php

$current_page = basename($_SERVER['PHP_SELF']);
?>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }
</script>

<nav class="bg-slate-900 text-white sticky top-0 z-50 shadow-2xl border-b border-white/5">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center h-20">
            
            <div class="flex items-center gap-10">
                <a href="../index.php" class="group flex items-center gap-3">
                    <div class="bg-red-700 p-2 rotate-45 group-hover:rotate-0 transition-transform duration-500">
                        <div class="-rotate-45 group-hover:rotate-0 transition-transform duration-500">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col border-l border-white/20 pl-4">
                        <span class="text-xl font-black uppercase tracking-tighter leading-none">
                            Sumatera<span class="text-amber-500">Jalan</span>
                        </span>
                        <span class="text-[9px] font-bold uppercase tracking-[0.3em] text-slate-400 mt-1"><a href="register.php">Administrator</a></span>
                    </div>
                </a>

                <div class="hidden md:flex gap-8 items-center h-20">
                    <?php 
                    $nav_items = [
                        ['lokasi', 'lokasi_kelola.php', 'Kelola Lokasi'],
                        ['kuliner', 'kuliner_kelola.php', 'Kelola Kuliner'],
                        ['budaya', 'budaya_kelola.php', 'Kelola Budaya']
                    ];

                    foreach ($nav_items as $item): 
                        $is_active = (strpos($current_page, $item[0]) !== false);
                    ?>
                        <a href="<?= $item[1] ?>" 
                           class="relative h-full flex items-center text-[10px] font-black uppercase tracking-widest transition duration-300 <?= $is_active ? 'text-amber-500' : 'text-slate-400 hover:text-white' ?>">
                            <?= $item[2] ?>
                            <?php if ($is_active): ?>
                                <span class="absolute bottom-0 left-0 w-full h-1 bg-amber-500 shadow-[0_-4px_10px_rgba(245,158,11,0.5)]"></span>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="logout.php" target="_blank" 
                   class="hidden sm:flex items-center gap-2 text-[10px] font-black uppercase tracking-widest bg-slate-800 border border-slate-700 px-5 py-3 hover:bg-red-700 hover:border-red-700 transition duration-300 shadow-lg">
                    Logout
                </a>

                <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-slate-400 hover:text-white transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-slate-800 border-t border-white/5 animate-in slide-in-from-top duration-300">
        <div class="flex flex-col p-6 gap-4">
            <?php foreach ($nav_items as $item): 
                $is_active = (strpos($current_page, $item[0]) !== false);
            ?>
                <a href="<?= $item[1] ?>" 
                   class="text-xs font-black uppercase tracking-widest p-4 rounded-sm <?= $is_active ? 'bg-amber-500 text-slate-900' : 'bg-white/5 text-slate-300 hover:bg-white/10' ?>">
                    <?= $item[2] ?>
                </a>
            <?php endforeach; ?>
            
            <hr class="border-white/10 my-2">
            
            <a href="logout.php" target="_blank" class="text-center text-[10px] font-black uppercase tracking-widest bg-red-700 text-white p-4">
                Logout
            </a>
        </div>
    </div>
</nav>

<div class="mb-10"></div>