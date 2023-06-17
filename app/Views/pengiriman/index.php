<?php
$user_detail = session()->get('user_detail');

$add_priv = false;
if($user_detail['id_role'] == '2') {
  $add_priv = true;
}
?>

<?= $this->extend('layout/index') ?>

<?= $this->section("title") ?>
<div class="main-title">
  <h2 class="prevent-select"></h2>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4 mt-4">
  <h2 class="mr-auto">List Pengiriman <?=date('d-m-Y')?></h2>
  <?php if($add_priv) { ?>
  <a role="button" href="<?= base_url('pengiriman/tambah') ?>" class="btn btn-theme-1">Tambah Data Baru</a>
  <?php } ?>
</div>

<div class="container-md">
  <!-- START TABLE SEARCH -->
  <div class="filter-table">
    <table id="indexTable">
      <thead>
        <tr>
          <th>No</th>
          <th>No. Resi</th>
          <th>Tanggal Masuk</th>
          <th>Pengirim</th>
          <th>Penerima</th>
          <th>Destinasi</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- END TABLE SEARCH -->
</div>

<?= $this->endSection() ?>

<?= $this->section('post_load') ?>
<script>
  var indexTable = $("#indexTable").DataTable({
    language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' },
    processing: true,
    serverSide: true,
    fixedHeader: true,
    searching: true,
    pagingNUmber: 'simple_numbers',
    bFilter: true,
    order: ['1', 'ASC'],
    // ajax: "/assets/data/list_pengiriman.json",
    ajax: {
      method: 'POST',
      url: '<?= base_url('pengiriman/getAllDashboard') ?>',
      data: function(data) {
        data.search = {
          value: $('#indexTable_filter input[type="search"]').val(),
          regex: true
        }
      }
    },
    columns: [{
        data: "no",
        orderable: false,
        sWidth: '1%',
      },
      {
        data: "no_resi",
        orderable: true,
      },
      {
        data: "tanggal_masuk",
        orderable: true,
      },
      {
        data: "pengirim",
        orderable: true,
      },
      {
        data: "penerima",
        orderable: true,
      },
      {
        data: "destinasi",
        orderable: true,
      },
      {
        data: "status",
        orderable: true,
      },
      {
        data: "no_resi",
        orderable: false,
        sWidth: "10%",
        render: function(data, type, row) {
          edval = '<div class="btn-group">';
          if(row.cuser_id == '<?=$user_detail['user_id']?>') {
            edval += `<a href="<?= base_url('/pengiriman/edit') ?>/${row.no_resi}" class="btn-sm btn-success">Detail</a>`;
            edval += `<a href="<?= base_url('/pengiriman/detail') ?>/${row.no_resi}" class="btn-sm btn-danger">Hapus</a>`;
          } else {
            edval += `<a href="<?= base_url('/pengiriman/view') ?>/${row.no_resi}" class="btn-sm btn-success">Detail</a>`;
          }
          edval += '</div>';
          return edval;
        }
      },
    ],
  });

  $('#search_submit').click(function() {
    indexTable.draw();
  });
</script>
<?= $this->endSection() ?>