<?php
/**
 * Sistem Manajemen Inventaris Sederhana
 * Memanfaatkan Array dan Function di PHP
 */

// ===== DATA INVENTARIS (Array Asosiatif) =====
$inventaris = [
    "BRG001" => ["nama" => "Laptop ASUS", "kategori" => "Elektronik", "stok" => 15, "harga" => 12000000],
    "BRG002" => ["nama" => "Mouse Logitech", "kategori" => "Aksesoris", "stok" => 50, "harga" => 350000],
    "BRG003" => ["nama" => "Keyboard Mechanical", "kategori" => "Aksesoris", "stok" => 30, "harga" => 750000],
    "BRG004" => ["nama" => "Monitor LG 24 inch", "kategori" => "Elektronik", "stok" => 10, "harga" => 2500000],
    "BRG005" => ["nama" => "Webcam HD", "kategori" => "Aksesoris", "stok" => 25, "harga" => 450000],
];

// ===== FUNGSI-FUNGSI =====

/**
 * Fungsi tanpa return value & tanpa parameter
 * Menampilkan header aplikasi
 */
function tampilkanHeader() {
    echo "<h1>📦 Sistem Manajemen Inventaris</h1>";
    echo "<hr>";
}

/**
 * Fungsi tanpa return value tapi dengan parameter
 * Menampilkan seluruh data inventaris dalam tabel
 */
function tampilkanInventaris($data) {
    echo "<h2>Daftar Barang</h2>";
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<tr style='background-color: #4CAF50; color: white;'>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga</th>
          </tr>";
    
    // Menggunakan foreach untuk array asosiatif
    foreach ($data as $kode => $barang) {
        echo "<tr>";
        echo "<td>{$kode}</td>";
        echo "<td>{$barang['nama']}</td>";
        echo "<td>{$barang['kategori']}</td>";
        echo "<td>{$barang['stok']}</td>";
        echo "<td>Rp " . number_format($barang['harga'], 0, ',', '.') . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
}

/**
 * Fungsi dengan return value & parameter
 * Menghitung total nilai inventaris
 */
function hitungTotalNilai($data) {
    $total = 0;
    foreach ($data as $barang) {
        $total += $barang['stok'] * $barang['harga'];
    }
    return $total;
}

/**
 * Fungsi dengan return value
 * Menghitung jumlah total item
 */
function hitungTotalStok($data) {
    $totalStok = 0;
    foreach ($data as $barang) {
        $totalStok += $barang['stok'];
    }
    return $totalStok;
}

/**
 * Fungsi untuk mencari barang berdasarkan kode
 * Menggunakan array_key_exists()
 */
function cariBarangByKode($kode, $data) {
    if (array_key_exists($kode, $data)) {
        return $data[$kode];
    }
    return null;
}

/**
 * Fungsi untuk mencari barang berdasarkan nama
 * Menggunakan foreach dan pencocokan string
 */
function cariBarangByNama($namaCari, $data) {
    $hasil = [];
    foreach ($data as $kode => $barang) {
        if (stripos($barang['nama'], $namaCari) !== false) {
            $hasil[$kode] = $barang;
        }
    }
    return $hasil;
}

/**
 * Fungsi untuk filter berdasarkan kategori
 */
function filterByKategori($kategori, $data) {
    $hasil = [];
    foreach ($data as $kode => $barang) {
        if (strtolower($barang['kategori']) === strtolower($kategori)) {
            $hasil[$kode] = $barang;
        }
    }
    return $hasil;
}

/**
 * Fungsi untuk mengurutkan berdasarkan harga
 * Passing by reference untuk memodifikasi array asli
 */
function urutkanByHarga(&$data, $ascending = true) {
    uasort($data, function($a, $b) use ($ascending) {
        if ($ascending) {
            return $a['harga'] <=> $b['harga'];
        }
        return $b['harga'] <=> $a['harga'];
    });
}

/**
 * Fungsi untuk menampilkan statistik
 */
function tampilkanStatistik($data) {
    $totalNilai = hitungTotalNilai($data);
    $totalStok = hitungTotalStok($data);
    $jumlahJenis = count($data);
    
    echo "<h2>📊 Statistik Inventaris</h2>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><td><strong>Jumlah Jenis Barang</strong></td><td>{$jumlahJenis} jenis</td></tr>";
    echo "<tr><td><strong>Total Stok</strong></td><td>{$totalStok} unit</td></tr>";
    echo "<tr><td><strong>Total Nilai Inventaris</strong></td><td>Rp " . number_format($totalNilai, 0, ',', '.') . "</td></tr>";
    echo "</table><br>";
}

/**
 * Fungsi untuk menampilkan struktur array (debugging)
 */
function tampilkanStrukturArray($data, $judul = "Struktur Array") {
    echo "<h3>{$judul}</h3>";
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

// ===== EKSEKUSI PROGRAM =====
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inventaris PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; margin-bottom: 20px; }
        h2 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 5px; }
        .hasil-cari { background-color: #fff3cd; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>

<?php
// 1. Tampilkan header
tampilkanHeader();

// 2. Tampilkan semua inventaris
tampilkanInventaris($inventaris);

// 3. Tampilkan statistik
tampilkanStatistik($inventaris);

// 4. Demo pencarian by kode
echo "<h2>🔍 Pencarian Barang</h2>";
$kodeCari = "BRG003";
$hasilCari = cariBarangByKode($kodeCari, $inventaris);
if ($hasilCari) {
    echo "<div class='hasil-cari'>";
    echo "<strong>Hasil pencarian kode '{$kodeCari}':</strong><br>";
    echo "Nama: {$hasilCari['nama']}<br>";
    echo "Kategori: {$hasilCari['kategori']}<br>";
    echo "Stok: {$hasilCari['stok']}<br>";
    echo "Harga: Rp " . number_format($hasilCari['harga'], 0, ',', '.');
    echo "</div><br>";
}

// 5. Demo filter kategori
echo "<h2>📁 Filter Kategori: Aksesoris</h2>";
$aksesoris = filterByKategori("Aksesoris", $inventaris);
tampilkanInventaris($aksesoris);

// 6. Demo pengurutan (passing by reference)
echo "<h2>📈 Urutan Harga (Termurah ke Termahal)</h2>";
$dataUrut = $inventaris; // Copy array
urutkanByHarga($dataUrut, true);
tampilkanInventaris($dataUrut);

// 7. Tampilkan struktur array untuk debugging
tampilkanStrukturArray($inventaris, "Debug: Struktur Data Inventaris");

// 8. Cek fungsi yang tersedia
echo "<h2>ℹ️ Info Fungsi</h2>";
$fungsiUser = ["tampilkanHeader", "tampilkanInventaris", "hitungTotalNilai", 
               "cariBarangByKode", "filterByKategori", "urutkanByHarga"];
echo "<strong>User Defined Functions yang dibuat:</strong><br>";
foreach ($fungsiUser as $f) {
    $status = function_exists($f) ? "✅ Ada" : "❌ Tidak ada";
    echo "- {$f}(): {$status}<br>";
}
?>

</body>
</html>
