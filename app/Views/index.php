<?php
?>

<?= $this->extend("layout/index") ?>

<?= $this->section("title") ?>
<div class="main-title">
  <h1 class="prevent-select">Track My Pack</h1>
</div>
<?= $this->endSection() ?>

<?= $this->section("content") ?>
<!-- Form Search -->
<div class="main-form">
  <form id="form_search">
    <input type="text" name="search_resi" id="search_resi" placeholder="Masukan Nomor Resi" style="padding:8px 16px;" />
    <button type="button" class="btn btn-outline-dark" id="search_submit">Track</button>
  </form>
</div>
<!-- End Form Search -->

<?php if(isset($user_detail) && $user_detail['logged_in']) { ?>
  <!-- START TABLE SEARCH -->
  <div class="filter-table">
    <table id="indexTable">
      <thead>
        <tr>
          <th>No</th>
          <th>No. Resi</th>
          <th>Pengirim</th>
          <th>Penerima</th>
          <th>Destinasi</th>
          <th>Status</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- END TABLE SEARCH -->
<?php } ?>

<?= $this->endSection() ?>


<?= $this->section("post_load") ?>
<?php if(isset($user_detail) && $user_detail['logged_in']) { ?>
  <!-- Datatable Index -->
  <script>
    var indexTable = $("#indexTable").DataTable({
      processing: true,
      serverSide: true,
      fixedHeader: true,
      searching: false,
      pagingNUmber: 'simple_numbers',
      bFilter: true,
      order: ['1', 'ASC'],
      // ajax: "/assets/data/list_pengiriman.json",
      ajax: {
        method: 'POST',
        url: '<?=base_url('/getAllDashboard')?>',
        data: function(data) {
          data.search = {
            value: $('#search_resi').val(),
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
      ],
    });

    $('#search_submit').click(function() {
      indexTable.draw();
    });
  </script>
<?php } else { ?>
  <script>
    $('#search_submit').click(function() {
      getDetail();
    });

    const getDetail = (resi) => {
      $.ajax({
        url: '<?=base_url('cekPengirimanResi')?>',
        type: 'POST',
        data: {
          resi: $('#search_resi').val()
        },
        success: (res) => {
          res = JSON.parse(res)
          status = res.status == 'success' ? 'success' : 'error'
          swalAlert(status, res.message);
        },
        error: (e) => {
          swalAlert('error', 'Gagal mendapatkan data')
        }
      })
    }
  </script>
<?php } ?>
<?= $this->endSection() ?>