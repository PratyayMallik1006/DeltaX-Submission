<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if(isset($_SESSION["UserId"])){
  Redirect_to("Dashboard.php");
}

if (isset($_POST["Submit"])) {
  $UserName = $_POST["Username"];
  $Password = $_POST["Password"];
  $captcha=$_POST['captcha'];
  if (empty($UserName)||empty($Password)) {
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("Login.php");
  }
  if($_SESSION['CODE']!=$captcha){
    $_SESSION["ErrorMessage"]= "Captch incorrect/empty";
    Redirect_to("Login.php");
  }
  else {
    // code for checking username and password from Database
    $Found_Account=Login_Attempt($UserName,$Password);
    if ($Found_Account) {
      $_SESSION["UserId"]=$Found_Account["id"];
      $_SESSION["UserName"]=$Found_Account["username"];
      $_SESSION["AdminName"]=$Found_Account["aname"];
      $_SESSION["SuccessMessage"]= "Wellcome ".$_SESSION["AdminName"]."!";
      if (isset($_SESSION["TrackingURL"])) {
        Redirect_to($_SESSION["TrackingURL"]);
      }else{
      Redirect_to("Dashboard.php");
    }
    }else {
      $_SESSION["ErrorMessage"]="Incorrect Username/Password";
      Redirect_to("Login.php");
    }
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/9cabd83c0a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
</head>
<body>
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a href="#" class="navbar-brand">DeltaX</a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarcollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapse">
            
        </div>

        </div>

    </nav>
    <!--NAVBAR END-->
    <!--HEADER-->
    <header class="py-3">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-user"></i> Login</h1>
            </div>
            </div>
        </div>
    </header>
    <!--HEADER END-->
    <!--Main Area-->
    <section class="container py-2 mb-4">
      <div class="row">
        <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
          <br><br><br>
          <?php
           echo ErrorMessage();
           echo SuccessMessage();
           ?>
          <div class="card bg-secondary text-light">
            
              <div class="card-body" style="background-color:#444;">
              <form class="" action="Login.php" method="post">
                <div class="form-group">
                  <label for="username"><span class="FieldInfo">Username:</span></label>
                  <div class="input-group mb-3">
                    
                    <input type="text" class="form-control" name="Username" id="username" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="password"><span class="FieldInfo">Password:</span></label>
                  <div class="input-group mb-3">
                    
                    <input type="password" class="form-control" name="Password" id="password" value="">
                  </div>
                </div>
                <!--Captcha-->
                <div class="form-group">
                  <label for="captcha"><span class="FieldInfo">captcha:</span></label>
                  <div class="input-group mb-3">
                  <img src="captcha.php"/>
                    <input type="text" class="form-control" name="captcha" id="captcha" value="">
                  </div>
                </div>
                <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
              </form>

            </div>

          </div>

        </div>

      </div>

    </section>

    <!--Main Area End-->
    
    <!--FOOTER-->
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <p class="lead text-center">Made By Pratyay Mallik</p>
            </div>
        </div>
    </footer>
    <!--FOOTER END-->


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
</body>
</html>