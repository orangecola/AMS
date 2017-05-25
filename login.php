<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AMS Login</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="./build/css/custom.min.css" rel="stylesheet">
  </head>
<?php 
	include_once('config.php');
	//Redirect user to dashboard if logged in
	if (isset($_SESSION['user_ID'])) {
		header('Location: assetlist.php');
	}
	$Login_Failed=0;
	
	//Handle login
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		$result = $user->login($username, $password);
		
		if ($result) {
			header("Location: assetlist.php");
		}
		else {
			$Login_Failed = 1;
		}
	}



?>
  <body class="login">
    <div>
      <div class="login_wrapper">
        <div class="login_form">
          <section class="login_content">
            <form method="post">
              <h1>AMS Login</h1>
              <div>
                <input type="text" class="form-control" name="username" placeholder="Username"/>
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password"/>
				<?php if ($Login_Failed == 1) {echo '<ul class="parsley-errors-list filled" id="parsley-id-20"><li class="parsley-required">Invalid Username or Password</li></ul>';} ?>
              </div>
              <div>
                <button class="btn btn-default submit" type="submit">Log in</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

              </div>
            </form>
          </section>
        </div>
        </div>
      </div>
    </div>
  </body>
</html>
