// Audience Report Chart
var options = {
  series: [
    {
      name: '2020',
      data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 45, 35]
    },
    {
      name: '2021',
      data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43, 27]
    },
    {
      name: '2022',
      data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39, 33]
    }
  ],
  chart: {
    toolbar: {
      show: false
    },
    type: 'area',
    height: 350,
    stacked: true,
    fontFamily: 'poppins, sans-serif',
  },
  grid: {
    borderColor: '#f2f6f7',
  },
  colors: ['#000', '#000', '#000'],
  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
  dataLabels: {
    enabled: false
  },
  stroke: {
    width: [0, 0, 0],
    curve: 'straight',
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
  fill: {
    type: 'gradient',
    gradient: {
      opacityFrom: 0.6,
      opacityTo: 0.8,
    }
  },
  legend: {
    show: false,
  },

};
var chart1 = new ApexCharts(document.querySelector("#audienceReport"), options);
chart1.render();
function audienceReport() {
  chart1.updateOptions({
    colors: [`rgb(${myVarVal})`, `rgba(${myVarVal}, 0.2)`, `rgba(${myVarVal}, 0.5)`],
  })
}

//Sessions By Device Chart
var options = {
  plotOptions: {
    pie: {
      size: 10,
      donut: {
        size: '70%'
      }
    }
  },
  dataLabels: {
    enabled: false,
  },
  series: [55, 34, 51],
  labels: ['Mobile', 'Tablet', 'Desktop'],
  chart: {
    type: 'donut',
    fontFamily: 'poppins, sans-serif',
    height: 220
  },
  legend: {
    show: false
  },
  colors: ['#000', '#2dce89', '#ffda82'],
  responsive: [{
    breakpoint: 0,
    options: {
      chart: {
        width: 100,
      },
      legend: {
        show: false,
        position: 'bottom'
      }
    },
  }]
};
var chart2 = new ApexCharts(document.querySelector("#sessionsDevice"), options);
chart2.render();
function sessionsDevice() {
  chart2.updateOptions({
    colors: [`rgb(${myVarVal})`, '#2dce89', '#ffda82'],
  })
}

// Sessions By Country Chart
var options = {
  series: [{
    name: 'Sessions',
    data: [400, 430, 470, 540, 1100, 1200, 1380]
  }],
  chart: {
    toolbar: {
      show: false
    },
    type: 'bar',
    fontFamily: 'poppins, sans-serif',
    height: 330
  },
  grid: {
    borderColor: '#f2f6f7',
  },
  plotOptions: {
    bar: {
      borderRadius: 4,
      horizontal: true,
      barHeight: "30%",
      borderRadius: 3,
    }
  },
  colors: ['#000'],
  dataLabels: {
    enabled: false
  },
  xaxis: {
    categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'United States', 'China', 'Germany'],
  }
};
var chart = new ApexCharts(document.querySelector("#sessionsCountry"), options);
chart.render();
function sessionsCountry() {
  chart.updateOptions({
    colors: [`rgb(${myVarVal})`],
  })
}
