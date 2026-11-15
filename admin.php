<?php
require_once 'config.php';
require_once 'crypto_helper.php';

if (!isset($_SESSION['admin_private_key'])) {
    header("Location: login.php");
    exit;
}

$privateKey = $_SESSION['admin_private_key'];
$notif = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $dataInput = [
        'nama_mahasiswa'   => trim($_POST['nama_mahasiswa']),
        'nim'              => trim($_POST['nim']),
        'prodi'            => trim($_POST['prodi']),
        'ketua_penguji'    => trim($_POST['ketua_penguji']),
        'catatan_revisi'   => trim($_POST['catatan_revisi']),
        'keputusan_sidang' => trim($_POST['keputusan_sidang']),
    ];

    $enc = hybridEncryptBeritaAcara($dataInput, PUBLIC_KEY_PATH);

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO tbl_berita_acara (nama_mahasiswa_enc, nim_enc, prodi_enc, ketua_penguji_enc, catatan_revisi_enc, keputusan_sidang_enc, encrypted_aes_key, iv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssss",
        $enc['nama_mahasiswa_enc'],
        $enc['nim_enc'],
        $enc['prodi_enc'],
        $enc['ketua_penguji_enc'],
        $enc['catatan_revisi_enc'],
        $enc['keputusan_sidang_enc'],
        $enc['encrypted_aes_key'],
        $enc['iv']
    );
    mysqli_stmt_execute($stmt);
    $notif = "Berita acara sidang berhasil dienkripsi (AES-256 + RSA-2048) dan disimpan ke database.";
}

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tbl_berita_acara WHERE id = $id");
    header("Location: admin.php");
    exit;
}

