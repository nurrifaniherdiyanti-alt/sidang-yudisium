<?php

/**
 * Verifikasi kecocokan Private Key admin terhadap Public Key sistem
 */
function verifyPrivateKey($privateKeyPem, $publicKeyPath) {
    if (!file_exists($publicKeyPath) || empty(trim($privateKeyPem))) {
        return false;
    }

    $pubKey  = @openssl_pkey_get_public(file_get_contents($publicKeyPath));
    $privKey = @openssl_pkey_get_private($privateKeyPem);

    if (!$pubKey || !$privKey) {
        return false;
    }

    $challenge = "VERIFIKASI_ADMIN_SIDANG_YUDISIUM";
    $encrypted = "";
    $decrypted = "";

    if (!@openssl_public_encrypt($challenge, $encrypted, $pubKey)) {
        return false;
    }
    if (!@openssl_private_decrypt($encrypted, $decrypted, $privKey)) {
        return false;
    }

    return ($decrypted === $challenge);
}

/**
 * Enkripsi Hybrid Berita Acara Sidang (AES-256-CBC + RSA-2048)
 */
function hybridEncryptBeritaAcara($data, $publicKeyPath) {
    $pubKey = openssl_pkey_get_public(file_get_contents($publicKeyPath));

    // 1. Buat kunci simetris AES-256 (32 byte) dan IV (16 byte) acak
    $aesKey = random_bytes(32);
    $iv     = random_bytes(16);

    // 2. Enkripsi seluruh konten admin dengan Kriptografi Simetris (AES-256-CBC)
    $namaEnc         = openssl_encrypt($data['nama_mahasiswa'], 'AES-256-CBC', $aesKey, 0, $iv);
    $nimEnc          = openssl_encrypt($data['nim'], 'AES-256-CBC', $aesKey, 0, $iv);
    $prodiEnc        = openssl_encrypt($data['prodi'], 'AES-256-CBC', $aesKey, 0, $iv);
    $ketuaPengujiEnc = openssl_encrypt($data['ketua_penguji'], 'AES-256-CBC', $aesKey, 0, $iv);
    $catatanEnc      = openssl_encrypt($data['catatan_revisi'], 'AES-256-CBC', $aesKey, 0, $iv);
    $keputusanEnc    = openssl_encrypt($data['keputusan_sidang'], 'AES-256-CBC', $aesKey, 0, $iv);

    // 3. Enkripsi kunci AES dengan Kriptografi Asimetris (RSA-2048 Public Key)
    openssl_public_encrypt($aesKey, $encryptedAesKey, $pubKey);

    return [
        'nama_mahasiswa_enc'   => $namaEnc,
        'nim_enc'              => $nimEnc,
        'prodi_enc'            => $prodiEnc,
        'ketua_penguji_enc'    => $ketuaPengujiEnc,
        'catatan_revisi_enc'   => $catatanEnc,
        'keputusan_sidang_enc' => $keputusanEnc,
        'encrypted_aes_key'    => base64_encode($encryptedAesKey),
        'iv'                   => base64_encode($iv)
    ];
}

/**
 * Dekripsi Hybrid Berita Acara Sidang (RSA-2048 Private Key + AES-256-CBC)
 */
function hybridDecryptBeritaAcara($row, $privateKeyPem) {
    $privKey = @openssl_pkey_get_private($privateKeyPem);
    if (!$privKey) {
        return false;
    }

    // 1. Dekripsi kunci AES menggunakan RSA Private Key
    $encryptedAesKey = base64_decode($row['encrypted_aes_key']);
    if (!@openssl_private_decrypt($encryptedAesKey, $aesKey, $privKey)) {
        return false;
    }

    // 2. Dekripsi seluruh konten berita acara menggunakan AES-256-CBC
    $iv = base64_decode($row['iv']);

    return [
        'id'               => $row['id'],
        'nama_mahasiswa'   => openssl_decrypt($row['nama_mahasiswa_enc'], 'AES-256-CBC', $aesKey, 0, $iv),
        'nim'              => openssl_decrypt($row['nim_enc'], 'AES-256-CBC', $aesKey, 0, $iv),
        'prodi'            => openssl_decrypt($row['prodi_enc'], 'AES-256-CBC', $aesKey, 0, $iv),
        'ketua_penguji'    => openssl_decrypt($row['ketua_penguji_enc'], 'AES-256-CBC', $aesKey, 0, $iv),
        'catatan_revisi'   => openssl_decrypt($row['catatan_revisi_enc'], 'AES-256-CBC', $aesKey, 0, $iv),
        'keputusan_sidang' => openssl_decrypt($row['keputusan_sidang_enc'], 'AES-256-CBC', $aesKey, 0, $iv),
        'created_at'       => $row['created_at']
    ];
}
?>