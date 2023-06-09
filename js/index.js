$(document).ready(function () {
  $("#indexTable").DataTable({
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

$("#login-button").click(() => {
  $("#login-form").toggle("slide");
});
