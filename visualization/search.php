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
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/jumbotron-narrow.css" rel="stylesheet">
        <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <body>
        <div class="container">
            <div class="header">
                <ul class="nav nav-pills pull-right">
                    <li><a href="home.php">Home</a></li>
                    <li class="active"><a href="search.php">Search</a></li>
                    <li><a href="stat.php">Stats</a></li>
                    <li><a href="team.php">Team</a></li>
                </ul>
                <h3 class="text-muted">News Analytics</h3>
            </div>

            <div class="jumbotron">


                <form role="search" >
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search" id="inputSearch">
                    </div>
                </form>

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
                
            



            <div class="row marketing">
                <div class="col-lg-12">
                    
                </div>
            </div>
        </div>
         <script>
         
   $(document).ready(function(){
    $.ajax({
    type:"get",
    url:"http://192.168.111.190/news-media-analytics/visualization/solr.php",
    data:{search:"pune",from:1},
    success:function(result){
      $(".col-lg-12").html(result);
    }}); 
  });

</script>
});

   </script>
   <script type="text/javascript" src="js/bootstrap.min.js"></script>
   <script src="js/moment.js"></script>
   <script src="js/bootstrap-datetimepicker.js"></script>
  </body>


</html>
