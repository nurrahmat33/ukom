<?php
$koneksi = mysqli_connect("localhost","root","","kasir_renaldi");

if (mysqli_connect_error()){
    echo "koneksi database gagal : " . mysqli_connect_error();
}
?>