<?= $this->extend("layout/index") ?>

<!-- Disini Contentnya apa -->
<?= $this->section("content") ?>
<div class="container-pengiriman">
  <h2>From Pengiriman Barang</h2>
  <form id="form-pengiriman">
    <div class="form-pengiriman-data">
      <h3>Data Pengirim</h3>
      <div class="form-pengiriman-label">
        <label for="pengirim-nama">
          Nama
          <input type="text" name="pengirim-nama" id="pengirim-nama" placeholder="masukan nama pengirim">
        </label>
        <label for="pengirim-tlp">
          No.Telp
          <input type="text" name="pengirim-tlp" id="pengirim-tlp" placeholder="masukan nomor pengirim">
        </label>
        <label for="pengirim-alamat">
          Alamat
          <input type="text" name="pengirim-alamat" id="pengirim-alamat" placeholder="masukan alamat pengirim">
        </label>
      </div>
    </div>
    <div class="form-pengiriman-data">
      <h3>Data Penerima</h3>
      <div class="form-pengiriman-label">
        <label for="penerima-nama">
          Nama
          <input type="text" name="penerima-nama" id="penerima-nama" placeholder="masukan nama penerima">
        </label>
        <label for="penerima-tlp">
          No.Telp
          <input type="text" name="penerima-tlp" id="penerima-tlp" placeholder="masukan nomor penerima">
        </label>
        <label for="penerima-alamat">
          Alamat
          <input type="text" name="penerima-alamat" id="penerima-alamat" placeholder="masukan alamat penerima">
        </label>
      </div>
    </div>
    <div class="form-pengiriman-data">
      <h3>Data Barang</h3>
      <div class="form-pengiriman-label-barang">
        <label for="barang-nama">
          Nama
          <input type="text" name="barang-nama" id="barang-nama"placeholder="masukan nama barang">
        </label>
        <label for="barang-berat">
          Berat
          <input type="text" name="barang-berat" id="barang-berat"placeholder="masukan berat barang">
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
          Status <br>
          <select name="barang-status" id="barang-status">
            <option value=""></option>
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
<script>
    $(document).ready(function() {
    $('#barang-status').select2({
        placeholder: "pilih status pengiriman",
        allowClear: true
    });
});
</script>
<?= $this->endSection() ?>