<?php
include "../koneksi.php";

$Stok = $_POST['Stok'];
$ProdukID = $_POST['ProdukID'];
$JumblahProduk = $_POST['JumblahProduk'];
$Harga = $_POST['Harga'];
$DetailID = $_POST['DetailID'];
$PelangganID = $_POST['PelangganID'];
$Subtotal = $JumblahProduk * $Harga;
$Stok_total = $Stok - $JumblahProduk;

mysqli_query($koneksi,"update detailpenjualan set Subtotal='$Subtotal', JumblahProduk= '$JumblahProduk' where DetailID= '$DetailID'");
mysqli_query($koneksi,"update produk set Stok= '$Stok_total' where ProdukID= '$ProdukID'");

header("location:detail_pembelian.php?PelangganID=$PelangganID");
?>