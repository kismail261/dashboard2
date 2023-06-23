//Total Revenue Chart
var options = {
  series: [{
    name: 'Last Year',
    data: [30, 25, 46, 28, 21, 45, 35, 64, 52, 59, 36, 39]
  }, {
    name: 'Present Year',
    data: [23, 11, 22, 35, 17, 28, 22, 37, 21, 44, 22, 30]
  }],
  chart: {
    height: 320,
    fontFamily: 'poppins, sans-serif',
    type: 'area'
  },
  grid: {
    borderColor: '#f2f6f7',
  },
  dataLabels: {
    enabled: false
  },
  xaxis: {
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
  legend: {
    position: 'top'
  },
  colors: ["#eaebeb", '#000000'],
  stroke: {
    width: [0, 0],
    curve: 'smooth',
  },
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
};

var chart1 = new ApexCharts(document.querySelector("#totalRevenue"), options);
chart1.render();
function totalRevenue() {
  chart1.updateOptions({
    colors: [`rgba(${myVarVal}, 0.4)`, `rgb(${myVarVal})`],
  })
}

// Visitors Report Chart
var options = {
  series: [{
    name: 'New Visitors',
    data: [76, 85, 101, 98, 87, 105, 91]
  }, {
    name: 'Repeated Visitors',
    data: [44, 55, 57, 56, 61, 58, 63]
  },],
  chart: {
    toolbar: {
      show: false
    },
    type: 'bar',
    fontFamily: 'poppins, sans-serif',
    height: 320
  },
  grid: {
    borderColor: '#f2f6f7',
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '55%',
      endingShape: 'rounded'
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
  },
  xaxis: {
    categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
  },
  yaxis: {
    title: {
      text: undefined
    }
  },
  xaxis: {
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
    }
  },
  fill: {
    opacity: 1
  },
  colors: ['#000', "#ededed"],
  legend: {
    show: false,
    position: 'top'
  },
  plotOptions: {
    bar: {
      columnWidth: "30%",
      borderRadius: 3
    }
  },
};
var chart2 = new ApexCharts(document.querySelector("#visitorsGrowth"), options);
chart2.render();
function visitorsGrowth() {
  chart2.updateOptions({
    colors: [`rgb(${myVarVal})`, `rgba(${myVarVal}, 0.4)`],
  })
}

$(function () {

  // Data Table
  $('#recentInvoices').DataTable({
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