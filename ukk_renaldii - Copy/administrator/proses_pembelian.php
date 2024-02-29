<?php

include '../koneksi.php';

// Pastikan semua nilai POST sudah di-set dan tidak kosong
if(isset($_POST['PelangganID']) && isset($_POST['NamaPelanggan']) && isset($_POST['Alamat']) && isset($_POST['NomorTelepon'])) {
    // Mengambil nilai dari $_POST
    $PelangganID = $_POST['PelangganID'];
    $NamaPelanggan = $_POST['NamaPelanggan'];
    $Alamat = $_POST['Alamat'];
    $NomorTelepon = $_POST['NomorTelepon'];

    // Query untuk memasukkan data ke tabel pelanggan
    $query_pelanggan = "INSERT INTO pelanggan (PelangganID, NamaPelanggan, Alamat, NomorTelepon) VALUES ('$PelangganID', '$NamaPelanggan', '$Alamat', '$NomorTelepon')";
    // Query untuk memasukkan data ke tabel penjualan
    $query_penjualan = "INSERT INTO penjualan (PelangganID) VALUES ('$PelangganID')";

    // Jalankan query
    $result_pelanggan = mysqli_query($koneksi, $query_pelanggan);
    $result_penjualan = mysqli_query($koneksi, $query_penjualan);

    // Periksa apakah query berhasil dijalankan
    if($result_pelanggan && $result_penjualan) {
        header("location:pembelian.php?pesan=simpan");
    } else {
        // Jika query gagal dijalankan
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Jika ada nilai POST yang kosong
    echo "Error: Semua nilai POST harus diisi.";
}
?>
