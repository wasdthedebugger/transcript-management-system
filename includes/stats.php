<div class="container mt-5">
  <div class="card">
    <div class="card-body">
      <h3 class="card-title">Statistics</h3>
      <hr>
      <div class="row">
        <div class="col-md-4">
          <div class="chart-container">
            <div id="totalChartContainer"></div>
            <h4>Total Students</h4>
            <p class="stat-value"><?php echo getTotalStudents($conn); ?></p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="chart-container">
            <div id="passedChartContainer"></div>
            <h4>Passed Students</h4>
            <p class="stat-value"><?php echo getPassedStudents($conn); ?></p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="chart-container">
            <div id="failedChartContainer"></div>
            <h4>Failed Students</h4>
            <p class="stat-value"><?php echo getFailedStudents($conn); ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add the necessary CSS styles -->
<style>
  .chart-container {
    text-align: center;
    margin-bottom: 30px;
  }
  .chart-container h4 {
    margin-top: 20px;
    font-size: 18px;
  }
  .chart-container .stat-value {
    font-size: 24px;
    font-weight: bold;
    margin-top: 10px;
  }
</style>

<!-- Add the necessary JavaScript libraries for the pie charts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>

<script>
  // Retrieve the total and passed student values from the PHP variables
  var totalStudents = <?php echo getTotalStudents($conn); ?>;
  var passedStudents = <?php echo getPassedStudents($conn); ?>;
  var failedStudents = <?php echo getFailedStudents($conn); ?>;

  // Calculate the percentage of passed and failed students
  var passedPercentage = (passedStudents / totalStudents) * 100;
  var failedPercentage = (failedStudents / totalStudents) * 100;
  var remainingToPassPercentage = 100 - passedPercentage;
  var remainingToFailPercentage = 100 - failedPercentage;

  // Create the total pie chart options
// Create the total pie chart options
var totalOptions = {
  series: [passedPercentage, failedPercentage],
  chart: {
    type: 'donut',
    height: '180',
  },
  labels: ['Passed Students', 'Failed Students'],
  colors: ['#008000', '#FF1744'],
  plotOptions: {
    pie: {
      donut: {
        size: '70%',
      }
    }
  },
  dataLabels: {
    enabled: false
  },
  legend: {
    show: false
  },
};

// Create the passed pie chart options
var passedOptions = {
  series: [passedPercentage, remainingToPassPercentage],
  chart: {
    type: 'donut',
    height: '180',
  },
  labels: ['Passed Students', 'Remaining Students'],
  colors: ['#008000', '#2196F3'],
  plotOptions: {
    pie: {
      donut: {
        size: '70%',
      }
    }
  },
  dataLabels: {
    enabled: false
  },
  legend: {
    show: false
  },
};

// Create the failed pie chart options
var failedOptions = {
  series: [failedPercentage, remainingToFailPercentage],
  chart: {
    type: 'donut',
    height: '180',
  },
  labels: ['Failed Students', 'Remaining Students'],
  colors: ['#FF1744', '#2196F3'],
  plotOptions: {
    pie: {
      donut: {
        size: '70%',
      }
    }
  },
  dataLabels: {
    enabled: false
  },
  legend: {
    show: false
  },
};

  // Render the pie charts
  var totalChart = new ApexCharts(document.querySelector("#totalChartContainer"), totalOptions);
  totalChart.render();

  var passedChart = new ApexCharts(document.querySelector("#passedChartContainer"), passedOptions);
  passedChart.render();

  var failedChart = new ApexCharts(document.querySelector("#failedChartContainer"), failedOptions);
  failedChart.render();
</script>
