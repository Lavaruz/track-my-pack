<?php
$session = session();
$user_detail = $session->get('user_detail') ?? null;

$links = [];
// Admin
if($user_detail['id_role'] == '1') {
    $links = "
    <a href='".base_url('/pengiriman')."' role='button' id='pengiriman-button' class='dropdown-item'>Pengiriman</a>
    <a href='".base_url('/perusahaan')."' role='button' id='perusahaan-button' class='dropdown-item'>Perusahaan</a>
    <a href='".base_url('/user')."' role='button' id='user-button' class='dropdown-item'>Pengguna</a>
    <a href='".base_url('/laporan')."' role='button' id='laporan-button' class='dropdown-item'>Laporan</a>
    ";
}
// Logistik
else if($user_detail['id_role'] == '2') {
    $links = "
    <a href='".base_url('/pengiriman')."' role='button' id='pengiriman-button' class='dropdown-item'>Pengiriman</a>
    <a href='".base_url('/laporan')."' role='button' id='laporan-button' class='dropdown-item'>Laporan</a>
    ";
}
?>
<div class="nav-list">
    <div class="dropdown d-flex">
        <a href="#" role="button" class="navbar-btn dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Selamat Datang, <?= $user_detail['username']?></a>
        <div class="dropdown-menu dropdown-navbar" aria-labelledby="dropdownMenuButton">
            <?=$links?>
            <!-- <a href="<?= base_url('/profile') ?>" role="button" id="profile-button" class="dropdown-item">Profile</a> -->
            <a href="<?= base_url('/logout') ?>" role="button" id="logout-button" class="dropdown-item">Log Out</a>
        </div>
    </div>
</div>