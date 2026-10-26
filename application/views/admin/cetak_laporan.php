<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan - Hotel & Resort Greenstarpark Simalungun</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h3 {
            margin-bottom: 5px;
        }
        .header p {
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            text-align: right;
            margin-top: 30px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h3>HOTEL & RESORT GREENSTARPARK SIMALUNGUN</h3>
        <p>Jl. Asahan, Simpang Kubah Huta III, Nagori Perdagangan II, Kecamatan Bandar, Kabupaten Simalungun, Sumatera Utara</p>
        <hr>
        
        <?php if($tipe == 'ketersediaan'): ?>
            <h4>LAPORAN KETERSEDIAAN KAMAR</h4>
            <p>Tanggal: <?php echo date('d F Y'); ?></p>
        <?php elseif($tipe == 'transaksi'): ?>
            <h4>LAPORAN TRANSAKSI SEWA KAMAR</h4>
            <?php if(!empty($dari) && !empty($sampai)): ?>
                <p>Periode: <?php echo date('d-m-Y',strtotime($dari)); ?> s/d <?php echo date('d-m-Y',strtotime($sampai)); ?></p>
            <?php else: ?>
                <p>Periode: Semua Transaksi</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    
    <?php if($tipe == 'ketersediaan'): ?>
    <!-- Cetak Laporan Ketersediaan Kamar -->
    <table>
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
                <td class="text-right">Rp. <?php echo number_format($k->harga_kamar, 0, ',', '.'); ?>,-</td>
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
    
    <?php elseif($tipe == 'transaksi'): ?>
    <!-- Cetak Laporan Transaksi -->
    <table>
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
                <td class="text-right">Rp. <?php echo number_format($p->extend, 0, ',', '.'); ?>,-</td>
                <td class="text-right">Rp. <?php echo number_format($p->total_extend, 0, ',', '.'); ?>,-</td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="7" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp. <?php echo number_format($total, 0, ',', '.'); ?>,-</strong></td>
            </tr>
        </tbody>
    </table>
    <?php endif; ?>
    
    <div class="footer">
        <p>Simalungun, <?php echo date('d F Y'); ?></p>
        <br><br><br>
        <p>(_____________________)</p>
        <p>Manager Hotel</p>
    </div>
</body>
</html>
