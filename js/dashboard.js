const accoutButton = document.getElementById("accountButton");
const accoutDrop = document.getElementById("accountDrop");

accoutButton.addEventListener("click", () => {
  accoutDrop.classList.toggle("drop-toggle");
});

$(document).ready(function () {
  $("#dashboardTable").DataTable({
    ajax: "./data/list_pengiriman.json",
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
