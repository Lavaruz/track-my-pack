<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"
    />
    <link rel="stylesheet" href="./css/dashboard.css" />
    <link rel="stylesheet" href="./css/all.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
  </head>
  <body>
    <nav>
      <div class="nav-brand">
        <img src="./img/logo.png" alt="" width="300" />
      </div>
      <div class="nav-list">
        <a href="#" id="accountButton">Assami Muzaki</a>
        <div class="nav-list-drop" id="accountDrop">
          <a href="/profile.html">Profile</a>
          <a href="/index.html">Logout</a>
        </div>
      </div>
    </nav>
    <hr />
    <main>
      <div class="main-statistic">
        <div class="main-statistic-title">
          <h2>Dashboard</h2>
        </div>
        <div class="main-statistic-data">
          <div class="stat-data">
            <p>Grafik Pengiriman Bulanan</p>
            <div class="dummy"></div>
          </div>
          <div class="stat-data">
            <p>Status Pengiriman</p>
            <div class="chart-wrapper">
              <canvas id="statusChart"></canvas>
            </div>
          </div>
          <!-- DTATISTIC DATA FROM BACKEND -->
        </div>
      </div>
      <div class="main-list">
        <div class="main-list-title">
          <h2>List Pengiriman</h2>
          <a href="">Buat Pengiriman</a>
        </div>
        <hr style="margin-bottom: 4rem" />
        <div class="main-list-data">
          <table id="dashboardTable">
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
      </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="./js/dashboard.js"></script>
    <script src="./js/chartDashboard.js"></script>
  </body>
</html>
