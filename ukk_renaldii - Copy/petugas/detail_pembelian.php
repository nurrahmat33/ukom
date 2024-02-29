<?php
include '../koneksi.php';
include "header.php";
include "navbar.php";
?>
<div class="card mt-2">
    <div class="card-body">
        <?php
        $PelangganID = $_GET['PelangganID'];
        $no = 1;
        $data = mysqli_query($koneksi,"SELECT * FROM pelanggan INNER JOIN penjualan ON pelanggan.PelangganID=penjualan.PelangganID");
        while($d = mysqli_fetch_array($data)){
            ?>
            <?php if ($d['PelangganID'] == $PelangganID) { ?>
            <table>
                <tr>
                    <td>ID Pelanggan</td>
                    <td>: <?= $d['PelangganID']; ?></td>
                </tr>
                <tr>
                    <td>Nama Pelanggan</td>
                    <td>: <?= $d['NamaPelanggan']; ?></td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>: <?= $d['NomorTelepon']; ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: <?= $d['Alamat']; ?></td>
                </tr>
                <tr>
                    <td>Total Pembelian</td>
                    <td>: Rp. <?= $d['TotalHarga']; ?></td>
                </tr>
            </table>
            <form method="post" action="tambah_detail_penjualan.php">
                <input type="text" name="PenjualanID" value="<?= $d['PenjualanID'] ?>" hidden>
                <input type="text" name="PelangganID" value="<?= $d['PelangganID'] ?>" hidden>   
                <button type="submit" class="btn btn-primary btn-sm mt-2">Tambah Barang</button>            
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Beli</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nos = 1;
                    $detailpenjualan = mysqli_query($koneksi,"SELECT * FROM detailpenjualan");
                    while($d_detailpenjualan = mysqli_fetch_array($detailpenjualan)){
                    ?>
                    <?php
                    if ($d_detailpenjualan['PenjualanID'] == $d['PenjualanID']) { ?>
                        <tr>
                            <td><?= $nos++; ?></td>
                            <td>
                                <form action="simpan_barang_beli.php" method="post">
                                    <div class="form-group">
                                        <input type="text" name="PelangganID" value="<?= $d['PelangganID']; ?>" hidden>
                                        <input type="text" name="DetailID" value="<?= $d_detailpenjualan['DetailID']; ?>" hidden>
                                        <select name="ProdukID" class="form-control" onchange="this.form.submit()">
                                            <option>--- Pilih Produk ---</option>
                                            <?php
                                            $no = 1;
                                            $produk = mysqli_query($koneksi,"SELECT * FROM produk");
                                            while($d_produk =  mysqli_fetch_array($produk)){
                                                ?>
                                                <option value="<?= $d_produk['ProdukID']; ?>" <?php if($d_produk['ProdukID']==$d_detailpenjualan['ProdukID']) { echo "selected"; }?>><?= $d_produk['NamaProduk']; ?></option>
                                            <?php } ?>                                     
                                        </select>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <form method="post" action="hitung_subtotal.php">
                                    <?php
                                    $produk = mysqli_query($koneksi,"SELECT * FROM produk");
                                    while($d_produk = mysqli_fetch_array($produk)){
                                        ?>
                                        <?php
                                        if ($d_produk['ProdukID']==$d_detailpenjualan['ProdukID']) { ?>
                                            <input type="text" name="Harga" value=<?= $d_produk['Harga']; ?> hidden>
                                            <input type="text" name="ProdukID" value=<?= $d_produk['ProdukID']; ?> hidden>
                                            <input type="text" name="Stok" value=<?= $d_produk['Stok']; ?> hidden>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="form-group">
                                        <input type="number" name="JumblahProduk" value="<?= $d_detailpenjualan['JumblahProduk']; ?>" class="form-control">
                                    </div>
                                </td>
                                <td><?= $d_detailpenjualan['Subtotal']; ?></td>
                                <td>
                                    <input type="text" name="DetailID" value="<?= $d_detailpenjualan['DetailID']; ?>" hidden>
                                    <input type="text" name="PelangganID" value="<?= $d['PelangganID']; ?> "hidden>
                                    <button type="submit" class="btn btn-warning btn-sm">Proses</button>
                                </form>
                                <form method="post" action="hapus_detail_pembelian.php">
                                    <input type="text" name="PelangganID" value="<?= $d['PelangganID']; ?>" hidden>
                                    <input type="text" name="DetailID" value="<?= $d_detailpenjualan['DetailID']; ?> "hidden>
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php } else {
                        ?>
                        <?php
                    }    
                    }
                    ?>
                </tbody>
            </table>
            <form method="post" action="simpan_total_harga.php">
                <?php
                $detailpenjualan =  mysqli_query($koneksi, "SELECT SUM(subtotal) AS TotalHarga FROM detailpenjualan WHERE PenjualanID='$d[PenjualanID]'");
                $row =  mysqli_fetch_assoc($detailpenjualan);
                $sum = $row['TotalHarga'];
                ?>
                <div class="row">
                    <div class="col-sm-10">
                        <div class="form-group">
                            <input type="text" class="form-control" name="TotalHarga" value="<?= $sum ?>">
                            <input type="text"  name="PelangganID" value="<?= $d['PelangganID'] ?>" hidden>
                            <input type="text"  name="PenjualanID" value="<?= $d['PenjualanID'] ?>" hidden>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <button class="btn btn-info btn-sm form-control" type="submit">simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        <?php } else { ?>
            <?php
        }
        }
        ?>
    </div>
</div>

<?php
include "footer.php";
?>