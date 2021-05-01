<!-- This file is used for viewing the retrieved data -->
<?php
  require_once "config.php"

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Covid vs Unemployment</title>

     <!-- Bootstrap -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

     <!-- Font Awesome [Logo] -->
     <script src="https://kit.fontawesome.com/9bfc0a438f.js" crossorigin="anonymous"></script>


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
              <a class="nav-link" href="index.php">Travel</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="market.php">Market</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="Unemployment.php">Unemployment</a>
            </li>
          </ul>
        </div>

        <div class="unemployment">
          <?php
            $query = "
              SELECT
                CovidData.Location AS Location,
                CovidData.Covid_Cases AS 2020_Cases,
                2019_Rate,
                2020_Rate,
                2021_Rate
              FROM (
              SELECT
                YEAR(date) AS Dates,
                generaldata.location AS Location,
                SUM(new_cases) AS Covid_Cases
              FROM generaldata
              WHERE location = :location
              AND YEAR(date) = 2020
              GROUP BY YEAR(date)
              ) AS CovidData
              LEFT JOIN (
              SELECT
                unemployment.location AS Location,
                `2019` AS 2019_Rate,
                `2020` AS 2020_Rate,
                `2021` AS 2021_Rate
              FROM unemployment
              WHERE location = :location
              ) AS UnempData
              ON CovidData.Location = UnempData.Location
            ";
            $queryAlt = "
              SELECT
                CovidData.Location AS Location,
                CovidData.Covid_Cases AS 2020_Cases,
                IFNULL(2019_Rate,'Data Not Available') AS 2019_Rate,
                IFNULL(2020_Rate,'Data Not Available') AS 2020_Rate,
                IFNULL(2021_Rate,'Data Not Available') AS 2021_Rate
              FROM (
                SELECT
                  YEAR(date) AS Dates,
                  generaldata.location AS Location,
                  SUM(new_cases) AS Covid_Cases
                FROM generaldata
                WHERE YEAR(date) = 2020
                GROUP BY generaldata.location
              ) AS CovidData
              LEFT JOIN (
                SELECT
                  unemployment.location AS Location,
                  `2019` AS 2019_Rate,
                  `2020` AS 2020_Rate,
                  `2021` AS 2021_Rate
                FROM unemployment
              ) AS UnempData
              ON CovidData.Location = UnempData.Location
              GROUP BY CovidData.Location
            ";
            if(isset($_GET['find'])) {
              $searchIpt = $_GET['location'];
              $locatData = $conn->prepare($query);
              $locatData->bindParam(":location", $searchIpt);
              $locatData->execute();
            }else {
              $locatData = $conn->prepare($queryAlt);
              $locatData->execute();
            }
          ?>
          <div class="container">
            <div class="card" style="margin-top: 50px;">
              <div class="card-body">
                <div class="col-sm-12">
                  <h4 class="card-title" style="color: #343434;">Search Location</h4>
                  <form method="get">
                    <div class="row align-items-center">
                      <div class="col-sm-6">
                        <div>
                          <input style="height: 35px; border-radius: 10px; width: 250px;" type="text" name="location" id="location" value="<?php echo isset($_GET['location'])?$_GET['location']:''?>" placeholder="Enter Country Name">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <div style="padding-top: 15px;">
                            <button type="submit" name="find" value="search" id="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Search</button>
                            <a href="<?php echo $_SERVER['PHP_SELF'];?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Clear</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <hr>

            <div>
              <table class="table table-striped table-bordered text-white">
                <thead>
                  <tr class="text-white">
                    <th>Search ID</th>
                    <th>Location</th>
                    <th>2020 Covid Cases</th>
                    <th>2019 Rate (%)</th>
                    <th>2020 Rate (%)</th>
                    <th>2021 Rate (%)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    if($locatData->rowCount() > 0) {
                      $SID = '';
                      foreach($locatData as $value) {
                        $SID++;
                  ?>
                  <tr>
                    <td><?php echo $SID; ?></td>
                    <td><?php echo $value['Location']; ?></td>
                    <td><?php echo $value['2020_Cases']; ?></td>
                    <td><?php echo $value['2019_Rate']; ?></td>
                    <td><?php echo $value['2020_Rate']; ?></td>
                    <td><?php echo $value['2021_Rate']; ?></td>
                  </tr>
                  <?php
                    }
                  }else {
                  ?>
                  <tr>
                    <td colspan="6" align="center">Location or Data Not Found!</td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>

          </div>

        </div>
      </div>
   </body>
 </html>
