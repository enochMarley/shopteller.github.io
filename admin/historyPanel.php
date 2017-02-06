<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <style media="screen">
        body{
            overflow-y: hidden;
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body data-spy="scroll" data-target="#myScrollspy" data-offset="20">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Shop Name Admin Panel</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li ><a href="manageStockPanel.php">Manage Stock</a></li>
                <li class="active"><a href="#">History</a></li>
                <li><a href="#">Show Shot Stock</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['username']; ?></a></li>
                <li><a href="../functions/logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
    </nav>

    <div class="container-fluid manStockDiv">
        <div class="row"><br>
            <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="well">
                        <h4 class="historyIntro">History Of Activities</h4>
                    </div>
                    <div class="historyView"><p></p></div>
                </div>
            <div class="col-md-1"></div>
        </div>
    </div>

    <script src="../js/jquery2.2.4.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function getAllStock(){
            $.ajax({
                method: 'GET',
                url: 'getHistory.php',
                success: function(data){
                    $('.historyView').html(data);
                },
                error: function(error){
                    console.log("Error " +error);
                }
            });
        }
        getAllStock();
    </script>
  </body>
</html>
