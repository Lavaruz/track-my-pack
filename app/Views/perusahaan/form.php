<?php
  $view = false;
  $disabled = "";
  if ($action != 'do_add' && $action != 'do_update') $disabled = 'disabled';
  if ($action == 'do_view') $view = true;
?>

<?= $this->extend("layout/index") ?>

<?= $this->section("content") ?>
<div class="container-profile">
  <form id="form-perusahaan">
    <input type="hidden" name="perusahaan_id" value="<?=$data->id ?? ''?>">
    <input type="hidden" name="action" value="<?=$action?>">

    <div class="profile-data">
      <h2>Profil Perusahaan <span class="form-required" style="vertical-align: baseline;">* harus diisi</h2>
      <div class="mb-3">
        <label for="" class="form-label">Nama <span class="form-required">*</span></label>
        <input type="text" class="form-control" value="<?=$data->nama ?? ''?>" name="nama" id="nama" placeholder="Masukkan Nama Perusahaan" <?=$disabled?>>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label for="" class="form-label">Alamat <span class="form-required">*</span></label>
          <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukkan Alamat Perusahaan" cols="30" rows="3" <?=$disabled?>><?=$data->alamat ?? ''?></textarea>
        </div>
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Nomor Telepon <span class="form-required">*</span></label>
        <input type="text" class="form-control" value="<?=$data->nomor_telepon ?? ''?>" name="nomor_telepon" id="nomor_telepon" placeholder="Masukkan Nomor Telepon" <?=$disabled?>>
      </div>
    </div>

    <?php if(in_array($action, ['do_add', 'do_update'])) { ?>
      <!-- Button -->
      <button role="button" id="form-submit" class="btn btn-primary">Simpan</button>
      <a role="button" class="btn btn-danger" href="<?=base_url('perusahaan')?>" style="float:right;">Batal</a>
    <?php } else { ?>
      <a role="button" class="btn btn-light" href="<?=base_url('perusahaan')?>" style="float:right;">Kembali</a>
    <?php } ?>
    
  </form>
</div>

<?= $this->endSection() ?>

<?= $this->section("post_load") ?>

<!-- Form Submit -->
<script>
  $('#form-submit').click((e) => {
    e.preventDefault();
    if(validateForm('form-perusahaan')) {
      Swal.fire({
        icon: 'question',
        title: 'Apakah anda yakin ingin menyimpan data ini?',
        showClass: { popup: 'animate__animated animate__fadeInDown' },
        hideClass: { popup: 'animate__animated animate__fadeOutUp' },
        showConfirmButton: true,
        showCancelButton: true,
        reverseButtons: true,
      }).then((isConfirm) => {
        if(isConfirm.isConfirmed) {
          $('#form-perusahaan').submit()
        }
      });
    } else {
      swalAlert('error', 'Tolong cek kembali form anda')
    }
  })

  $('#form-perusahaan').submit((e) => {
    try {
      e.preventDefault();
      var fd = new FormData($('#form-perusahaan')[0]);
      var url = '<?=$action == 'do_add' ? base_url('perusahaan/tambah') : base_url("perusahaan/edit/$data->id")?>'
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
            window.location.replace('<?= base_url(); ?>/perusahaan');
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

  $('#form-perusahaan').validate({
    rules: {
      nama: {required:true},
      nomor_telepon: {required:true, number: true},
      alamat: {required:true},
    },
    messages: {
      nama: {required:"Nama Perusahaan tidak boleh kosong"},
      nomor_telepon: {required:"Nomor Telepon tidak boleh kosong", number:"Harus diisi dengan angka"},
      alamat: {required:"Alamat Perusahaan tidak boleh kosong"},
    },
  });
</script>

<?= $this->endSection() ?>