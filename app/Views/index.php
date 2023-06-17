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

<!-- Data detail -->
<div id="resi_result" class="table-responsive resi_result mt-2">
</div>
<!-- End Data detail -->

<?php if (1 == 0 && isset($user_detail) && $user_detail['logged_in']) { ?>
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
<?php if (isset($user_detail) && $user_detail['logged_in']) { ?>
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
        url: '<?= base_url('/getAllDashboard') ?>',
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

    const getDetail = () => {
      var data = $('#search_resi').val();
      if (data && data != '') {
        $.ajax({
          url: '<?= base_url('cekPengirimanResi'); ?>',
          type: 'POST',
          data: {
            resi: data
          },
          success: (res) => {
            res = JSON.parse(res);
            if (res.status == 'success') {
              $('#resi_result').html('')
              var data = res.data;
              var html = `
                <table class="table">
                  <thead>
                    <tr>
                      <th>No Resi</th>
                      <td colspan="3">${data.no_resi}</td>
                      <th>Status</th>
                      <td><b>${data.status}<b></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>Pengirim</th>
                      <td colspan="3">${data.nama_pengirim}</td>
                      <th>Nomor HP</th>
                      <td>${data.nomor_pengirim}</td>
                    </tr>
                    <tr>
                      <th>Alamat</th>
                      <td colspan="5">${data.alamat_pengirim}</td>
                    </tr>
                    <tr>
                      <th>Penerima</th>
                      <td colspan="3">${data.nama_penerima}</td>
                      <th>Nomor HP</th>
                      <td>${data.nomor_penerima}</td>
                    </tr>
                    <tr>
                      <th>Alamat</th>
                      <td colspan="5">${data.alamat_penerima}</td>
                    </tr>
                    <tr>
                      <th>Nama Barang</th>
                      <td colspan="3">${data.nama_barang}</td>
                      <th>Berat</th>
                      <td>${data.berat_barang} KG</td>
                    </tr>
                    <thead>
                      <tr>
                        <th>Tanggal Masuk</th>
                        <td colspan="3">${data.tanggal_masuk}</td>
                        <th>Tanggal Keluar</th>
                        <td colspan="3">${data.tanggal_keluar}</td>
                      </tr>
                    </thead>
                  </tbody>
                </table>
              `;
              $('#resi_result').html(html);
            } else {
              swalAlert('error', res.message);
            }
          },
          error: (e) => {
            swalAlert('error', 'Gagal mendapatkan data')
          }
        })
      } else {
        swalAlert('error', 'No Resi tidak boleh kosong!')
      }
    }
  </script>
<?php } ?>
<?= $this->endSection() ?>