$result = mysqli_query($conn, "SELECT * FROM tbl_berita_acara ORDER BY id DESC");
$daftarBeritaAcara = [];
while ($row = mysqli_fetch_assoc($result)) {
    $decrypted = hybridDecryptBeritaAcara($row, $privateKey);
    if ($decrypted) {
        $decrypted['raw_ciphertext'] = $row;
        $daftarBeritaAcara[] = $decrypted;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin — Berita Acara Sidang Skripsi & Yudisium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="bg-[#F5F0E9] text-[#34312E] antialiased">

<!-- Navbar -->
<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-stone-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <span class="font-bold text-base sm:text-lg tracking-tight">Panel Admin Berita Acara</span>
            <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                Private Key Aktif
            </span>
        </div>
        <div class="flex items-center gap-2">
            <a href="index.php" class="text-xs font-semibold px-3.5 py-2 rounded-xl border border-stone-300 bg-white hover:bg-stone-50 transition">
                Landing Page
            </a>
            <a href="logout.php" class="text-xs font-semibold px-3.5 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white transition">
                Logout
            </a>
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
    <?php if ($notif): ?>
        <div class="mb-6 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-800 font-medium">
            <?= htmlspecialchars($notif) ?>
        </div>
    <?php endif; ?>

    <div class="grid lg:grid-cols-12 gap-6 items-start">
        <!-- Form Input -->
        <div class="lg:col-span-4 bg-white border border-stone-200 rounded-2xl shadow-sm p-6">
            <h2 class="font-bold text-base mb-1">Input Berita Acara Sidang</h2>
            <p class="text-xs text-stone-500 mb-4">Data otomatis dienkripsi sebelum masuk ke MySQL.</p>

            <form method="POST" class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold mb-1">Nama Mahasiswa</label>
                    <input type="text" name="nama_mahasiswa" required placeholder="Contoh: Budi Santoso"
                           class="w-full text-sm border border-stone-300 rounded-xl px-3 py-2 bg-stone-50 focus:bg-white focus:outline-none focus:border-[#756454]">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">NIM</label>
                    <input type="text" name="nim" required placeholder="Contoh: 2230511045"
                           class="w-full text-sm border border-stone-300 rounded-xl px-3 py-2 bg-stone-50 focus:bg-white focus:outline-none focus:border-[#756454]">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Program Studi</label>
                    <input type="text" name="prodi" value="Teknik Informatika" required
                           class="w-full text-sm border border-stone-300 rounded-xl px-3 py-2 bg-stone-50 focus:bg-white focus:outline-none focus:border-[#756454]">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Nama Ketua Penguji</label>
                    <input type="text" name="ketua_penguji" required placeholder="Contoh: Dr. Hendra Wijaya, M.Kom."
                           class="w-full text-sm border border-stone-300 rounded-xl px-3 py-2 bg-stone-50 focus:bg-white focus:outline-none focus:border-[#756454]">
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Catatan Revisi Sidang</label>
                    <textarea name="catatan_revisi" rows="3" required placeholder="Tuliskan poin revisi dari dewan penguji..."
                              class="w-full text-sm border border-stone-300 rounded-xl px-3 py-2 bg-stone-50 focus:bg-white focus:outline-none focus:border-[#756454]"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Keputusan Sidang</label>
                    <select name="keputusan_sidang" required
                            class="w-full text-sm border border-stone-300 rounded-xl px-3 py-2 bg-stone-50 focus:bg-white focus:outline-none focus:border-[#756454]">
                        <option value="Lulus Tanpa Revisi">Lulus Tanpa Revisi</option>
                        <option value="Lulus Dengan Revisi">Lulus Dengan Revisi</option>
                        <option value="Mengulang Sidang">Mengulang Sidang</option>
                    </select>
                </div>
                <button type="submit" name="simpan" class="w-full bg-[#756454] hover:bg-[#5E4F42] text-white font-semibold text-sm py-2.5 rounded-xl transition mt-2">
                    Enkripsi & Simpan Data
                </button>
            </form>
        </div>

        <!-- Daftar Berita Acara Terdekripsi -->
        <div class="lg:col-span-8 bg-white border border-stone-200 rounded-2xl shadow-sm p-6">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-stone-100">
                <div>
                    <h2 class="font-bold text-base">Arsip Berita Acara Terdekripsi (Plaintext)</h2>
                    <p class="text-xs text-stone-500">Seluruh konten didekripsi otomatis menggunakan sesi Private Key.</p>
                </div>
                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-[#F5F0E9] text-[#5E4F42]">
                    <?= count($daftarBeritaAcara) ?> Dokumen
                </span>
            </div>

            <?php if (count($daftarBeritaAcara) > 0): ?>
                <div class="space-y-4">
                    <?php foreach ($daftarBeritaAcara as $ba): ?>
                        <div class="p-4 rounded-xl border border-stone-200 bg-stone-50/50">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                        <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-[#F5F0E9] text-[#5E4F42] border border-stone-200">
                                            <?= htmlspecialchars($ba['prodi']) ?>
                                        </span>
                                        <?php
                                            if ($ba['keputusan_sidang'] === 'Lulus Tanpa Revisi') {
                                                $kepBadge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                            } elseif ($ba['keputusan_sidang'] === 'Lulus Dengan Revisi') {
                                                $kepBadge = 'bg-amber-50 text-amber-700 border-amber-200';
                                            } else {
                                                $kepBadge = 'bg-red-50 text-red-700 border-red-200';
                                            }
                                        ?>
                                        <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full border <?= $kepBadge ?>">
                                            <?= htmlspecialchars($ba['keputusan_sidang']) ?>
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-base text-[#34312E]">
                                        <?= htmlspecialchars($ba['nama_mahasiswa']) ?>
                                        <span class="font-normal text-sm text-stone-500">(<?= htmlspecialchars($ba['nim']) ?>)</span>
                                    </h3>
                                </div>
                                <a href="?hapus=<?= $ba['id'] ?>" onclick="return confirm('Hapus berita acara ini?')"
                                   class="text-xs font-semibold text-red-600 hover:text-red-800 px-2.5 py-1 rounded-lg hover:bg-red-50 transition">
                                    Hapus
                                </a>
                            </div>

                            <p class="text-xs text-stone-600 mb-2">
                                Ketua Penguji: <strong class="text-[#34312E]"><?= htmlspecialchars($ba['ketua_penguji']) ?></strong>
                            </p>

                            <div class="text-xs bg-[#F5F0E9]/70 border border-stone-200/70 rounded-lg p-3 mb-3 leading-relaxed">
                                <span class="block text-[11px] font-semibold text-stone-500 mb-0.5">Catatan Revisi:</span>
                                <?= nl2br(htmlspecialchars($ba['catatan_revisi'])) ?>
                            </div>

                            <details>
                                <summary class="text-xs font-semibold text-[#756454] hover:text-[#5E4F42] cursor-pointer select-none">
                                    Lihat Bukti Ciphertext di Database MySQL
                                </summary>
                                <div class="mt-2 p-3 rounded-lg bg-white border border-dashed border-stone-300 text-[11px] font-mono text-stone-600 break-all space-y-1">
                                    <div><strong class="text-[#34312E]">nama_mahasiswa_enc:</strong> <?= htmlspecialchars($ba['raw_ciphertext']['nama_mahasiswa_enc']) ?></div>
                                    <div><strong class="text-[#34312E]">nim_enc:</strong> <?= htmlspecialchars($ba['raw_ciphertext']['nim_enc']) ?></div>
                                    <div><strong class="text-[#34312E]">prodi_enc:</strong> <?= htmlspecialchars($ba['raw_ciphertext']['prodi_enc']) ?></div>
                                    <div><strong class="text-[#34312E]">ketua_penguji_enc:</strong> <?= htmlspecialchars($ba['raw_ciphertext']['ketua_penguji_enc']) ?></div>
                                    <div><strong class="text-[#34312E]">catatan_revisi_enc:</strong> <?= htmlspecialchars($ba['raw_ciphertext']['catatan_revisi_enc']) ?></div>
                                    <div><strong class="text-[#34312E]">keputusan_sidang_enc:</strong> <?= htmlspecialchars($ba['raw_ciphertext']['keputusan_sidang_enc']) ?></div>
                                    <div><strong class="text-[#34312E]">encrypted_aes_key (RSA):</strong> <?= htmlspecialchars(substr($ba['raw_ciphertext']['encrypted_aes_key'], 0, 70)) ?>...</div>
                                </div>
                            </details>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12 text-sm text-stone-400">
                    Belum ada berita acara sidang. Tambahkan data melalui formulir di sebelah kiri.
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

</body>
</html>