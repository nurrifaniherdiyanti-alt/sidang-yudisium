<?php
require_once 'config.php';

if (!is_dir(__DIR__ . '/keys')) {
    mkdir(__DIR__ . '/keys', 0777, true);
}

$privateKeyText = "";
$pesan = "";

if (isset($_POST['generate']) || !file_exists(PUBLIC_KEY_PATH)) {
    $config = [
        "digest_alg" => "sha256",
        "private_key_bits" => 2048,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    ];

    $res = @openssl_pkey_new($config);

    if (!$res) {
        $possiblePaths = [
            dirname(PHP_BINARY) . '/extras/ssl/openssl.cnf',
            dirname(PHP_BINARY) . '/openssl.cnf',
            'C:/xampp/apache/conf/openssl.cnf',
            'C:/xampp/php/extras/ssl/openssl.cnf'
        ];
        $laragonApache = glob('C:/laragon/bin/apache/*/conf/openssl.cnf');
        if (!empty($laragonApache)) {
            $possiblePaths = array_merge($laragonApache, $possiblePaths);
        }
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $config['config'] = $path;
                $res = @openssl_pkey_new($config);
                if ($res) break;
            }
        }
    }

    if ($res) {
        openssl_pkey_export($res, $privateKeyText, null, $config);
        $pubKeyDetails = openssl_pkey_get_details($res);
        file_put_contents(PUBLIC_KEY_PATH, $pubKeyDetails["key"]);
        $pesan = "Pasangan kunci RSA-2048 berhasil dibuat. Unduh Private Key di bawah ini untuk login ke Panel Admin.";
    } else {
        $pesan = "Gagal membuat kunci OpenSSL. Pastikan ekstensi openssl aktif di php.ini.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator Kunci RSA-2048 — SIBAYU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="bg-[#F5F0E9] text-[#34312E] min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-2xl bg-white border border-stone-200 rounded-2xl shadow-sm p-6 sm:p-8">
    <h1 class="text-xl font-bold mb-1">Generator Pasangan Kunci RSA-2048</h1>
    <p class="text-xs text-stone-500 mb-5">
        <strong>Public Key</strong> otomatis tersimpan di <span class="font-mono">keys/public_key.pem</span>, sedangkan <strong>Private Key</strong> digunakan sebagai kunci masuk admin.
    </p>

    <?php if ($pesan): ?>
        <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800">
            <?= htmlspecialchars($pesan) ?>
        </div>
    <?php endif; ?>

    <?php if ($privateKeyText): ?>
        <div class="mb-4">
            <label class="block text-xs font-bold text-red-700 mb-1.5">Private Key Admin (Wajib Disimpan):</label>
            <textarea id="privKeyBox" rows="11" readonly
                      class="w-full text-xs font-mono border border-stone-300 rounded-xl p-3 bg-stone-50"><?= htmlspecialchars($privateKeyText) ?></textarea>
        </div>
        <button onclick="downloadPem()" class="bg-[#756454] hover:bg-[#5E4F42] text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition">
            Unduh private_key.pem
        </button>
    <?php else: ?>
        <div class="p-3.5 rounded-xl bg-[#F5F0E9] text-xs text-stone-600 mb-4">
            Pasangan kunci saat ini sudah aktif. Jangan klik tombol generate ulang kecuali kamu ingin mengganti kunci login yang lama.
        </div>
        <form method="POST">
            <button type="submit" name="generate" class="text-xs font-semibold text-red-600 border border-red-200 hover:bg-red-50 px-3.5 py-2 rounded-xl transition">
                Generate Ulang Kunci Baru
            </button>
        </form>
    <?php endif; ?>

    <div class="mt-6 pt-4 border-t border-stone-100 flex gap-3">
        <a href="index.php" class="text-xs font-semibold px-4 py-2 rounded-xl border border-stone-300 hover:bg-stone-50 transition">
            Ke Landing Page
        </a>
        <a href="login.php" class="text-xs font-semibold px-4 py-2 rounded-xl bg-[#34312E] hover:bg-black text-white transition">
            Ke Login Admin
        </a>
    </div>
</div>

<script>
function downloadPem() {
    const text = document.getElementById('privKeyBox').value;
    const blob = new Blob([text], { type: 'application/x-pem-file' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'private_key.pem';
    a.click();
}
</script>
</body>
</html>