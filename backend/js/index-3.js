// Revenue Report
var options = {
  series: [{
    name: 'progress',
    type: 'line',
    data: [-15, 32, -11, 63, 16, 82, 292, 107, -18, 56, 200, 80],
  }, {
    name: 'active',
    type: 'column',
    data: [104, 102, 117, 146, 118, 115, 220, 103, 83, 114, 265, 174],
  }, {
    name: 'inactive',
    type: 'column',
    data: [-34, -42, -97, -56, -71, -175, -60, -34, -56, -78, -119, -53]
  }],
  chart: {
    height: 395,
    fontFamily: 'poppins, sans-serif',
  },
  stroke: {
    curve: 'smooth', 
    dashArray: [2, 0, 0],
    width: [2, 0, 0]
  },
  fill: {
    opacity: [1, 1, 1]
  },
  grid: {
    borderColor: '#f2f6f7',
  },
  colors: ["#ffda82", '#000' , "#edf1f7"],
  plotOptions: {
    bar: {
      columnWidth: '30%',
    }
  },
  dataLabels: {
    enabled: false,
  },
  legend: {
    show: true,
    position: 'top',
  },
  yaxis: {
    title: {
      style: {
        color: '	#adb5be',
        fontSize: '14px',
        fontWeight: 600,
        cssClass: 'apexcharts-yaxis-label',
      },
    },
    labels: {
      formatter: function (y) {
        return y.toFixed(0) + "";
      }
    }
  },
  xaxis: {
    type: 'month',
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'sep', 'oct', 'nov', 'dec'],
    axisBorder: {
      show: true,
      color: 'rgba(119, 119, 142, 0.05)',
      offsetX: 0,
      offsetY: 0,
    },
    axisTicks: {
      show: true,
      borderType: 'solid',
      color: 'rgba(119, 119, 142, 0.05)',
      width: 6,
      offsetX: 0,
      offsetY: 0
    },
    labels: {
      rotate: -90
    }
  }

};
var chart1 = new ApexCharts(document.querySelector("#revenueReport"), options);
chart1.render();

function revenueReport() {
  chart1.updateOptions({
    colors: ["#ffda82", `rgb(${myVarVal})`, `rgba(${myVarVal}, 0.5)`],
  })
}

$(function () {

  // Data Table
  $('#payrollReport').DataTable({
    language: {
      searchPlaceholder: 'Search here...',
      sSearch: '',
      lengthMenu: '_MENU_',
    }
  });

  //______Select2
  $('.select2').select2({
    minimumResultsForSearch: Infinity,
    width: "auto"
  });
});
