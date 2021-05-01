<!-- This file is used for viewing the retrieved data -->
<?php
  require_once "config.php"

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>

     <!-- Bootstrap -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

     <!-- ZingCharts -->
     <script src="https://cdn.zingchart.com/zingchart.min.js"></script>


     <link rel="stylesheet" href="css/master.css">
   </head>
   <body>
      <div class="container general-style">
        <div class="options">
          <h2 style="padding-top: 50px;">Covid VS ...</h2>
          <!-- Tabs -->
          <ul class="nav nav-tabs custom-style">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Travel</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="market.php">Market</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Unemployment.php">Unemployment</a>
            </li>
          </ul>
        </div>

        <div class="market">
          <script type="text/javascript">
              <?php
                $market_sql = $conn->prepare("
                SELECT
                  AmazonStock.Dates AS Dates,
                    CovidData.Total_Cases AS Total_Cases,
                    IF(CovidData.Years = VaccData.Years, Total_Vacc, NULL) AS Vaccination,
                    AmazonStock.Highest_Open_Month AS Amazon_Open,
                    IXICStock.Highest_Open_Month AS NASDAQ_Open,
                    N225Stock.Highest_Open_Month AS Nikkei_Open,
                    GoogleStock.Highest_Open_Month AS Google_Open
                  FROM (
                    SELECT
                      CONCAT(MONTHNAME(Date), \" \", YEAR(Date)) AS Dates,
                      MIN(amzn.Open) AS Highest_Open_Month
                    FROM amzn
                    GROUP BY YEAR(Date), MONTH(Date)
                  ) AS AmazonStock
                  LEFT JOIN (
                    SELECT
                      CONCAT(MONTHNAME(Date), \" \", YEAR(Date)) AS Dates,
                      MIN(ixic.Open) AS Highest_Open_Month
                    FROM ixic
                    GROUP BY YEAR(Date), MONTH(Date)
                  ) AS IXICStock
                  ON AmazonStock.Dates = IXICStock.Dates
                  LEFT JOIN (
                    SELECT
                      CONCAT(MONTHNAME(Date), \" \", YEAR(Date)) AS Dates,
                      MIN(n225.Open) AS Highest_Open_Month
                    FROM n225
                    GROUP BY YEAR(Date), MONTH(Date)
                  ) AS N225Stock
                  ON AmazonStock.Dates = N225Stock.Dates
                  LEFT JOIN (
                    SELECT
                      CONCAT(MONTHNAME(Date), \" \", YEAR(Date)) AS Dates,
                      MIN(googl.Open) AS Highest_Open_Month
                    FROM googl
                    GROUP BY YEAR(Date), MONTH(Date)
                  ) AS GoogleStock
                  ON AmazonStock.Dates = GoogleStock.Dates
                  LEFT JOIN (
                    SELECT
                      CONCAT(MONTHNAME(date), \" \", YEAR(date)) AS Dates,
                      YEAR(date) AS Years,
                      SUM(new_cases) AS Total_Cases
                    FROM generaldata
                    WHERE location = 'world'
                    GROUP BY YEAR(date), MONTH(date)
                  ) AS CovidData
                  ON AmazonStock.Dates = CovidData.Dates
                  LEFT JOIN (
                    SELECT
                      CONCAT(MONTHNAME(date), \" \", YEAR(date)) AS Dates,
                      YEAR(date) AS Years,
                      (total_vaccinations/50) AS Total_Vacc
                    FROM vaccination
                    WHERE location = 'world'
                    GROUP BY YEAR(date), MONTH(date)
                  ) AS VaccData
                  ON VaccData.Dates = CovidData.Dates;
                ");
                ?>

                var xLabels = [<?php
                  $market_sql->execute();
                  while ($info = $market_sql->fetch()) {
                    echo '"' . $info['Dates' ] . '",'; // Concatenate with ,
                  }
                 ?>];

                var covidData = [<?php
                  $market_sql->execute();
                  while ($info = $market_sql->fetch()) {
                    echo $info['Total_Cases' ] . ','; // Concatenate with ,
                  }
                ?>];

                var vaccData = [<?php
                  $market_sql->execute();
                  while ($info = $market_sql->fetch()) {
                    echo $info['Vaccination' ] . ','; // Concatenate with ,
                  }
                ?>];

                var amznData = [<?php
                  $market_sql->execute();
                  while ($info = $market_sql->fetch()) {
                    echo $info['Amazon_Open' ] . ','; // Concatenate with ,
                  }
                ?>];

                var ixicData = [<?php
                  $market_sql->execute();
                  while ($info = $market_sql->fetch()) {
                    echo $info['NASDAQ_Open' ] . ','; // Concatenate with ,
                  }
                ?>];

                var n225Data = [<?php
                  $market_sql->execute();
                  while ($info = $market_sql->fetch()) {
                    echo $info['Nikkei_Open' ] . ','; // Concatenate with ,
                  }
                ?>];

                var googlData = [<?php
                  $market_sql->execute();
                  while ($info = $market_sql->fetch()) {
                    echo $info['Google_Open' ] . ','; // Concatenate with ,
                  }
                ?>];

                <?php $market_sql = null; ?>

                var chartData = [
                  {
                    type: 'bar',
                    text: 'Amazon',
                    values: amznData,
                    backgroundColor: '#ffa726',
                    scales: 'scale-x, scale-y-2'
                  },
                  {
                    type: 'bar',
                    text: 'NASDAQ',
                    values: ixicData,
                    backgroundColor: '#4b778d',
                    scales: 'scale-x, scale-y-2'
                  },
                  {
                    type: 'bar',
                    text: 'Nikkei',
                    values: n225Data,
                    backgroundColor: '#28b5b5',
                    scales: 'scale-x, scale-y-2'
                  },
                  {
                    type: 'bar',
                    text: 'Google',
                    values: googlData,
                    backgroundColor: '#8fd9a8',
                    scales: 'scale-x, scale-y-2'
                  },
                  {
                    type: 'line',
                    text: 'Covid',
                    values: covidData,
                    lineColor: '#da534d',
                    lineWidth: '3px',
                    marker: {
                      type: 'circle',
                      backgroundColor: '#da534d'
                    },
                    scales: 'scale-x, scale-y'
                  },
                  {
                    type: 'line',
                    text: 'Vaccine (Per Fifty)',
                    values: vaccData,
                    lineColor: '#81b214',
                    lineWidth: '3px',
                    marker: {
                      type: 'circle',
                      backgroundColor: '#81b214'
                    },
                    scales: 'scale-x, scale-y'
                  }
                ];

                var chartConfig = {
                  type: 'mixed',
                  backgroundColor: '#343434',
                  title: {
                    text: 'Market vs Covid',
                    align: 'center',
                    backgroundColor: '#343434',
                    fontColor: 'white',
                    fontSize: '24px',
                    height: '25px',
                    y: '7px'
                  },
                  legend: {
                    align: 'center',
                    backgroundColor: 'none',
                    item: {
                      fontColor: '#f6f7f8',
                      fontSize: '14px'
                    },
                    layout: 'float',
                    offsetY: '45px',
                    textAlign: 'middle'
                  },
                  plotarea: {
                    margin: '15% 11% 14% 15%',
                    backgroundColor: '#343434'
                  },
                  scaleX: {
                    labels: xLabels,
                    item: {
                      fontColor: '#f6f7f8'
                    },
                    label: {
                      visible: false
                    }
                  },
                  scaleY: {
                    values: '0:20000000:100000',
                    guide: {
                      lineColor: '#f6f7f8',
                      lineStyle: 'dashed'
                    },
                    item: {
                      fontColor: '#f6f7f8'
                    },
                    label: {
                      text: 'Population',
                      fontSize: '14px',
                      fontColor: '#f6f7f8'
                    },
                    thousandsSeparator: ','
                  },
                  scaleY2: {
                    values: '0:30000:3000',
                    guide: {
                      visible: false
                    },
                    item: {
                      fontColor: '#f6f7f8'
                    },
                    label: {
                      text: 'Dollar Amount',
                      fontSize: '14px',
                      fontColor: '#f6f7f8'
                    },
                    thousandsSeparator: ','
                  },
                  crosshairX: {
                    lineColor: '#f6f7f8',
                    plotLabel: {
                      padding: '10px',
                      borderColor: '#f6f7f8',
                      borderRadius: '5px',
                      borderWidth: '1px',
                      fontWeight: 'bold',
                      thousandsSeparator: ','
                    },
                    scaleLabel: {
                      backgroundColor: '#f6f7f8',
                      borderRadius: '5px',
                      fontColor: '#00baf0'
                    }
                  },
                  series: chartData
                };

                window.addEventListener('load', function() {
                  zingchart.render({
                    id: 'dataGraph',
                    data: chartConfig,
                    width: '100%',
                    height: 750
                  })
                });

          </script>
          <div id="dataGraph" class="chart-container"></div>
        </div>
      </div>
   </body>
 </html>
