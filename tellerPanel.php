<?php
    session_start();
    include "functions/displayStock.php";
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

    <div class="container-fluid manStockDiv">
        <div class="row"><br>
            <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="itemsDiv">
                        <p class="addMsg"></p>
                        <div class="well">
                            <form class="itemsForm"  method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Select Item</label><br>
                                        <select class="items" name="items"><?php displayStockFunc(); ?></select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Quantity Of Item</label><br>
                                        <input type="number" name="itemQuantity" class="itemQuantity" required min="1" value="1" required>
                                    </div>
                                </div><br><br>
                                <button type="button" class="btn btn-default addMoreBtn">Add Item</button>
                                <button type="submit" class="btn btn-primary checkoutBtn" form="itemsForm">Checkout</button>
                                <button type="button" class="btn btn-primary itemsBought">Number Of Items Bought: 0</button>
                                <button type="button" class="btn btn-primary quantityLeft"></button>
                            </form>
                        </div>
                    </div>
                    <div class="itemsDivSmall"></div>
                </div>
            <div class="col-md-1"></div>
        </div>
    </div>


    <script src="js/jquery2.2.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
        var items = [];
        var qLeft = 0;
        var show = "";
        $('.itemQuantity').on('input', function(){
            if ($(this).val().length > 0 && $(this).val() != 0 && $(this).val() >= 1) {
                $('.addMoreBtn').prop('disabled',false);
            }else if ($(this).val() == 0){
                $('.addMoreBtn').prop('disabled',true);
            }else if ($(this).val().length < 1){

                $('.addMoreBtn').prop('disabled',true);
            }
        });

        $('.items').on('change', function(){
            var itemsName = $('.items').val();
            var itemData = {'itemsName': itemsName};
            $.ajax( {
                type: "POST",
                url: "getQuantityLeft.php?itemsName="+itemsName,
                data: itemsName,
                dataType: 'text',
                success: function( data ) {
                    qLeft = data;
                    $('.quantityLeft').html("Quantity Of  " + itemsName + " left: "+ qLeft );
                },
                error: function(error){
                    console.log(error);
                }
            });
        });

        $('.checkoutBtn').prop('disabled',true);

        $('.addMoreBtn').on('click', function(){
            var itemValue = $('.items').val();
            var itemQuantity = $('.itemQuantity').val();
            var newQuantity = qLeft - itemQuantity;
            if (newQuantity < 0) {
                $('.quantityLeft').html(itemQuantity +"  samples of " + itemValue + " cannot be purchased. There is "+ qLeft+" left" );
            }else if (itemValue != null && itemQuantity >= 1) {
                var itemValue = $('.items').val();
                var itemQuantity = $('.itemQuantity').val();
                var itemBought = itemValue+ " "+itemQuantity;
                items.push(itemBought);
                var lastItem = items[items.length -1 ];
                var showItem = lastItem.split(" ");
                var quan = showItem[showItem.length -1];
                var itName = showItem.slice(0,showItem.length -1);
                var itemName = itName[0];

                for (var i = 1; i < (itName.length); i++) {
                    itemName = itemName + " "+itName[i];
                }

                show = $("<div class='alert alert-info alert-dismissible'><button class='close' onclick='removeItem("+items.indexOf(items[items.length -1])+")' data-dismiss='alert'>&times;</button>"+
                "<span><strong>Item:</strong> "+itemName+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Quantity:</strong> "+quan+"</span></div>");
                $('.itemsBought').html("Number Of Items Bought: "+items.length);
                $('.itemsDivSmall').after(show);
            }

            if (items.length > 0) {
                $('.checkoutBtn').prop('disabled',false);
            }

        });

        function removeItem(index){
            if (items.length == 1) {
                items = [];
                $('.checkoutBtn').prop('disabled',true);
            }else if (items.length > 1){
                items.splice(index,1);
            }

            $('.itemsBought').html("Number Of Items Bought: "+items.length);
            console.log(items);
        }

        $('.checkoutBtn').on('click',function(){
            window.location = 'calculateItems.php?itemsBought='+JSON.stringify(items);
        });

    </script>
  </body>
</html>
