<?php
require_once 'config.php';

$qJadwal    = mysqli_query($conn, "SELECT * FROM tbl_jadwal_sidang ORDER BY tanggal ASC");
$qSyarat    = mysqli_query($conn, "SELECT * FROM tbl_syarat_yudisium ORDER BY id ASC");
$qKalender  = mysqli_query($conn, "SELECT * FROM tbl_kalender_akademik ORDER BY id ASC");
$qArsipEnc  = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_berita_acara");
$totalArsip = mysqli_fetch_assoc($qArsipEnc)['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBAYU — Sistem Portal Sidang Skripsi & Yudisium Teknik Informatika</title>
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
        <a href="index.php" class="font-bold text-lg tracking-tight text-[#34312E]">
            SIBAYU <span class="font-normal text-stone-400">| Teknik Informatika</span>
        </a>
        <div class="flex items-center gap-6">
            <div class="hidden md:flex items-center gap-6 text-sm font-medium text-stone-600">
                <a href="#jadwal" class="hover:text-[#34312E] transition">Jadwal Sidang</a>
                <a href="#syarat" class="hover:text-[#34312E] transition">Syarat Yudisium</a>
                <a href="#kalender" class="hover:text-[#34312E] transition">Kalender Akademik</a>
            </div>
            <a href="login.php" class="bg-[#756454] hover:bg-[#5E4F42] text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                Login Admin (Private Key)
            </a>
        </div>
    </div>
</nav>

<!-- Hero -->
<header class="bg-white border-b border-stone-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 lg:py-16 grid lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-8">
            <span class="inline-block text-xs font-semibold tracking-wide uppercase px-3 py-1 rounded-full bg-[#F5F0E9] text-[#5E4F42] border border-stone-200 mb-4">
                Program Studi Teknik Informatika
            </span>
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-[#34312E] mb-4">
                Sistem Portal Berita Acara <br> Sidang Skripsi & Yudisium
            </h1>
            <p class="text-stone-600 leading-relaxed max-w-2xl mb-6">
                Pusat informasi resmi jadwal seminar dan sidang terbuka, persyaratan pemberkasan yudisium, serta kalender akademik program studi. Seluruh berita acara, catatan revisi dewan penguji, dan keputusan kelulusan pra-pengumuman diamankan menggunakan kriptografi <strong class="text-[#34312E]">AES-256 & RSA-2048</strong>.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="login.php" class="bg-[#34312E] hover:bg-black text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition">
                    Akses Panel Admin (Private Key)
                </a>
                <a href="#jadwal" class="bg-white hover:bg-stone-50 text-[#34312E] border border-stone-300 text-sm font-semibold px-5 py-2.5 rounded-xl transition">
                    Lihat Jadwal Sidang
                </a>
            </div>
        </div>

        <div class="lg:col-span-4">
            <div class="bg-[#F5F0E9] border border-stone-200 rounded-2xl p-6">
                <h2 class="font-bold text-base text-[#34312E] mb-2">Brankas Berita Acara Sidang</h2>
                <p class="text-sm text-stone-600 leading-relaxed mb-4">
                    Saat ini terdapat <strong class="text-[#34312E]"><?= $totalArsip ?> dokumen berita acara</strong> yang tersimpan di database dalam status terenkripsi (<em>Ciphertext</em>).
                </p>
                <div class="pt-3 border-t border-stone-300/70 flex items-center justify-between text-xs">
                    <span class="font-mono font-medium text-[#5E4F42]">AES-256 + RSA-2048</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-[#34312E] text-white font-semibold">Terkunci</span>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="max-w-6xl mx-auto px-4 sm:px-6 py-12 space-y-12">

    <!-- 1. Jadwal Seminar & Sidang -->
    <section id="jadwal">
        <div class="mb-4">
            <p class="text-xs font-bold uppercase tracking-wider text-[#756454]">Agenda Terbuka</p>
            <h2 class="text-xl font-bold text-[#34312E]">1. Jadwal Seminar & Sidang Skripsi</h2>
        </div>

        <div class="bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse md:table-fixed">
                    <thead>
                        <tr class="bg-stone-50 border-b border-stone-200 text-[11px] font-bold uppercase tracking-wider text-stone-500 text-center">
                            <th class="px-6 py-3.5 md:w-[20%]">Tanggal & Waktu</th>
                            <th class="px-6 py-3.5 md:w-[24%]">Mahasiswa</th>
                            <th class="px-6 py-3.5 md:w-[36%]">Judul Skripsi</th>
                            <th class="px-6 py-3.5 md:w-[20%]">Ruangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100 text-sm">
                        <?php while ($j = mysqli_fetch_assoc($qJadwal)): ?>
                        <tr class="hover:bg-stone-50/70 transition">
                            <td class="px-6 py-4 align-top">
                                <div class="font-semibold text-[#34312E]"><?= date('d M Y', strtotime($j['tanggal'])) ?></div>
                                <div class="text-xs text-stone-500 mt-0.5"><?= htmlspecialchars($j['waktu']) ?></div>
                            </td>
                            <td class="px-6 py-4 align-top font-semibold text-[#34312E]">
                                <?= htmlspecialchars($j['nama_mahasiswa']) ?>
                            </td>
                            <td class="px-6 py-4 align-top text-stone-600 leading-relaxed">
                                <?= htmlspecialchars($j['judul_skripsi']) ?>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-lg bg-[#F5F0E9] text-[#5E4F42] border border-stone-200">
                                    <?= htmlspecialchars($j['ruangan']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- 2 & 3. Syarat Yudisium & Kalender Akademik -->
    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Syarat Yudisium -->
        <section id="syarat" class="flex flex-col">
            <div class="mb-4">
                <p class="text-xs font-bold uppercase tracking-wider text-[#756454]">Pemberkasan</p>
                <h2 class="text-xl font-bold text-[#34312E]">2. Pengumuman Syarat Yudisium</h2>
            </div>
            <div class="bg-white border border-stone-200 rounded-2xl shadow-sm p-6 flex-1 divide-y divide-stone-100">
                <?php $no = 1; while ($s = mysqli_fetch_assoc($qSyarat)): ?>
                <div class="py-3.5 first:pt-0 last:pb-0 flex gap-3.5">
                    <span class="w-7 h-7 rounded-full bg-[#F5F0E9] text-[#5E4F42] font-bold text-xs flex items-center justify-center shrink-0 mt-0.5">
                        <?= $no++ ?>
                    </span>
                    <div>
                        <h3 class="font-bold text-sm text-[#34312E]"><?= htmlspecialchars($s['judul_syarat']) ?></h3>
                        <p class="text-xs text-stone-600 leading-relaxed mt-1"><?= htmlspecialchars($s['keterangan']) ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </section>

        <!-- Kalender Akademik -->
        <section id="kalender" class="flex flex-col">
            <div class="mb-4">
                <p class="text-xs font-bold uppercase tracking-wider text-[#756454]">Linimasa</p>
                <h2 class="text-xl font-bold text-[#34312E]">3. Kalender Akademik Teknik Informatika</h2>
            </div>
            <div class="bg-white border border-stone-200 rounded-2xl shadow-sm overflow-hidden flex-1">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-stone-50 border-b border-stone-200 text-[11px] font-bold uppercase tracking-wider text-stone-500 text text-center">
                                <th class="px-5 py-3.5 w-[34%]">Periode</th>
                                <th class="px-5 py-3.5 w-[44%]">Kegiatan</th>
                                <th class="px-5 py-3.5 w-[22%]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 text-xs">
                            <?php while ($k = mysqli_fetch_assoc($qKalender)): ?>
                            <tr class="hover:bg-stone-50/70 transition">
                                <td class="px-5 py-4 font-semibold text-[#34312E]"><?= htmlspecialchars($k['periode_tanggal']) ?></td>
                                <td class="px-5 py-4 text-stone-600 leading-relaxed"><?= htmlspecialchars($k['kegiatan']) ?></td>
                                <td class="px-5 py-4">
                                    <?php
                                        if ($k['status'] === 'Berlangsung') {
                                            $badge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                        } elseif ($k['status'] === 'Selesai') {
                                            $badge = 'bg-stone-100 text-stone-600 border-stone-200';
                                        } else {
                                            $badge = 'bg-amber-50 text-amber-700 border-amber-200';
                                        }
                                    ?>
                                    <span class="inline-block px-2.5 py-1 rounded-full font-semibold border <?= $badge ?>">
                                        <?= htmlspecialchars($k['status']) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

</main>

<footer class="bg-white border-t border-stone-200 py-6 text-center text-xs font-bold text-stone-400">
    Sistem Portal Berita Acara Sidang Skripsi & Yudisium — Program Studi Teknik Informatika &copy; 2026
</footer>

</body>
</html>