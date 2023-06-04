<?= $this->extend("layout/index") ?>

<!-- Disini Contentnya apa -->
<?= $this->section("content") ?>
<div class="form-pengiriman">
  <h2>From Pengiriman Barang</h2>
  <form id="form-pengiriman">
    <div class="form-pengiriman-data">
      <h3>Pengirim</h3>
      <div class="form-pengiriman-label">
        <label for="pengirim-nama">
          Nama
          <input type="text" name="pengirim-nama" id="pengirim-nama">
        </label>
        <label for="pengirim-tlp">
          No.Telp
          <input type="text" name="pengirim-tlp" id="pengirim-tlp">
        </label>
        <label for="pengirim-alamat">
          Alamat
          <input type="text" name="pengirim-alamat" id="pengirim-alamat">
        </label>
      </div>
    </div>
    <div class="form-pengiriman-data">
      <h3>Penerima</h3>
      <div class="form-pengiriman-label">
        <label for="penerima-nama">
          Nama
          <input type="text" name="penerima-nama" id="penerima-nama">
        </label>
        <label for="penerima-tlp">
          No.Telp
          <input type="text" name="penerima-tlp" id="penerima-tlp">
        </label>
        <label for="penerima-alamat">
          Alamat
          <input type="text" name="penerima-alamat" id="penerima-alamat">
        </label>
      </div>
    </div>
    <div class="form-pengiriman-data">
      <h3>Barang</h3>
      <div class="form-pengiriman-label-barang">
        <label for="barang-nama">
          Nama
          <input type="text" name="barang-nama" id="barang-nama">
        </label>
        <label for="barang-berat">
          Berat
          <input type="text" name="barang-berat" id="barang-berat">
        </label>
        <label for="barang-tgl-masuk">
          Tanggal Masuk
          <input type="date" name="barang-tgl-masuk" id="barang-tgl-masuk">
        </label>
        <label for="barang-tgl-keluar">
          Tanggal Keluar
          <input type="date" name="barang-tgl-keluar" id="barang-tgl-keluar">
        </label>
        <label for="barang-status">
          Status
          <select name="barang-status" id="barang-status">
            <option value="progress">ON PROGRES</option>
            <option value="success">SUCCESS</option>
            <option value="failed">FAILED</option>
          </select>
        </label>
      </div>
    </div>
    <button type="submit">Simpan</button>
  </form>
</div>
<?= $this->endSection() ?>