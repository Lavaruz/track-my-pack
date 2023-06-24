<?= $this->extend("layout/index") ?>

<?= $this->section("content") ?>
<div class="laporan-container">
    <h1 class="mb-3">Cetak Laporan</h1>
    <form action="">
        <div class="mb-3">
            <label for="" class="form-label">Filter berdasarkan status pengiriman <span class="form-required">*</span></label>
            <select name="status" id="status" class="form-control">
                <option value=""></option>
                <option value="proses">On Process</option>
                <option value="proses">Success</option>
                <option value="proses">Failed</option>
              </select>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label for="" class="form-label">Filter Berdasarkan Tanggal Dikirim (>=)
<span class="form-required">*</span></label>
                <input type="date" class="form-control" value="" name="nama" id="" placeholder="Masukkan Nama Perusahaan">
            </div>
            <div class="mb-3 col">
                <label for="" class="form-label">Filter Berdasarkan Tanggal Diterima (<=)
<span class="form-required">*</span></label>
                <input type="date" class="form-control" value="" name="nama" id="" placeholder="Masukkan Nama Perusahaan">
            </div>
        </div>
        
      <button role="button" id="form-submit" class="btn btn-primary">Cetak Laporan</button>
      <a role="button" class="btn btn-danger" href="<?=base_url('pengiriman')?>" style="float:right;">Batal</a>
    </form>
</div>
<script>
  $(document).ready(function() {
    $('#status').select2({
      placeholder: "Pilih status pengiriman",
    });
})
</script>
<?= $this->endSection() ?>