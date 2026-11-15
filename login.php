<?php
require_once 'config.php';
require_once 'crypto_helper.php';

if (isset($_SESSION['admin_private_key'])) {
    header("Location: admin.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $privateKeyInput = "";

    if (isset($_FILES['private_key_file']) && $_FILES['private_key_file']['error'] === UPLOAD_ERR_OK) {
        $privateKeyInput = file_get_contents($_FILES['private_key_file']['tmp_name']);
    } elseif (!empty(trim($_POST['private_key_text']))) {
        $privateKeyInput = trim($_POST['private_key_text']);
    }

    if (verifyPrivateKey($privateKeyInput, PUBLIC_KEY_PATH)) {
        $_SESSION['admin_private_key'] = $privateKeyInput;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Akses ditolak! Private Key tidak valid atau tidak cocok dengan Public Key server.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Input Private Key</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="bg-[#F5F0E9] text-[#34312E] min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-md bg-white border border-stone-200 rounded-2xl shadow-sm p-6 sm:p-8">
    <div class="text-center mb-6">
        <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full bg-[#F5F0E9] text-[#5E4F42] mb-3">
            Autentikasi Asimetris RSA-2048
        </span>
        <h1 class="text-2xl font-bold tracking-tight">Login Panel Admin</h1>
        <p class="text-xs text-stone-500 mt-1">Masukkan <strong>Private Key</strong> untuk mendekripsi berita acara sidang.</p>
    </div>

    <?php if ($error): ?>
        <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block text-xs font-bold mb-1.5">Unggah File Kunci (<span class="font-mono">private_key.pem</span>)</label>
            <input type="file" name="private_key_file" accept=".pem,.txt,.key"
                   class="block w-full text-xs text-stone-600 border border-stone-300 rounded-xl p-2 bg-stone-50 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#34312E] file:text-white hover:file:bg-black cursor-pointer">
        </div>

        <div class="relative flex py-1 items-center">
            <div class="flex-grow border-t border-stone-200"></div>
            <span class="flex-shrink mx-3 text-xs text-stone-400">atau tempel teks kunci</span>
            <div class="flex-grow border-t border-stone-200"></div>
        </div>

        <div>
            <label class="block text-xs font-bold mb-1.5">Isi Private Key</label>
            <textarea name="private_key_text" rows="6"
                      placeholder="-----BEGIN PRIVATE KEY-----&#10;...&#10;-----END PRIVATE KEY-----"
                      class="w-full text-xs font-mono border border-stone-300 rounded-xl p-3 bg-stone-50 focus:bg-white focus:outline-none focus:border-[#756454]"></textarea>
        </div>

        <button type="submit" class="w-full bg-[#756454] hover:bg-[#5E4F42] text-white font-semibold text-sm py-2.5 rounded-xl transition">
            Verifikasi Kunci & Masuk
        </button>
    </form>

    <div class="mt-6 pt-4 border-t border-stone-100 flex justify-between text-xs">
        <a href="index.php" class="text-stone-500 hover:text-[#34312E]">&larr; Kembali ke Beranda</a>
        <a href="generate_keys.php" class="font-semibold text-[#756454] hover:text-[#5E4F42]">Generate Kunci RSA</a>
    </div>
</div>

</body>
</html>