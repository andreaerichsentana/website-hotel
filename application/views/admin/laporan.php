<div class="page-header">
    <h3>Laporan Hotel & Resort Greenstarpark Simalungun</h3>
</div>

<?php if(empty($tipe) || $tipe == ''): ?>
<!-- HALAMAN PILIHAN LAPORAN -->
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Laporan Ketersediaan Kamar</h3>
            </div>
            <div class="panel-body">
                <p>Laporan ini berisi informasi tentang ketersediaan kamar hotel saat ini.</p>
                <a href="<?php echo base_url().'admin/laporan?tipe=ketersediaan' ?>" class="btn btn-primary btn-sm">Lihat Laporan</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Laporan Transaksi Sewa Kamar</h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo base_url().'admin/laporan?tipe=transaksi' ?>" method="post">
                    <div class="form-group">
                        <label>Dari Tanggal</label>
                        <input class="form-control" type="date" name="dari" required>
                    </div>
                    <div class="form-group">
                        <label>Sampai Tanggal</label>
                        <input class="form-control" type="date" name="sampai" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Lihat Laporan" class="btn btn-primary btn-sm">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php elseif($tipe == 'ketersediaan'): ?>
<!-- LAPORAN KETERSEDIAAN KAMAR -->
<div class="page-header">
    <h3>Laporan Ketersediaan Kamar</h3>
</div>

<a href="<?php echo base_url().'admin/laporan' ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
<br/><br/>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kamar</th>
                <th>No. Kamar</th>
                <th>Tipe Kamar</th>
                <th>Tipe Kasur</th>
                <th>Lokasi</th>
                <th>Harga/Hari</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach($kamar as $k){ 
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $k->nama_kamar; ?></td>
                <td><?php echo $k->no_kamar; ?></td>
                <td>
                    <?php 
                    $id_tipe = $k->id_tipe;
                    $tipe = $this->db->query("SELECT * FROM tipekamar WHERE id_tipe='$id_tipe'")->row();
                    echo $tipe->tipe_kamar;
                    ?>
                </td>
                <td><?php echo $k->tipe_kasur; ?></td>
                <td><?php echo $k->lokasi; ?></td>
                <td>Rp. <?php echo number_format($k->harga_kamar, 0, ',', '.'); ?>,-</td>
                <td>
                    <?php
                    if($k->status_kamar == "1"){
                        echo "Tersedia";
                    }else{
                        echo "Disewa";
                    }
                    ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="pull-right">
    <a href="<?php echo base_url().'admin/cetak_laporan?tipe=ketersediaan' ?>" class="btn btn-success" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak</a>
</div>

<?php elseif($tipe == 'transaksi'): ?>
<!-- LAPORAN TRANSAKSI -->
<div class="page-header">
    <h3>Laporan Transaksi Sewa Kamar</h3>
</div>

<a href="<?php echo base_url().'admin/laporan' ?>" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
<br/><br/>

<?php 
if(!empty($dari) && !empty($sampai)){
?>
    <div class="alert alert-info">
        Laporan Transaksi dari tanggal <b><?php echo date('d-m-Y',strtotime($dari)); ?></b> sampai dengan <b><?php echo date('d-m-Y',strtotime($sampai)); ?></b>
    </div>
<?php } ?>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Kamar</th>
                <th>Tgl Check-in</th>
                <th>Tgl Check-out</th>
                <th>Harga/Hari</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $total = 0;
            foreach($penyewaan as $p){ 
                $total += $p->total_extend;
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo date('d/m/Y', strtotime($p->tgl_bayar)); ?></td>
                <td><?php echo $p->nama_pelanggan; ?></td>
                <td><?php echo $p->nama_kamar; ?></td>
                <td><?php echo date('d/m/Y', strtotime($p->tgl_cekin)); ?></td>
                <td><?php echo date('d/m/Y', strtotime($p->tgl_cekout)); ?></td>
                <td>Rp. <?php echo number_format($p->extend, 0, ',', '.'); ?>,-</td>
                <td>Rp. <?php echo number_format($p->total_extend, 0, ',', '.'); ?>,-</td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="7" class="text-right"><strong>TOTAL</strong></td>
                <td><strong>Rp. <?php echo number_format($total, 0, ',', '.'); ?>,-</strong></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="pull-right">
    <?php 
    if(!empty($dari) && !empty($sampai)){
    ?>
        <a href="<?php echo base_url().'admin/cetak_laporan?tipe=transaksi&dari='.$dari.'&sampai='.$sampai ?>" class="btn btn-success" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak</a>
    <?php }else{ ?>
        <a href="<?php echo base_url().'admin/cetak_laporan?tipe=transaksi' ?>" class="btn btn-success" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak</a>
    <?php } ?>
</div>

<?php endif; ?>
