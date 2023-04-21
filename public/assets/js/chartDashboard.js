let ctx = document.getElementById("statusChart").getContext("2d");
let labels = ["Failed", "Process", "Success"];
let colorHex = ["#FB3640", "#EFCA08", "#43AA8B"];

let myChart = new Chart(ctx, {
  type: "pie",
  data: {
    datasets: [
      {
        data: [30, 60, 10],
        backgroundColor: colorHex,
      },
    ],
    labels: labels,
  },
  options: {
    responsive: true,
    legend: {
      position: "right",
    },
    plugins: {
      datalabels: {
        color: "#fff",
        anchor: "end",
        align: "start",
        offset: -10,
        borderWidth: 2,
        borderColor: "#fff",
        borderRadius: 25,
        backgroundColor: (context) => {
          return context.dataset.backgroundColor;
        },
        font: {
          weight: "bold",
          size: "10",
        },
        formatter: (value) => {
          return value + " %";
        },
      },
    },
  },
});
