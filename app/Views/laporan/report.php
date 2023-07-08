<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $filename ?></title>
</head>

<style>
  header {
    text-align: center;
    margin-top: 3rem;
  }

  header h2 {
    margin: 0.2rem 0;
    font-family: Arial, Helvetica, sans-serif;
    text-transform: uppercase;
  }

  main {
    margin: 3rem;
  }

  table.customTable {
    width: 100%;
    background-color: #ffffff;
    border-collapse: collapse;
    border-width: 2px;
    border-color: #020300;
    border-style: solid;
    color: #000000;
  }

  table.customTable td,
  table.customTable th {
    border-width: 2px;
    border-color: #020300;
    border-style: solid;
    padding: 5px;
  }

  table.customTable thead {
    background-color: #48e1f8;
  }

  footer {
    margin: 0 5rem;
    float:right;
    text-align: right;
  }

  table.customTable tr,
  table.customTable td {
    font-size: 0.8rem;
  }
</style>

<body>
  <img src="<?= $logo ?>" alt="" width="300" />
  <header>
    <h2>Track My Pack</h2>
    <h2>Laporan Pengiriman</h2>
    <?php if($config['tanggal_masuk'] == '' && $config['tanggal_keluar'] == '') { ?>
      <h2><?=date('d/m/Y')?></h2>
    <?php } else { ?>
      <h2><?=$config['tanggal_masuk'] != '' ? date('d/m/Y', strtotime($config['tanggal_masuk'])) . ' - ' : '' ?><?= $config['tanggal_keluar'] == '' ? date('d/m/Y') : date('d/m/Y', strtotime($config['tanggal_keluar'])) ?></h2>
    <?php } ?>
  </header>
  <main>
    <table class="customTable">
      <thead>
        <tr>
          <th>No resi</th>
          <th>Status pengiriman</th>
          <th>Nama pengirim</th>
          <th>Alamat pengirim</th>
          <th>Nama penerima</th>
          <th>Alamat penerima</th>
          <th>No HP penerima</th>
          <th>Nama barang</th>
          <th>Berat barang</th>
          <th>Tanggal dikirim</th>
          <th>Tanggal diterima</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($data as $v) {
          $html = "<tr>
          <td>$v->no_resi</td>
          <td>$v->status</td>
          <td>$v->nama_pengirim</td>
          <td>$v->alamat_pengirim</td>
          <td>$v->nama_penerima</td>
          <td>$v->alamat_penerima</td>
          <td>$v->nomor_penerima</td>
          <td>$v->nama_barang</td>
          <td>$v->berat_barang Kg</td>
          <td>$v->tanggal_dikirim</td>
          <td>$v->tanggal_diterima</td>
          </tr>";
          echo $html;
        } ?>
      </tbody>
    </table>
  </main>
  <footer>
    <div class="footer-ttd">
      <?php
      $weekdays = array(
        'Minggu', 'Senin', 'Selasa', 'Rabu',
        'Kamis', 'Jumat', 'Sabtu'
       );
       $months = array(null,
        'Januari', 'Februaru', 'Maret', 'April',
        'Mei', 'Juni', 'Juli', 'Agustus',
        'September', 'Oktober', 'November',
        'Desember'
       );
       $weekday = $weekdays[ date('w') ];
       $month   = $months[ date('n') ];
       $day     = date('d');
       $year    = date('Y');
       
       echo "<p>Jakarta, $weekday $day $month $year</p>";
      ?>
      <br />
      <p><?= $user_detail['nama'] ?></p>
    </div>
  </footer>
</body>

</html>