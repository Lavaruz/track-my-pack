<?php
  $view = false;
  $disabled = "";
  if ($action != 'do_add' && $action != 'do_update') $disabled = 'disabled';
  if ($action == 'do_view') $view = true;
?>

<?= $this->extend("layout/index") ?>

<?= $this->section("content") ?>
<div class="container-profile">
  <form id="form-profile">

  <input type="hidden" name="pengiriman_id" value="<?=$data->id ?? ''?>">
  <input type="hidden" name="action" value="<?=$action?>">

    <div class="profile-data">
      <h2>Profile Pengguna <span class="form-required" style="vertical-align: baseline;">* harus diisi</h2>
      <div class="mb-3">
        <label for="" class="form-label">Nama <span class="form-required">*</span></label>
        <input type="text" class="form-control" value="<?=$data->nama ?? ''?>" name="name" id="name" placeholder="Masukkan nama" <?=$disabled?>>
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Email <span class="form-required">*</span></label>
        <input type="text" class="form-control" value="<?=$data->email ?? ''?>" name="email" id="email" placeholder="Masukkan email" <?=$disabled?>>
      </div>
      <div class="mb-3">
        <label for="" class="form-label">Nomor HP <span class="form-required">*</span></label>
        <input type="text" class="form-control" value="<?=$data->nomor_hp ?? ''?>" name="nomor_hp" id="nomor_hp" placeholder="Masukkan Nomor HP" <?=$disabled?>>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label for="" class="form-label">Username <span class="form-required">*</span></label>
          <input type="text" class="form-control" value="<?=$data->username ?? ''?>" name="username" id="username" placeholder="Masukkan Username" <?=$disabled?>>
        </div>
      </div>
      <!-- <div class="row mb-3">
        <div class="col">
          <label for="" class="form-label">Password <span class="form-required">*</span></label>
          <input type="password" class="form-control" name="" id="" placeholder="masukan password">
        </div>
      </div> -->
      <div class="mb-3">
        <label for="" class="form-label">Role <span class="form-required">*</span></label>
        <select name="id_role" id="id_role" class="form-control" <?=$disabled?>>
          <option value=""></option>
          <?php foreach($role as $rv) {
            $selected = ($data->id_role == $rv['id']) ? 'selected' : '';
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
    $('.profile-perusahaan-select').select2({
      placeholder: "Pilih Perusahaan",
    });

    $('#id_role').select2({
      placeholder: "Pilih Role",
    });
  });
</script>
<?= $this->endSection() ?>