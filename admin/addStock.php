<?php
    include "../functions/dbConfig.php";

    $stockName = $_POST['stockName'];
    $stockPrice = $_POST['stockPrice'];
    $stockQuantity = $_POST['stockQuantity'];
    $query = "INSERT INTO stocktbl(stockName,stockPrice,stockQuantity) VALUES('$stockName',$stockPrice,$stockQuantity)";
    $result  = $link->query($query);
    if ($result) { ?>
        <script type="text/javascript">
            alert("Item Added Successfully");
            window.location = 'manageStockPanel.php';
        </script>
<?php
    }else{?>
        <script type="text/javascript">
            alert("Error: Check Your Interenet Connection!");
            window.location = 'manageStockPanel.php';
        </script>
<?php }
?>
