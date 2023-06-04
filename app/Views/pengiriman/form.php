<?= $this->extend("layout/index") ?>

<!-- Disini Contentnya apa -->
<?= $this->section("content") ?>
<div class="form-pengiriman">
  <h2>From Pengiriman Barang</h2>
  <form action="">
    <div class="form-pengiriman-data">
      <h3>Pengirim</h3>
      <div class="form-pengiriman-label">
        <label for="">
          Nama
          <input type="text" name="" id="">
        </label>
        <label for="">
          No.Telp
          <input type="text" name="" id="">
        </label>
        <label for="">
          Alamat
          <input type="text" name="" id="">
        </label>
      </div>
    </div>
    <div class="form-pengiriman-data">
      <h3>Penerima</h3>
      <div class="form-pengiriman-label">
        <label for="">
          Nama
          <input type="text" name="" id="">
        </label>
        <label for="">
          No.Telp
          <input type="text" name="" id="">
        </label>
        <label for="">
          Alamat
          <input type="text" name="" id="">
        </label>
      </div>
    </div>
    <div class="form-pengiriman-data">
      <h3>Barang</h3>
      <div class="form-pengiriman-label-barang">
        <label for="">
          Nama
          <input type="text" name="" id="">
        </label>
        <label for="">
          Berat
          <input type="text" name="" id="">
        </label>
        <label for="">
          Tanggal Masuk
          <input type="date" name="" id="">
        </label>
        <label for="">
          Tanggal Keluar
          <input type="date" name="" id="">
        </label>
        <label for="">
          Status
          <select name="" id="">
            <option value="">ON PROGRES</option>
            <option value="">SUCCESS</option>
            <option value="">FAILED</option>
          </select>
        </label>
      </div>
    </div>
    <input type="submit" value="Simpan">
  </form>
</div>
<?= $this->endSection() ?>