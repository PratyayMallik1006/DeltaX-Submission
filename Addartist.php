<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php
if(isset($_POST["Submit"])){
  $name = $_POST["ArtistName"];
  $dob = $_POST["ArtistDOB"];
  $bio = $_POST["ArtistBio"];

  
  if(empty($name)||empty($dob)||empty($bio)){
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("Addartist.php");
  }elseif (strlen($name)<3) {
    $_SESSION["ErrorMessage"]= "name should be greater than 2 characters";
    Redirect_to("Addartist.php");
  }elseif (strlen($name)>49) {
    $_SESSION["ErrorMessage"]= "name should be less than than 50 characters";
    Redirect_to("Addartist.php");
  }else{
    // Query to insert artist in DB When everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO artists(name,dob,bio)";
    $sql .= "VALUES(:ArtistName,:ArtistDOB,:ArtistBio)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':ArtistName',$name);
    $stmt->bindValue(':ArtistDOB',$dob);
    $stmt->bindValue(':ArtistBio',$bio);
    $Execute=$stmt->execute();

    if($Execute){
      $_SESSION["SuccessMessage"]="Artist with id : " .$ConnectingDB->lastInsertId()." added Successfully";
      Redirect_to("Addartist.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("Addartist.php");
    }
  }
} //Ending of Submit Button If-Condition
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/9cabd83c0a.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>Add Artist</title>
</head>
<body>
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
        <a href="home.php" class="navbar-brand fw-bold text-success">DeltaX</a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarcollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapse">
            <ul class="navbar-nav me-auto">
                
                <li class="navbar-item">
                    <a href="home.php" class="nav-link">Home</a>
                </li>
                <li class="navbar-item">
                    <a href="addsong.php" class="nav-link">Add Song</a>
                </li>
                <li class="navbar-item">
                    <a href="Addartist.php" class="nav-link">Add Artist</a>
                </li>
                
            </ul>
            
        </div>

        </div>

    </nav>
    <!--NAVBAR END-->
    <!--HEADER-->
    <header class="py-3">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-pen-to-square text-success"></i> Add New Artist</h1>
            </div>
            </div>
        </div>
    </header>
    <!--HEADER END-->
    <!--MAIN AREA-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:450px;">
            <?php
               echo ErrorMessage();
               echo SuccessMessage();
           ?>

            <form class="form-group" action="Addartist.php" method="POST">
                <div class="card text-light px-3">
                    <div class="card-header">
                    </div>
                    <div class="card-body py-4"  style="background:#444;">
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Artist Name: </span></lebel>
                            <input class="form-control" type="text" name="ArtistName" id="ArtistName" placeholder="Type name of artist" style="min-width:1000px">
                        </div>
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Date of birth: </span></lebel>
                            <input class="form-control" type="text" name="ArtistDOB" id="ArtistDOB" placeholder="Month day, year" style="min-width:1000px">
                        </div>
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Bio: </span></lebel>
                            <input class="form-control" type="text" name="ArtistBio" id="ArtistBio" placeholder="Bio" style="min-width:1000px">
                        </div>
                        <div class="row">
                            <div class="offset-1 col-lg-5" >
                                <a href="home.html" class="btn btn-success btn-block mt-3" style="width:80%"><i class="fa-solid fa-arrow-left"></i> Back To Home</a>
                            </div>
                            <div class="offset-1 col-lg-5">
                                <button type="submit" name="Submit" class="btn btn-info btn-block mt-3" style="width: 80%;">
                                    <i class="fa-solid fa-check"></i> Submit</a>
                                </button>
                                
                            </div>
                        </div>
                    </div>
                <div>
            </form>
            <br>
            <h2 style="color:#111">Existing Artists</h2>
      <table class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>ID. </th>
            <th> Name</th>
            <th>Date of birth</th>
            <th>More</th>
          </tr>
        </thead>
      <?php
      global $ConnectingDB;
      $sql = "SELECT * FROM artists ORDER BY id desc";
      $Execute =$ConnectingDB->query($sql);
      $SrNo = 0;
      while ($DataRows=$Execute->fetch()) {
        $ArtistId = $DataRows["id"];
        $ArtistName = $DataRows["name"];
        $ArtistDOB = $DataRows["dob"];
        $SrNo++;
      ?> 
      <tbody>
        
          <tr>
          <td><?php echo htmlentities($SrNo); ?></td>
          <td><?php echo htmlentities($ArtistName); ?></td>
          <td><?php echo htmlentities($ArtistDOB); ?></td>
          <td> <a href="artist.php?id=<?php echo $ArtistId;?>" class="btn btn-success">More Info</a>  </td>
          <tr>

      </tbody>
      <?php } ?>
      </table>


        </div>
        </div>

    </section>
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