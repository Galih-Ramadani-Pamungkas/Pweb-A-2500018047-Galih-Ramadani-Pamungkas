<?php

$inventaris = [
    "BRG001" => ["nama" => "Laptop ASUS", "kategori" => "Elektronik", "stok" => 15, "harga" => 12000000],
    "BRG002" => ["nama" => "Mouse Logitech", "kategori" => "Aksesoris", "stok" => 50, "harga" => 350000],
    "BRG003" => ["nama" => "Keyboard Mechanical", "kategori" => "Aksesoris", "stok" => 30, "harga" => 750000],
    "BRG004" => ["nama" => "Monitor LG 24 inch", "kategori" => "Elektronik", "stok" => 10, "harga" => 2500000],
    "BRG005" => ["nama" => "Webcam HD", "kategori" => "Aksesoris", "stok" => 25, "harga" => 450000],
];
function tampilkanHeader() {
    echo "<h1>📦 Sistem Manajemen Inventaris</h1>";
    echo "<hr>";
}
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
function hitungTotalNilai($data) {
    $total = 0;
    foreach ($data as $barang) {
        $total += $barang['stok'] * $barang['harga'];
    }
    return $total;
}

function hitungTotalStok($data) {
    $totalStok = 0;
    foreach ($data as $barang) {
        $totalStok += $barang['stok'];
    }
    return $totalStok;
}


function cariBarangByKode($kode, $data) {
    if (array_key_exists($kode, $data)) {
        return $data[$kode];
    }
    return null;
}

function cariBarangByNama($namaCari, $data) {
    $hasil = [];
    foreach ($data as $kode => $barang) {
        if (stripos($barang['nama'], $namaCari) !== false) {
            $hasil[$kode] = $barang;
        }
    }
    return $hasil;
}

function filterByKategori($kategori, $data) {
    $hasil = [];
    foreach ($data as $kode => $barang) {
        if (strtolower($barang['kategori']) === strtolower($kategori)) {
            $hasil[$kode] = $barang;
        }
    }
    return $hasil;
}

function urutkanByHarga(&$data, $ascending = true) {
    uasort($data, function($a, $b) use ($ascending) {
        if ($ascending) {
            return $a['harga'] <=> $b['harga'];
        }
        return $b['harga'] <=> $a['harga'];
    });
}

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

function tampilkanStrukturArray($data, $judul = "Struktur Array") {
    echo "<h3>{$judul}</h3>";
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}


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
tampilkanHeader();

tampilkanInventaris($inventaris);

tampilkanStatistik($inventaris);

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

echo "<h2>📁 Filter Kategori: Aksesoris</h2>";
$aksesoris = filterByKategori("Aksesoris", $inventaris);
tampilkanInventaris($aksesoris);

echo "<h2>📈 Urutan Harga (Termurah ke Termahal)</h2>";
$dataUrut = $inventaris; 
urutkanByHarga($dataUrut, true);
tampilkanInventaris($dataUrut);

tampilkanStrukturArray($inventaris, "Debug: Struktur Data Inventaris");

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
