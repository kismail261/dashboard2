//Sales Chart
var options = {
  series: [{
    name: "Sales",
    data: [75, 78, 38, 39, 38, 73, 73, 73, 16, 16, 17, 17]
  },
  {
    name: "Marketing",
    data: [35, 35, 62, 63, 13, 13, 14, 51, 51, 51, 32, 32]
  },
  {
    name: 'Profit',
    data: [87, 57, 74, 99, 75, 38, 110, 85, 57, 95, 65, 81]
  }
  ],
  chart: {
    toolbar: {
      show: false
    },
    height: 360,
    type: 'line',
    fontFamily: 'poppins, sans-serif',
    zoom: {
      enabled: false
    },
  },
  grid: {
    borderColor: '#f2f6f7',
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    width: [1.5, 1.5, 1.2],
    curve: ['straight', 'straight', 'smooth'],
    lineCap: 'butt',
    dashArray: [0, 0, 2]
  },
  title: {
    text: undefined,
  },
  legend: {
    position: 'top',
    tooltipHoverFormatter: function (val, opts) {
      return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
    }
  },
  markers: {
    size: 0,
    hover: {
      sizeOffset: 6
    }
  },
  xaxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    axisBorder: {
      color: 'rgba(119, 119, 142, 0.05)',
      offsetX: 0,
      offsetY: 0,
    },
    axisTicks: {
      color: 'rgba(119, 119, 142, 0.05)',
      width: 6,
      offsetX: 0,
      offsetY: 0
    },
  },
  tooltip: {
    y: [
      {
        title: {
          formatter: function (val) {
            return val
          }
        }
      },
      {
        title: {
          formatter: function (val) {
            return val
          }
        }
      },
      {
        title: {
          formatter: function (val) {
            return val;
          }
        }
      }
    ]
  },
  colors: ['#000', '#ededed', "#fd7e14"],
};
var chart1 = new ApexCharts(document.querySelector("#salesReport"), options);
chart1.render();
function salesReport() {
  chart1.updateOptions({
    colors: [`rgb(${myVarVal})`, `rgba(${myVarVal}, 0.4)`, "#fd7e14"],
  })
}

$(function () {
  // Data Table
  $('#productList').DataTable({
    language: {
      searchPlaceholder: 'Search here...',
      sSearch: '',
      lengthMenu: '_MENU_',
    }
  });

  //select2
  $('.select2').select2({
    placeholder: 'Choose one',
    searchInputPlaceholder: 'Search'
  });
})
