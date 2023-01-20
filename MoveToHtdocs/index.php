<!-- This file is used for viewing the retrieved data -->
<?php
  require_once "config.php"

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Covid vs Travel</title>

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
          <h2 style="padding-top: 50px;">The Effect of Covid</h2>
          <!-- Tabs -->
          <ul class="nav nav-tabs custom-style">
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Travel</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="market.php">Market</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Unemployment.php">Unemployment</a>
            </li>
          </ul>
        </div>

        <div class="travel">
          <script type="text/javascript">
              <?php
                $flight_sql = $conn->prepare("
                  SELECT
                    CONCAT(MONTHNAME(STR_TO_DATE(CovidData.Dates, '%m')), \" \", CovidData.Years) AS Dates,
                    IF(CovidData.Years = 2020, 2020_Flight, NULL) AS Flights_In_2020,
                    IF(CovidData.Years = 2021, 2021_Flight, NULL) AS Flights_In_2021,
                    Total_Cases,
                    IF(CovidData.Years = VaccData.Years, Total_Vacc, NULL) AS Vaccination
                  FROM (
                    SELECT
                      MONTH(Date) AS Dates,
                      SUM(2020_flights) AS 2020_Flight,
                      SUM(2021_flights) AS 2021_Flight
                    FROM flight
                    GROUP BY MONTH(Date)
                  ) AS FlightData
                  LEFT JOIN (
                    SELECT
                      MONTH(date) AS Dates,
                      YEAR(date) AS Years,
                      SUM(new_cases) AS Total_Cases
                    FROM generaldata
                    WHERE location = 'world'
                    GROUP BY YEAR(date), MONTH(date)
                  ) AS CovidData
                  ON FlightData.Dates = CovidData.Dates
                  LEFT JOIN (
                    SELECT
                      MONTH(date) AS Dates,
                      YEAR(date) AS Years,
                      (total_vaccinations/50) AS Total_Vacc
                    FROM vaccination
                    WHERE location = 'world'
                    GROUP BY YEAR(date), MONTH(date)
                  ) AS VaccData
                  ON VaccData.Dates = CovidData.Dates
                  ORDER BY (CovidData.Years)
                ");
                ?>

                var travelData2020 = [<?php
                  $flight_sql->execute();
                  while ($info = $flight_sql->fetch()) {
                    echo $info['Flights_In_2020' ] . ','; // Concatenate with ,
                  }
                ?>];

                var travelData2021 = [<?php
                  $flight_sql->execute();
                  while ($info = $flight_sql->fetch()) {
                    echo $info['Flights_In_2021' ] . ','; // Concatenate with ,
                  }
                ?>];

                var covidData = [<?php
                  $flight_sql->execute();
                  while ($info = $flight_sql->fetch()) {
                    echo $info['Total_Cases' ] . ','; // Concatenate with ,
                  }
                ?>];

                var vaccData = [<?php
                  $flight_sql->execute();
                  while ($info = $flight_sql->fetch()) {
                    echo $info['Vaccination' ] . ','; // Concatenate with ,
                  }
                ?>];

                var xLabels = [<?php
                  $flight_sql->execute();
                  while ($info = $flight_sql->fetch()) {
                    echo '"' . $info['Dates' ] . '",'; // Concatenate with ,
                  }
                 ?>];

                 <?php $flight_sql = null; ?>

                 var chartData = [
                   {
                     text: 'Travel 2020',
                     values: travelData2020,
                     legendMarker: {
                       type: 'circle',
                       backgroundColor: '#007790',
                       borderColor: '#69dbf1',
                       borderWidth: '1px',
                       shadow: false,
                       size: '5px'
                     },
                     lineColor: '#007790',
                      marker: {
                        backgroundColor: '#007790',
                        borderColor: '#69dbf1',
                        borderWidth: '1px',
                        shadow: false
                      }
                    }, {
                      text: 'Travel 2021',
                      values: travelData2021,
                      legendMarker: {
                        type: 'circle',
                        backgroundColor: '#007790',
                        borderColor: '#69dbf1',
                        borderWidth: '1px',
                        shadow: false,
                        size: '5px'
                      },
                      lineColor: '#007790',
                       marker: {
                         backgroundColor: '#007790',
                         borderColor: '#69dbf1',
                         borderWidth: '1px',
                         shadow: false
                       }
                     }, {
                      text: 'Covid',
                      values: covidData,
                      legendMarker: {
                        type: 'circle',
                        backgroundColor: '#da534d',
                        borderColor: '#faa39f',
                        borderWidth: '1px',
                        shadow: false,
                        size: '5px'
                      },
                      lineColor: '#da534d',
                      marker: {
                        backgroundColor: '#da534d',
                        borderColor: '#faa39f',
                        borderWidth: '1px',
                        shadow: false
                      }
                    }, {
                      text: 'Vaccine (Per Fifty)',
                      values: vaccData,
                      legendMarker: {
                        type: 'circle',
                        backgroundColor: '#009872',
                        borderColor: '#69f2d0',
                        borderWidth: '1px',
                        shadow: false,
                        size: '5px'
                      },
                      lineColor: '#009872',
                      marker: {
                        backgroundColor: '#009872',
                        borderColor: '#69f2d0',
                        borderWidth: '1px',
                        shadow: false
                      }
                    }
                  ];

                 var chartConfig = {
                   type: 'line',
                   theme: 'classic',
                   backgroundColor: '#343434',
                   utc: true,
                   title: {
                     text: 'Travel vs Covid',
                     backgroundColor: '#343434',
                     fontColor: 'white',
                     fontSize: '24px',
                     height: '25px',
                     y: '7px'
                   },
                   legend: {
                     align: 'center',
                     backgroundColor: 'none',
                     borderWidth: '0px',
                     item: {
                       fontColor: '#f6f7f8',
                       fontSize: '14px'
                     },
                     layout: 'float',
                     offsetY: '35px',
                     shadow: false,
                     textAlign: 'middle'
                   },
                   plot: {
                     hoverMarker: {
                       type: 'circle',
                       borderWidth: '1px',
                       size: '4px'
                     },
                     lineWidth: '3px',
                     marker: {
                       type: 'circle',
                       size: '3px'
                     },
                     shadow: false,
                     tooltipText: '%t views: %v<br>%k'
                   },
                   plotarea: {
                     margin: '15% 11% 14% 15%',
                     backgroundColor: '#343434'
                   },
                   scaleX: {
                     values: xLabels,
                     guide: {
                       lineColor: '#f6f7f8'
                     },
                     item: {
                       fontColor: '#f6f7f8'
                     },
                     label: {
                       visible: false
                     },
                     lineColor: '#f6f7f8',
                     shadow: false,
                     tick: {
                       lineColor: '#f6f7f8'
                     }
                   },
                   scaleY: {
                     values: '0:24000000:2000000',
                     guide: {
                       lineColor: '#f6f7f8',
                       lineStyle: 'dashed'
                     },
                     item: {
                       fontColor: '#f6f7f8'
                     },
                     label: {
                       text: 'Units',
                       fontSize: '14px',
                       fontColor: '#f6f7f8'
                     },
                     lineColor: '#f6f7f8',
                     minorTicks: 0,
                     shadow: false,
                     thousandsSeparator: ',',
                     tick: {
                       lineColor: '#f6f7f8'
                     }
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
                   tooltip: {
                     visible: false
                   },
                   series: chartData
                  };

                 window.addEventListener('load', function() {
                   zingchart.render({
                     id: "lineGraph",
                     data: chartConfig
                   })
                 });

              </script>
              <div id="lineGraph" class="chart-container"></div>
        </div>
      </div>
   </body>
 </html>
