<?php
  $view = false;
  $disabled = "";
  if($action != 'do_add' && $action != 'do_update') $disabled = 'disabled';
  if($action == 'do_view') $view = true;
?>

<?= $this->extend("layout/index") ?>

<?= $this->section("content") ?>
<div class="container-pengiriman">
  <h2>From Pengiriman Barang<?=isset($data['pengiriman_resi']) ? ': '.$data['pengiriman_resi'] : '' ?></h2>
  <form id="form-pengiriman">
    <input type="hidden" name="pengiriman_id" value="<?=$data['pengiriman_id'] ?? ''?>">
    <input type="hidden" name="action" value="<?=$action?>">

    <?php if($action != 'do_add') { ?>
      <div class="form-pengiriman-data">
        <div class="row">
          <div class="col-md-12">
            <div class="mb-3 form-input">
              <label for="status">Status</label>
              <input type="text" name="status" value="<?=$data['status'] ?? ''?>" class="form-control" id="status" <?=$disabled?>>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

    <!-- Pengirim -->
    <div class="form-pengiriman-data">
      <h3>Data Pengirim <span class="form-required" style="vertical-align: baseline;">* harus diisi</span></h3>
      <div class="mb-3 form-input">
        <label for="pengirim-nama" class="form-label">Nama <span class="form-required">*</span></label>
        <input type="text" name="pengirim_nama" id="pengirim-nama" value="<?=$data['nama_pengirim'] ?? ''?>" class="form-control" placeholder="Masukan Nama Pengirim" <?=$disabled?>>
      </div>
      <div class="mb-3 form-input">
        <label for="pengirim-tlp" class="form-label">No.Telp <span class="form-required">*</span></label>
        <input type="text" name="pengirim_nomor_hp" id="pengirim-tlp" value="<?=$data['nomor_pengirim'] ?? ''?>" class="form-control form-telp" placeholder="Masukan Nomor HP Pengirim" <?=$disabled?>>
      </div>
      <div class="mb-3 form-input">
        <label for="pengirim-alamat" class="form-label">Alamat <span class="form-required">*</span></label>
        <textarea name="pengirim_alamat" id="pengirim-alamat" class="form-control" placeholder="Masukan Alamat Pengirim" cols="30" rows="3" <?=$disabled?>><?=$data['alamat_pengirim'] ?? ''?></textarea>
      </div>
    </div>
    <!-- Penerima -->
    <div class="form-pengiriman-data">
      <h3>Data Penerima <span class="form-required" style="vertical-align: baseline;">* harus diisi</span></h3>
      <div class="mb-3 form-input">
        <label for="penerima-nama">Nama <span class="form-required">*</span></label>
        <input type="text" name="penerima_nama" id="penerima-nama" value="<?=$data['nama_penerima'] ?? ''?>" class="form-control" placeholder="Masukan Nama Penerima" <?=$disabled?>>
      </div>
      <div class="mb-3 form-input">
        <label for="penerima-tlp">No.Telp <span class="form-required">*</span></label>
        <input type="text" name="penerima_nomor_hp" id="penerima-tlp" value="<?=$data['nomor_penerima'] ?? ''?>" class="form-control form-telp" placeholder="Masukan Nomor HP Penerima" <?=$disabled?>>
      </div>
      <div class="mb-3 form-input">
        <label for="penerima-alamat">Alamat <span class="form-required">*</span></label>
        <textarea name="penerima_alamat" id="penerima-alamat" class="form-control" placeholder="Masukan Alamat Penerima" cols="30" rows="3" <?=$disabled?>><?=$data['alamat_penerima'] ?? ''?></textarea>
      </div>
    </div>
    <!-- Barang -->
    <div class="form-pengiriman-data">
      <div class="row">
        <h3>Data Barang <span class="form-required" style="vertical-align: baseline;">* harus diisi</span></h3>
      </div>
      <div class="row">

        <div class="col-md-<?=$action == 'do_add' ? '12' : '6'?>">
          <div class="mb-3 form-input">
            <label for="barang-nama">Nama <span class="form-required">*</span></label>
            <input type="text" name="barang_nama" id="barang-nama" value="<?=$data['nama_barang'] ?? ''?>" class="form-control" placeholder="Masukan Nama Barang" <?=$disabled?>>
          </div>
          <div class="mb-3 form-input">
            <label for="barang-berat">Berat (KG) <span class="form-required">*</span></label>
            <input type="number" name="barang_berat" id="barang-berat" min="0" value="<?=$data['berat_barang'] ?? ''?>" class="form-control" placeholder="Masukan Berat Barang" <?=$disabled?>>
          </div>
        </div>

        <?php if($action != 'do_add') { ?>
          <div class="col-md-6">
            <div class="mb-3 form-input">
              <label for="barang-tgl-masuk">Tanggal Masuk</label>
              <input type="date" name="barang_tgl_masuk" value="<?=$data['tanggal_masuk'] ?? ''?>" class="form-control" id="barang-tgl-masuk" <?=$disabled?>>
            </div>
            <div class="mb-3 form-input">
              <label for="barang-tgl-keluar">Tanggal Keluar</label>
              <input type="date" name="barang_tgl_keluar" value="<?=$data['tanggal_keluar'] ?? ''?>" class="form-control" id="barang-tgl-keluar" <?=$disabled?>>
            </div>
          </div>
        <?php } ?>

      </div>
    </div>

    <!-- Button -->
    <button role="button" id="form-submit" class="btn btn-primary">Simpan</button>
    <a role="button" class="btn btn-danger" href="<?=base_url('pengiriman')?>" style="float:right;">Batal</a>

  </form>
</div>
<?= $this->endSection() ?>

<?= $this->section("post_load") ?>
<script>
  $(document).ready(function() {
    $('#barang-status').select2({
      placeholder: "pilih status pengiriman",
      allowClear: true
    });
  });

  // Trip input
  $('.form-control.form-telp').on('keyup blur', function() {
    var vp = $(this).val().replace(/\D/g, '');
    if (vp == '') vp = '';
    $(this).val(vp);
  });
  $('.form-control.form-telp').blur();
</script>

<!-- Form Submit -->
<script>
  $('#form-submit').click((e) => {
    e.preventDefault();
    if(validateForm('form-pengiriman')) {
      $('#form-pengiriman').submit()
    } else {
      swalAlert('error', 'Tolong cek kembali form anda')
    }
  })

  $('#form-pengiriman').submit((e) => {
    try {
      e.preventDefault();
      var fd = new FormData($('#form-pengiriman')[0]);
      var url = '<?=$action == 'do_add' ? base_url('pengiriman/tambah') : base_url("pengiriman/edit/$data[pengiriman_id]")?>'
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
          Swal.fire({
            icon: 'success',
            title: 'Data sukses tersimpan',
            showConfirmButton: true,
          }).then((isConfirm) => {
            window.location.replace('<?= base_url(); ?>/pengiriman');
          });
        } else {
          var msg = 'Data gagal tersimpan: ' + res.message
          swalAlert('error', msg);
        }
      });
    } catch (err) {
      console.log(err)
      alert(err.message ?? err)
    }
  })

  $('#form-pengiriman').validate({
    rules: {
      pengirim_nama: {required:true},
      pengirim_nomor_hp: {required:true, number: true},
      pengirim_alamat: {required:true},
      penerima_nama: {required:true},
      penerima_nomor_hp: {required:true},
      penerima_alamat: {required:true},
      barang_nama: {required:true},
      barang_berat: {required:true, number: true},
    },
    messages: {
      pengirim_nama: {required:"Nama Pengirim tidak boleh kosong"},
      pengirim_nomor_hp: {required:"Nomor HP Pengirim tidak boleh kosong", number:"Harus diisi dengan angka"},
      pengirim_alamat: {required:"Alamat Pengirim tidak boleh kosong"},
      penerima_nama: {required:"Nama Penerima tidak boleh kosong"},
      penerima_nomor_hp: {required:"Nomor HP Penerima tidak boleh kosong", number:"Harus diisi dengan angka"},
      penerima_alamat: {required:"Alamat Penerima tidak boleh kosong"},
      barang_nama: {required:"Nama Barang tidak boleh kosong"},
      barang_berat: {required:"Berat Barang tidak boleh kosong", number:"Harus diisi dengan angka"},
    },
  });
</script>
<?= $this->endSection() ?>