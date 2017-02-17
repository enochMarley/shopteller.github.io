<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teller Login</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">


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
					<!--<img src="includes/images/Logo.png" alt="logo" class="img-circle formLogo"><br><br><br>-->
                    <h3 style="text-align:center;">The Lord's Step Ventures</h3>
                    <p class="inst">Enter Your Admin Username And Password To Login</p><br><br>
					<p class="errMsg"></p>
					<form class="adminLoginForm" action="" method="post">
						<!--<label>Teller Username:</label><br>-->
						<input type="text" name="tellerName" required placeholder="Teller Username"><br><br>
						<!--<label>Teller Password:</label><br>-->
						<input type="password" name="tellerPassword" required placeholder="Teller Password"><br><br>
						<button type="submit" class="btn btn-default submitBtn">Login</button>
					</form><br><br>
				</div>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
    <script src="js/jquery2.2.4.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

<?php
	error_reporting(0);
	include "functions/dbConfig.php";
	$tellerName = $_POST['tellerName'];
	$tellerPassword = $_POST['tellerPassword'];
	$query = "SELECT * FROM tellertbl WHERE tellerName = '$tellerName' AND tellerPassword = '$tellerPassword'";
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		if (!empty($tellerName) && !empty($tellerPassword)) {
			$result = $link->query($query);
			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				$username = $row['tellerName'];
				$password = $row['tellerPassword'];
				if ($username == $tellerName && $password == $tellerPassword) {
					session_start();
					$_SESSION['username'] = $username;
                    $historyStatement = "$username logged into the System";
                    $link->query("INSERT INTO historytbl(historyActivity) VALUES('$historyStatement');");
                    $link->close();
					?>
					<script type="text/javascript">
						$('.errMsg').html("Login Successful").css('color','blue');
						setTimeout(function(){
							window.location = "tellerPanel.php";
						}, 1000);
					</script>
		<?php	}
            }else{ ?>

                <script type="text/javascript">
                    $('.errMsg').html("Wrong Admin Username Or Password").css('color','red');
                    $('.formDiv').effect("bounce", "slow");
                </script>

	<?php   }
		}
	}
?>
