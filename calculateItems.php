<?php
    session_start();
    include "functions/displayStock.php";
    if (!isset($_SESSION['username'])) {
        header('Location: index.php');
    }
    include "functions/dbConfig.php";
    $itemsBought = json_decode($_GET['itemsBought']);
    $totalPrice = 0;
    $vatRate = 0.01;
    $nhisRate = 0.02;
    $itemArray = array();
    $priceArray = array();
    $quantityArray = array();
    $amountArray = array();
    $chargesArray = array();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
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
            <a class="navbar-brand" href="#">Shop Name Teller Panel</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['username']; ?></a></li>
                <li><a href="functions/logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
    </nav>

    <div class="container-fluid manStockDiv"><br><br>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h4 style="text-align:center;color:red;"><b>Please Don't Refresh This Page.</b></h4>
                <div class="well">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th>Price GH&cent;</th>
                        <th>Quantity</th>
                        <th>Amount GH&cent;</th>
                      </tr>
                    </thead>
                    <tbody>

<?php
    for ($i=0; $i < count($itemsBought); $i++) {
        $oneItem = $itemsBought[$i];
        $item = explode(' ',$oneItem);
        $quantity =  intval($item[count($item) -1]);
        array_pop($item);
        $itemGot = join(' ', $item);
        //echo "You bought ".$quantity." pieces of ".$itemGot."<br>";
        $query = "SELECT * FROM stocktbl WHERE stockName = '$itemGot';";
        $result = $link->query($query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $stockName = $row['stockName'];
                $stockPrice = $row['stockPrice'];
                $stockQuantity = $row['stockQuantity'];
                $stockId = $row['stockId'];

                $itemPrice = $stockPrice * $quantity;
                $newStockQuantity = $stockQuantity - $quantity;
                $link->query("UPDATE stocktbl SET stockQuantity = $newStockQuantity WHERE stockId = $stockId"); ?>

                <tr>
                    <td><?php echo $stockName; ?></td>
                    <td><?php echo $stockPrice; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td><?php echo $itemPrice; ?></td>
                </tr>
<?php       }
        }
        /*array_push($itemArray, $stockName);
        array_push($priceArray, $stockPrice);
        array_push($quantityArray, $quantity);
        array_push($amountArray, $itemPrice);*/
        $totalPrice += $itemPrice;
        $vatCharge = $vatRate * $totalPrice;
        $nhilCharge = $nhisRate * $totalPrice;
        $netPrice = $totalPrice + $vatCharge + $nhilCharge;
        /*array_push($chargesArray,$totalPrice);
        array_push($chargesArray,$vatCharge);
        array_push($chargesArray,$nhilCharge);
        array_push($chargesArray,$netPrice);*/
    } ?>
                    <br>
                    <tr>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td colspan="4">Total Price: GH&cent;<?php echo $totalPrice; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">VAT (<?php echo $vatRate*100;?>%): GH&cent; <?php echo $vatCharge; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">NHIL (<?php echo $nhisRate*100;?>%): GH&cent; <?php echo $nhilCharge; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">NET PRICE (<?php echo $nhisRate*100;?>%): <b>GH&cent; <?php echo $netPrice; ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="4"><a href="tellerPanel.php"><button type="button" class="btn btn-primary">Checkout</button></a></td>
                    </tr>
                    </tbody>
                </table>
                </div>
                </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <script src="js/jquery2.2.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    document.onkeydown = function(event){
        switch (event.keyCode){
            case 116 : //F5 button
                event.returnValue = false;
                event.keyCode = 0;
                return false;
            case 82 : //R button
                if (event.ctrlKey){
                    event.returnValue = false;
                    event.keyCode = 0;
                    return false;
                }
        }
    }
    </script>
    </body>
</html>
