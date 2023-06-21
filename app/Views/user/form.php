<?php
  $view = false;
  $disabled = "";
  if ($action != 'do_add' && $action != 'do_update') $disabled = 'disabled';
  if ($action == 'do_view') $view = true;
?>

<?= $this->extend("layout/index") ?>

<?= $this->section("content") ?>
<div class="container-profile">
  <form id="form-user">

    <input type="hidden" name="pengiriman_id" value="<?=$data->id ?? ''?>">
    <input type="hidden" name="action" value="<?=$action?>">

    <div class="profile-data">
      <h2>Profile Pengguna <span class="form-required" style="vertical-align: baseline;">* harus diisi</h2>
      <div class="mb-3">
        <label for="" class="form-label">Nama <span class="form-required">*</span></label>
        <input type="text" class="form-control" value="<?=$data->nama ?? ''?>" name="nama" id="nama" placeholder="Masukkan nama" <?=$disabled?>>
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Email</label>
        <input type="text" class="form-control" value="<?=$data->email ?? ''?>" name="email" id="email" placeholder="Masukkan email" <?=$disabled?>>
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Nomor HP</label>
        <input type="text" class="form-control" value="<?=$data->nomor_hp ?? ''?>" name="nomor_hp" id="nomor_hp" placeholder="Masukkan Nomor HP" <?=$disabled?>>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label for="" class="form-label">Username <span class="form-required">*</span></label>
          <input type="text" class="form-control" value="<?=$data->username ?? ''?>" name="username" id="username" placeholder="Masukkan Username" <?=$disabled?>>
        </div>
      </div>

      <?php if($action == 'do_add') { ?>
      <div class="row mb-3">
        <div class="col">
          <label for="password" class="form-label">Password <span class="form-required">*</span></label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password">
        </div>
        <div class="col">
          <label for="confirm_password" class="form-label">Konfirmasi Password <span class="form-required">*</span></label>
          <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Masukkan Password">
          <span id="confirm_password-valid" class="">Password Konfirmasi tidak cocok</span>
        </div>
      </div>
      <?php } ?>

      <div class="mb-3">
        <label for="" class="form-label">Perusahaan <span class="form-required">*</span></label>
        <select name="id_perusahaan" id="id_perusahaan" class="form-control" <?=$disabled?>>
          <option value="">Pilih Perusahaan</option>
          <?php foreach($perusahaan as $rv) {
            $selected = '';
            if($rv['id'] == $data->id_perusahaan ?? '') {
              $selected = 'selected';
            }
            echo "<option value='$rv[id]' $selected>$rv[nama]</option>";
          } ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Role <span class="form-required">*</span></label>
        <select name="id_role" id="id_role" class="form-control" <?=$disabled?>>
          <option value="">Pilih Role</option>
          <?php foreach($role as $rv) {
            $selected = '';
            if($rv['id'] == $data->id_role ?? '') {
              $selected = 'selected';
            }
            echo "<option value='$rv[id]' $selected>$rv[nama_role]</option>";
          } ?>
        </select>
      </div>
    </div>

    <?php if(in_array($action, ['do_add', 'do_update'])) { ?>
      <!-- Button -->
      <button role="button" id="form-submit" class="btn btn-primary">Simpan</button>
      <a role="button" class="btn btn-danger" href="<?=base_url('user')?>" style="float:right;">Batal</a>
    <?php } else { ?>
      <a role="button" class="btn btn-light" href="<?=base_url('user')?>" style="float:right;">Kembali</a>
    <?php } ?>

  </form>
</div>
<?= $this->endSection() ?>

<?= $this->section("post_load") ?>
<script>
  $(document).ready(function() {
    $('#id_perusahaan').select2({
      placeholder: "Pilih Perusahaan",
    });
    $('#id_perusahaan').on('select2:select', (e) => {
      $('#id_perusahaan').valid();
    })

    $('#id_role').select2({
      placeholder: "Pilih Role",
    });
    $('#id_role').on('select2:select', (e) => {
      $('#id_role').valid();
    });

    $('#confirm_password-valid').hide();
  });

  var password_valid = <?=$action != 'do_add' ? 'true' : 'false'?>;
  $('#password, #confirm_password').on('change keyup', (e) => {
    var pass = $('#password').val()
    var cpass = $('#confirm_password').val()
    $('#confirm_password-valid').show()
    if(pass == '' || pass != cpass) {
      $('#confirm_password-valid').removeClass('valid-block')
      $('#confirm_password-valid').addClass('help-block')
      $('#confirm_password-valid').text('Password Konfirmasi tidak cocok')
      password_valid = false;
    } else {
      $('#confirm_password-valid').removeClass('help-block')
      $('#confirm_password-valid').addClass('valid-block')
      $('#confirm_password-valid').text('Password cocok')
      password_valid = true;
    }
  });
</script>

<!-- Form Submit -->
<script>
  $('#form-submit').click((e) => {
    e.preventDefault();
    if(validateForm('form-user') && password_valid) {
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
          $('#form-user').submit()
        }
      });
    } else {
      $('#confirm_password').trigger('change')
      swalAlert('error', 'Tolong cek kembali form anda')
    }
  })

  $('#form-user').submit((e) => {
    try {
      e.preventDefault();
      var fd = new FormData($('#form-user')[0]);
      var url = '<?=$action == 'do_add' ? base_url('user/tambah') : base_url("user/edit/$data->id")?>'

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
            window.location.replace('<?= base_url(); ?>/user');
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

  $('#form-user').validate({
    rules: {
      nama: {required:true},
      nomor_hp: {number: true},
      email: {required:true, email:true},
      username: {required:true},
      password: {required:true, minlength: 6},
      confirm_password: {required:true},
      id_role: {required:true},
      id_perusahaan: {required:true},
    },
    messages: {
      nama: {required:"Nama tidak boleh kosong"},
      nomor_hp: {number:"Harus diisi dengan angka"},
      email: {required:"Email tidak boleh kosong", email:"Format email salah"},
      username: {required:"Username tidak boleh kosong"},
      password: {required:"Password tidak boleh kosong", minlength: "Minimal diisi dengan 6 karakter"},
      confirm_password: {required:"Password Konfirmasi tidak boleh kosong"},
      id_role: {required:"Role tidak boleh kosong"},
      id_perusahaan: {required:"Perusahaan tidak boleh kosong"},
    },
  });
</script>
<?= $this->endSection() ?>