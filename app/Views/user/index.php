<?php
$user_detail = session()->get('user_detail');

$add_priv = false;
if($user_detail['id_role'] == '1') {
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
  <h2 class="mr-auto">Daftar Pengguna</h2>
  <?php if($add_priv) { ?>
  <a role="button" href="<?= base_url('user/tambah') ?>" class="btn btn-theme-1">Tambah Data Baru</a>
  <?php } ?>
</div>

<div class="container-md">
  <!-- START TABLE SEARCH -->
  <div class="filter-table">
    <table id="indexTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Username</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Nomor HP</th>
          <th>Role</th>
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
    order: ['0', 'ASC'],
    ajax: {
      method: 'POST',
      url: '<?= base_url('user/getAllDashboard') ?>',
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
        data: "username",
        orderable: true,
      },
      {
        data: "nama",
        orderable: true,
      },
      {
        data: "email",
        orderable: true,
      },
      {
        data: "nomor_hp",
        orderable: true,
      },
      {
        data: "nama_role",
        orderable: true,
      },
      {
        data: "id",
        orderable: false,
        sWidth: "10%",
        render: function(data, type, row) {
          edval = '<div class="btn-group">';
          edval += `<a href="<?= base_url('/user/edit') ?>/${row.id}" class="btn-sm btn-success">Detail</a>`;
          if(row.id != 1) {
              edval += `<a role="button" onclick="del('${row.id}')" class="btn-sm btn-danger">Hapus</a>`;
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

  function del(id) {
    Swal.fire({
      icon: 'question',
      title: 'Apakah anda yakin ingin menghapus data ini?',
      showClass: { popup: 'animate__animated animate__fadeInDown' },
      hideClass: { popup: 'animate__animated animate__fadeOutUp' },
      showConfirmButton: true,
      showCancelButton: true,
      reverseButtons: true,
    }).then((isConfirm) => {
      if(isConfirm.isConfirmed) {
        try {
          $.ajax({
            url: `<?=base_url('user/delete')?>`,
            method: "POST",
            data: { id : id },
          }).done(function(res) {
            res = JSON.parse(res);
            if (res.status == 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Data sukses terhapus',
                showConfirmButton: true,
              }).then((isConfirm) => {
                location.reload();
              });
            } else {
              var msg = 'Data gagal terhapus: ' + res.message
              swalAlert('error', msg);
            }
          });
        } catch (err) {
          console.log(err)
          alert(err.message ?? err)
        }
      }
    });
  }
</script>
<?= $this->endSection() ?>