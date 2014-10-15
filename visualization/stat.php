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
        <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        
        

    </head>

    <body>
    <script src="js/jquery-1.10.2.min.js"></script>
        <div class="container-fluid">
            <div class="row">
                 <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li><a href="db.php">Schema</a></li>
                        <li><a href="#initial-analysis">Intial Analysis</a></li>
                        <li><a href="#data-distribution">Data Distribution</a></li>
                        <li><a href="#search-distribution">Search Results Distribution</a></li>
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

            <div id="initial-analysis"> 
                 <div class="panel panel-default">
                    <!--

                     Default panel contents 

                    -->

                    <div class="panel-heading">

                        Initial Data Analysis

                    </div>
                    <!--

                     Table 

                    -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Description</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>Initial Data Size</td>
                                <td>2.8 MB</td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Final Data Size</td>
                                <td>1.8 MB</td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Start Day and Time</td>
                                <td>Fri, 03 Oct 2014 01:17:00 GMT</td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>End Day and Time</td>
                                <td>Fri, 04 Oct 2014 06:17:00 GMT</td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>Number of Unique URLs</td>
                                <td>8417</td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>Number of Unique Headlines</td>
                                <td>9270</td>
                            </tr>
                            <tr>
                                <td>7.</td>
                                <td>Number of Unique Sources</td>
                                <td>124</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                <br/><br/><br/><br/><br/><br/><br/>
            </div>
            

            <!-- <div id="sidebar">
              <input type="checkbox" id="togglelegend"> Legend<br/>
              <div id="legend" style="visibility: hidden;"></div>
            </div> -->

            <div id="search-distribution">
                <div class="jumbotron">


                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputSearch">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button" id= "searchButton">Go!</button>
                      </span>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
                  
                  </br></br></br></br>
                <div class="container">
                    <div class="col-sm-12" style="height:75px;">
                       <div class='col-md-6'>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker9'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker10'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        	$(function () {
                            $('#datetimepicker9').datetimepicker();
                            $('#datetimepicker10').datetimepicker();
                            $("#datetimepicker9").on("dp.change",function (e) {
                               $('#datetimepicker10').data("DateTimePicker").setMinDate(e.date);
                            });
                            $("#datetimepicker10").on("dp.change",function (e) {
                               $('#datetimepicker9').data("DateTimePicker").setMaxDate(e.date);
                            });
                        });
                    </script>
                </div>
            </div>
            </div>
                </div> 
            </div>
        </div>
        
        <script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/moment.js"></script>
        <script src="js/bootstrap-datetimepicker.js"></script>
        <script src="js/d3.v3.min.js"></script>
        <script type="text/javascript" src="js/summary.js"></script>
        <script type="text/javascript">
        // Hack to make this example display correctly in an iframe on bl.ocks.org
        d3.select(self.frameElement).style("height", "700px");
        </script>
        
        <script>
         
	    $(document).ready(function(){
	    $("#searchButton").click(function(){
	    var data = document.getElementById("inputSearch").value;
	    $.ajax({
	    type:"get",
	    url:"http://192.168.111.190/news-media-analytics/visualization/solr.php",
	    data:{search:data,from:1},
	    success:function(result){
	      $("#rahul").html(result);
	    		}}); 
	  		});
	    });

		</script>
  </body>
</html>
