<?= $this->extend("layout/index") ?>
<?= $this->section("content") ?>
<div class="container-profile">
    <form id="form-profile">
        <div class="profile-data">
            <h2>Profile Perusahaan</h2>
            <label for="">
                Nama:
                <input type="text" name="" id="" placeholder="masukan nama">
            </label>
            <div class="profile-data-side">
                <label for="">
                    Email:
                    <input type="text" name="" id="" placeholder="masukan email">
                </label>
                <label for="">
                    Password:
                    <input type="password" name="" id="" placeholder="masukan password">
                </label>
            </div>
            <label for="">
                No.Telp:
                <input type="text" name="" id="" placeholder="masukan no.telp">
            </label>
            <label for="">
                Alamat:
                <input type="text" name="" id="" placeholder="masukan alamat">
            </label>
            <label for="">
                Company/Perusahaan:
                <select class="profile-perusahaan-select" name="state">
                    <option></option>
                    <option value="AL">Alabama</option>
                    <option value="WY">Wyoming</option>
                </select>
            </label>
            <button>Simpan</button>
        </div>
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