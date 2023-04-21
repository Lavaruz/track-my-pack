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
  <script src="<?=base_url('/assets/js/jquery.min.js')?>"></script>
  <script src="<?=base_url('/assets/js/jquery.validate.js')?>"></script>
  <link rel="stylesheet" href="<?=base_url('/assets/css/select2.min.css')?>" />
  <script src="<?=base_url('/assets/js/select2.min.js')?>"></script>

  <!-- Bootstrap -->
  <script src="<?=base_url('/assets/plugins/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?=base_url('/assets/plugins/datepicker/js/bootstrap-datepicker.min.js')?>"></script>

  <script src="<?= base_url('/assets/plugins/jquery/jquery-3.6.4.min.js') ?>"></script>
  <script src="<?= base_url('/assets/plugins/jquery-datatable/js/jquery.datatables.js') ?>"></script>
  <!-- <script src="<?= base_url('/assets/js/index.js') ?>"></script> -->

  <?=$this->renderSection('preload')?>
</head>

<body>
  <!-- START NAV -->
  <nav class="nav-main sticky-top bg-light-nav">
    <div class="container-fluid">
      <div class="nav-brand">
        <a href="<?=base_url()?>"><img src="<?=base_url('/assets/img/logo.png')?>" alt="" width="300" /></a>
      </div>
      <div class="nav-list">
        <button id="login-button">Sign-in</button>
      </div>
      <div class="login-form" id="login-form">
        <form id="f1">
          <p style="margin: 0; margin-bottom: 1rem">Login Form</p>
          <hr style="margin-bottom: 1rem" />
          <div class="input-form">
            <label for="username">Email: </label>
            <input type="text" name="username" id="login_username" placeholder="Masukan email" />
            <label for="password">Password: </label>
            <input type="password" name="password" id="login_password" placeholder="Masukan password" />
          </div>
          <button type="button" id="login_submit">Login</button>
        </form>
      </div>
    </div>
  </nav>
  <!-- END NAV -->

  <!-- START MAIN  -->
  <div class="wrapper-box" style="margin: 20px;">
    <div class="main-title">
      <h1>Track My Package</h1>
    </div>
    <div class="container-content">

      <?= $this->renderSection('content') ?>

      <!-- Form Search -->
      <div class="main-form">
        <form id="form_search">
          <input type="text" name="search_resi" id="search_resi" placeholder="Masukan Nomor Resi" />
          <button type="button" id="search_submit">Track</button>
        </form>
      </div>
      <!-- End Form Search -->

      <!-- START TABLE SEARCH -->
        <div class="filter-table">
          <table id="indexTable">
            <thead>
              <tr>
                <th>Id</th>
                <th>No.Resi</th>
                <th>Pengirim</th>
                <th>Penerima</th>
                <th>Destinasi</th>
                <th>Status</th>
              </tr>
            </thead>
          </table>
        </div>
      <!-- END TABLE SEARCH -->
    </div>
  </main>
  <!-- END MAIN -->
  
</body>

<!-- Login Slide -->
<script>
  $("#login-button").click(() => {
    $("#login-form").toggle("slide");
  });
</script>

<!-- Datatable Index -->
<script>
  $(document).ready(function () {
    $("#indexTable").DataTable({
      ajax: "/assets/data/list_pengiriman.json",
      columns: [
        { data: "id" },
        { data: "no_resi" },
        { data: "pengirim" },
        { data: "penerima" },
        { data: "destinasi" },
        { data: "status" },
      ],
    });
  });
</script>

</html>