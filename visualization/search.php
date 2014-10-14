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

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <body>
        <div class="container">
            <div class="header">
                <ul class="nav nav-pills pull-right">
                    <li class="active"><a href="home.php">Home</a></li>
                    <li><a href="search.php">Search</a></li>
                    <li><a href="stat.php">Stats</a></li>
                    <li><a href="team.php">Team</a></li>
                </ul>
                <h3 class="text-muted">News Analytics</h3>
            </div>

            <div class="jumbotron">


                <form role="search" >
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                </form>

                <div id ="starttime">
                <form role="starttime">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                </form>
                </div>

                <div id ="endtime">
                <form role="endtime">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                </form>
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
    data:{search:"Obama",from:1},
    success:function(result){
      $(".col-lg-12").html(result);
    }}); 
  });

</script>
});
   </script>
  </body>


</html>
