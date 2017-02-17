<?php
    $tellerId = $_GET['tellerId'];
    $tellerName = $_GET['tellerName'];
    $tellerPassword = $_GET['tellerPassword'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Teller</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="formDiv">
					<!--<img src="../includes/images/Logo.png" alt="logo" class="img-circle formLogo"><br><br><br>-->
                    <h3 style="text-align:center;">Edit Teller</h3>
					<form class="adminLoginForm" action="formHandlers/editTellerFormHandler.php" method="post">
                        <input type="hidden" name="tellerId" value="<?php echo $tellerId; ?>">
                        <input type="hidden" name="oldTellerName" value="<?php echo $tellerName; ?>">
						<label>Teller Username:</label>
						<input type="text" name="editTellerName" value="<?php echo $tellerName?>" required placeholder="Admin Username"><br><br>
						<label>Teller Password:</label><br>
						<input type="text" name="editTellerPassword" value="<?php echo $tellerPassword?>" required placeholder="Admin Password"><br><br>
						<button type="submit" class="btn btn-default submitBtn">Update</button>
					</form><br><br>
				</div>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
    <script src="../js/jquery2.2.4.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
