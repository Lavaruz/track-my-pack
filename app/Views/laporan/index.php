<?= $this->extend("layout/index") ?>

<?= $this->section("content") ?>
<div class="laporan-container">
    <h1 class="mb-3">Cetak Laporan</h1>
    <form id="form-report">
        <div class="mb-3">
            <label for="" class="form-label">Filter berdasarkan status pengiriman</label>
            <select name="status" id="status" class="form-control">
                <option value="">Pilih status pengiriman</option>
                <?php 
                  foreach($status as $v) { 
                    echo "<option value='$v[id]'>$v[nama]</option>";
                  } 
                ?>
              </select>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label for="tanggal_masuk" class="form-label">Filter Berdasarkan Tanggal Dikirim</label>
                <input type="text" class="form-control datepicker" name="tanggal_masuk" id="tanggal_masuk">
            </div>
            <div class="mb-3 col">
                <label for="tanggal_keluar" class="form-label">Filter Berdasarkan Tanggal Diterima</label>
                <input type="text" class="form-control datepicker" name="tanggal_keluar" id="tanggal_keluar">
            </div>
        </div>
        
      <button role="button" id="form-submit" class="btn btn-primary">Cetak Laporan</button>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('post_load') ?>
<!-- Initiator -->
<script>
  $(document).ready(function() {
    $('#status').select2({
      allowClear: true,
    });

    $('#tanggal_masuk, #tanggal_keluar').datepicker({
        format:"yyyy-mm-dd",
        todayHighlight: true,
        changeYear: true,
        changeMonth: true,
        showButtonPanel: true,
      });
  })
</script>

<!-- Submit -->
<script>
  $('#form-submit').click((e) => {
    e.preventDefault();
    $('#form-report').submit();
  })

  $('#form-report').submit((e) => {
    try {
      e.preventDefault();
      var fd = new FormData($('#form-report')[0]);
      var url = '<?=base_url('laporan')?>'

      $.ajax({
        url: url,
        method: "POST",
        data: fd,
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
      }).done(function(res) {
        if (res.status == 'success') {
          var downloadLink = document.createElement("a");
          var fileName = res.filename + '.pdf';
          downloadLink.href = atob(res.pathfile);
          downloadLink.download = fileName;
          downloadLink.click();
          setTimeout(() => {
            $.ajax({
              dataType: 'json',
              data: atob(res.pathfile),
              type: "POST",
              url: '<?= base_url('laporan/deleteTmpFile/') ?>',
            })
            swalAlert('success', 'Laporan sukses dicetak')
          }, 1000);
        } else {
          var msg = 'Laporan gagal tercetak: ' + res.message
          swalAlert('error', msg);
        }
      });
    } catch (err) {
      console.log(err)
      alert(err.message ?? err)
    }
  })
</script>
<?= $this->endSection() ?>