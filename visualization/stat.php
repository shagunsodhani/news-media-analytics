<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>News</title>

        <link rel="icon" href="../../favicon.ico">
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,600">
        <link rel="stylesheet" type="text/css" href="css/sequences.css"/>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/jumbotron-narrow.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
        

    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                 <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li><a href="db.php">Schema</a></li>
                        <li><a href="#">Intial Analysis</a></li>
                        <li><a href="#data-distribution">Data Distribution</a></li>
                        <li><a href="#">Export</a></li>
                    </ul>
                </div>

        <div class="container">
            <div class="header">
                <ul class="nav nav-pills pull-right">
                    <li ><a href="home.php">Home</a></li>
                    <li><a href="search.php">Search</a></li>
                    <li class="active"><a href="stat.php">Stats</a></li>
                    <li><a href="team.php">Team</a></li>
                </ul>
                <h3 class="text-muted">News Analytics</h3>
            </div>

             
            <div id="data-distribution">
                <div id="main">
                    <div id="sequence"></div>
                    <div id="chart">
                        <div id="explanation" style="visibility: hidden;">
                          <span id="percentage"></span><br/>
                          of total headlines come from this source.
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div id="sidebar">
              <input type="checkbox" id="togglelegend"> Legend<br/>
              <div id="legend" style="visibility: hidden;"></div>
            </div> -->
                </div>
            </div>
        </div>
        
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/d3.v3.min.js"></script>
        <script type="text/javascript" src="js/summary.js"></script>
        <script type="text/javascript">
        // Hack to make this example display correctly in an iframe on bl.ocks.org
        d3.select(self.frameElement).style("height", "700px");
        </script>
  </body>
</html>
