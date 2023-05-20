<?php
?>

<?= $this->extend("layout/index") ?>

<?= $this->section("content") ?>
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
<?= $this->endSection() ?>


<?= $this->section("post_load") ?>
<!-- Datatable Index -->
<script>
  $(document).ready(function() {
    $("#indexTable").DataTable({
      ajax: "/assets/data/list_pengiriman.json",
      columns: [{
          data: "id"
        },
        {
          data: "no_resi"
        },
        {
          data: "pengirim"
        },
        {
          data: "penerima"
        },
        {
          data: "destinasi"
        },
        {
          data: "status"
        },
      ],
    });
  });
</script>
<?= $this->endSection() ?>