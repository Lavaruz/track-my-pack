<?= $this->extend("layout/index") ?>
<?= $this->section("content") ?>
<div class="container-profile">
    <form id="form-profile">
        <div class="profile-data">
            <h2>Profile Pengguna <span class="form-required" style="vertical-align: baseline;">* harus diisi</h2>
            <div class="mb-3">
                <label for="" class="form-label">Nama <span class="form-required">*</span></label>
                <input type="text" class="form-control" name="" id="" placeholder="masukan nama">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Email <span class="form-required">*</span></label>
                <input type="text" class="form-control" name="" id="" placeholder="masukan email">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">No.Telp <span class="form-required">*</span></label>
                <input type="text" class="form-control" name="" id="" placeholder="masukan nomor telephone">
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="" class="form-label">Username <span class="form-required">*</span></label>
                    <input type="text" class="form-control" name="" id="" placeholder="masukan username">
                </div>
                <div class="col">
                    <label for="" class="form-label">Password <span class="form-required">*</span></label>
                    <input type="password" class="form-control" name="" id="" placeholder="masukan password">
                </div>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Role</label>
                <input type="text" class="form-control" name="" id="" placeholder="masukan username" value="Pengirim" disabled>
            </div>
        </div>
        <button role="button" id="form-submit" class="btn btn-primary">Simpan</button>
        <a role="button" class="btn btn-danger" href="<?=base_url('pengiriman')?>" style="float:right; margin-top:1rem">Batal</a>
  </form>
</div>
<script>
    $(document).ready(function() {
    $('.profile-perusahaan-select').select2({
        placeholder: "Pilih Perusahaan",
        allowClear: true
    });
});
</script>
<?= $this->endSection() ?>