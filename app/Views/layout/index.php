<?php
$session = session();
$user_detail = $session->get('user_detail') ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Track My Package</title>
  <link rel="stylesheet" href="<?=base_url('/assets/css/all.css')?>" />
  <link rel="stylesheet" href="<?=base_url('/assets/css/index.css')?>" />
  <link rel="stylesheet" href="<?=base_url('/assets/plugins/bootstrap/css/bootstrap.min.css');?>" />
  <link rel="stylesheet" href="<?=base_url('/assets/plugins/mdb/css/mdb.min.css')?>" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" 
  integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" 
  crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="<?=base_url('/assets/plugins/datepicker/css/bootstrap-datepicker.min.css')?>" />
  <link rel="stylesheet" href="<?=base_url('/assets/plugins/jquery-datatable/css/jquery.datatables.css') ?>" />
  <link rel="stylesheet" href="<?=base_url('/assets/plugins/daterangepicker/daterangepicker.css')?>" />

  <!-- Sweetalert2 -->
  <link rel="stylesheet" href="<?=base_url('/assets/plugins/sweetalert2/sweetalert2.min.css')?>" />
  <script src="<?=base_url('/assets/plugins/sweetalert2/sweetalert2.min.js')?>"></script>

  <!-- jQuery -->
  <script src="<?= base_url('/assets/plugins/jquery/jquery-3.6.4.min.js') ?>"></script>
  <script src="<?= base_url('/assets/plugins/jquery-datatable/js/jquery.datatables.js') ?>"></script>
  <script src="<?= base_url('/assets/js/jquery-validate.js') ?>"></script>

  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?=base_url('/assets/css/select2.min.css')?>" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="<?=base_url('/assets/js/select2.min.js')?>"></script>

  <!-- Bootstrap -->
  <script src="<?=base_url('/assets/plugins/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?=base_url('/assets/plugins/datepicker/js/bootstrap-datepicker.min.js')?>"></script>

  <script src="<?= base_url('/assets/js/index.js') ?>"></script>

  <?=$this->renderSection('preload')?>
</head>

<body>
  <!-- START NAV -->
  <nav class="nav-main sticky-top bg-light-nav">
    <div class="container-fluid">
      <div class="nav-brand">
        <a href="<?=base_url()?>"><img src="<?=base_url('/assets/img/logo.png')?>" alt="" width="300" /></a>
      </div>
      <?php if(isset($user_detail) && $user_detail['logged_in']) {
        echo $this->include("layout/navbar");
      } else {
        echo $this->include("layout/navbar_login");
      }?>
    </div>
  </nav>
  <!-- END NAV -->

  <!-- START MAIN  -->
  <div class="wrapper-box" style="margin: 2rem; min-height:80vh;">
    <?= $this->renderSection('title') ?>
    <div class="container-content">
      <?= $this->renderSection('content') ?>
    </div>
  </div>
  <!-- END MAIN -->

  <!-- Footer -->
  <footer class="container-fluid footer" style="margin-top: 5rem;">
    <!-- <div class="row m-4">
      <div class="col-md-8 p-2 border-bottom border-3 border-gray rounded">
        <h2>Fitur</h2>
        <ul>
          <li>Update status perjalanan paket anda dengan mudah</li>
          <li>Memberikan informasi perjalanan paket kepada konsumen anda</li>
          <li>Layanan pengecekan resi gratis tanpa dipungut biaya</li>
          <li>Bantuan pembuatan multi akun untuk satu perusahaan</li>
        </ul>
      </div>
    </div> -->
    <div class="row justify-content-end m-4" style="margin-top: 3rem;">
      <div class="col-md-6 p-2 text-end">
        <h2>Tentang Kami</h2>
        <p style="margin: 0;">Kelompok KKP - 5</p>
        <p style="margin: 0;">Program Studi Teknik Informatika</p>
        <p style="margin: 0;">Fakultas Teknik dan Ilmu Komputer</p>
        <p style="margin: 0;">Universitas Indraprasta PGRI</p>
      </div>
    </div>
    <div class="justify-content-center text-center" style="margin:0;">
      <p style="margin:0;">2023</p>
    </div>
  </footer>
  <!-- End Footer -->
  
</body>

<?= $this->renderSection('post_load') ?>

<!-- Login Slide -->
<script>
  $("#login-button").click((e) => {
    e.preventDefault();
    $("#login-form").slideToggle(200);
    toggleCaretSign();
  });

  function toggleCaretSign() {
    if($('#sign-caret').attr('class') == 'fas fa-caret-down') {
      $('#sign-caret').removeClass('fas fa-caret-down');
      $('#sign-caret').addClass('fas fa-caret-up');
    } else {
      $('#sign-caret').removeClass('fas fa-caret-up');
      $('#sign-caret').addClass('fas fa-caret-down');
    }
  }
  
  $('#dropdownMenuButton').click(function(e) {
    e.preventDefault()
    $('.dropdown-menu').slideToggle(200);
  })
</script>

<!-- Form login -->
<script>
  $('#login_submit').click(() => {
    if(validateForm()) {
      $("#f1").submit();
    }
  });

  $('#f1').submit(function(e) {
    try {
      e.preventDefault();
      var fd = new FormData($('#f1')[0]);
      $.ajax({
        url: "<?= base_url(); ?>/verify",
        method: "POST",
        data: fd,
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
      }).done(function (res) {
        if (res.status == 'success') {
            location.reload();
        } else {
            alert('Login gagal: ' + res.message ?? 'Silahkan coba lagi');
        }
      });
    } catch(err) {
      console.log(err)
      alert(err.message ?? err)
    }
  })

  function validateForm() {
    var validator = $("#f1").validate();

    if (validator.form()) {
      return true;
    } else {
      validator.focusInvalid();
      return false;
    }
  }

  $(document).ready(function() {
    $('#f1').validate({
      rules: {
        username: {required: true},
        password: {required: true, minlength: 6},
      },
      messages: {
        username: {required: "Username tidak boleh kosong"},
        password: {required: "Password tidak boleh kosong", minlength: "Password harus lebih dari 6 karakter"},
      },
    });
  })
</script>

</html>