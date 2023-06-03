<?= $this->extend("layout/index") ?>

<!-- Disini Contentnya apa -->
<?= $this->section("content") ?>
  <form id="f1">
    <a href="<?=base_url('user/tambah')?>">LINK KE USER</a>
    <h2>Nama</h2>
    <input type="text" name="" id="">
    <h2>No Telp</h2>
    <input type="text" name="" id="">
  </form>
<?= $this->endSection() ?>