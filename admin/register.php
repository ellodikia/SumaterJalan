<?php
require_once '../config/database.php';

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Konfirmasi password tidak cocok!";
    } else {
        $check = $pdo->prepare("SELECT id FROM admin WHERE username = ?");
        $check->execute([$username]);
        
        if ($check->rowCount() > 0) {
            $message = "Username sudah terdaftar!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO admin (nama, username, password) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([$nama, $username, $hashed_password])) {
                $success = true;
                $message = "Admin baru berhasil didaftarkan!";
            } else {
                $message = "Terjadi kesalahan saat mendaftar.";
            }
        }
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
    <title>Register Admin - SumateraJalan</title>
</head>
<body class="bg-slate-900 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        <div class="flex flex-col items-center mb-8">
            <h1 class="text-2xl font-black uppercase tracking-tighter text-white">
                Register <span class="text-red-700">New Admin</span>
            </h1>
        </div>

        <div class="bg-white p-8 shadow-2xl border-t-8 border-slate-700">
            <?php if ($message): ?>
                <div class="<?= $success ? 'bg-emerald-50 text-emerald-700 border-emerald-500' : 'bg-red-50 text-red-700 border-red-500' ?> p-4 mb-6 text-[10px] font-black uppercase tracking-widest border-l-4 italic">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-5">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" required 
                           class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 outline-none focus:border-slate-900 transition font-bold text-slate-800">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Username</label>
                    <input type="text" name="username" required 
                           class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 outline-none focus:border-slate-900 transition font-bold text-slate-800">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Password</label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 outline-none focus:border-slate-900 transition font-bold text-slate-800">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" required 
                           class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 outline-none focus:border-slate-900 transition font-bold text-slate-800">
                </div>

                <div class="flex flex-col gap-3 pt-2">
                    <button type="submit" 
                            class="w-full bg-slate-900 text-white py-4 font-black uppercase tracking-widest text-xs hover:bg-red-700 transition duration-300 shadow-xl">
                        Daftarkan Admin
                    </button>
                    <a href="budaya_kelola.php" class="text-center text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-red-700 transition">
                        Batal & Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>