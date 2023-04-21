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