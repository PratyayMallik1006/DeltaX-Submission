<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if(isset($_POST["Submit"])){
    $name = $_POST["SongName"];
    $date = $_POST["SongDate"];
    $Image = $_FILES["Image"]["name"];
    $Target = "uploads/".basename($_FILES["Image"]["name"]);
    $artistsId_arr = $_POST['artists'];
    $artistsId = implode(",",$artistsId_arr);
   
    $rating=1;
    $ratingCount=1;
    $artists="";
    foreach($artistsId_arr as $Id){
        
        global $ConnectingDB;
        $sql = "SELECT id,name FROM artists where id = $Id";
        $stmt = $ConnectingDB->query($sql);
        while ($DataRows = $stmt->fetch()) {
            $ArtistName = $DataRows["name"];
            $artists.=$ArtistName;
            $artists.=",";
        }
    }
   

  

  if(empty($name)){
    $_SESSION["ErrorMessage"]= "songname can not be empty";
    Redirect_to("addsong.php");
  }elseif (strlen($name)<3) {
    $_SESSION["ErrorMessage"]= "songname title should be greater than 2 characters";
    Redirect_to("addsong.php");
}
  else{
    // Query to insert songs in DB When everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO songs(name,date,image,artists,rating,artists_id,rating_count)";
    $sql .= "VALUES(:songName,:songDate,:imageName,:songArtists,:songRating, :artistsId, :ratingCount)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':songName',$name);
    $stmt->bindValue(':songDate',$date);
    $stmt->bindValue(':imageName',$Image);
    $stmt->bindValue(':songArtists',$artists);
    $stmt->bindValue(':songRating',$rating);
    $stmt->bindValue(':artistsId',$artistsId);
    $stmt->bindValue(':ratingCount',$ratingCount);
    
    $Execute=$stmt->execute();
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    if($Execute){
      $_SESSION["SuccessMessage"]="song with id : " .$ConnectingDB->lastInsertId()." added Successfully";
      Redirect_to("addsong.php");
    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("addsong.php");
    }
  }
 //Ending of Submit Button If-Condition


// $name = $_POST['SongName'];
// $artists = $_POST['artists'];
// $str = implode(",",$artists);
// $arr = explode(",",$str);

// print_r($name); echo "<br>";
// print_r($artists); echo "<br>";
// print_r($str); echo "<br>";
// print_r($arr); echo "<br>";
}
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous"
    referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/styles.css">
    <title>New Song</title>
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
                <h1><i class="fa-solid fa-pen-to-square text-success"></i> Add a New Song</h1>
            </div>
            
            </div>
        </div>
    </header>
    <!--HEADER END-->
    <!--MAIN AREA-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:500px;">
            <?php
               echo ErrorMessage();
               echo SuccessMessage();
           ?>
          

            <form class="form-group" action="addsong.php" method="POST" enctype="multipart/form-data">
                <div class="card text-light px-3" style="background:#444;">
                    <div class="card-header">
                    </div>
                    <div class="card-body py-4">
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Song Name: </span></lebel>
                            <input class="form-control" type="text" name="SongName" id="title" placeholder="Type new category title" style="min-width:1000px">
                        </div>
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Date of relese: </span></lebel>
                            <input class="form-control" type="text" name="SongDate" id="title" placeholder="May 15, 2013" style="min-width:1000px">
                        </div>
                        <div class="form-group mb-1">
                            <label for="image"><span class="FieldInfo">Artwork</Select></span></label>
                            <div class="custom-file">
                            <input type="file" name="Image" id="ImageSelect" class="custom-file-input" style="min-width:1000px">
                            <!--<label for="ImageSelect" class="custom-file-label">Select Image</Select></label>-->
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryTitle"><span class="FieldInfo">Artists: </span></lebel>
                            <select class="form-control selectpicker" multiple aria-label="Default select example" data-live-search="true" id="CategoryTitle" name="artists[]" style="min-width:1000px">

                                <?php
                                //Fetchinng all the artists
                                global $ConnectingDB;
                                $sql = "SELECT id,name FROM artists";
                                $stmt = $ConnectingDB->query($sql);
                                while ($DataRows = $stmt->fetch()) {
                                $ArtistId = $DataRows["id"];
                                $ArtistName = $DataRows["name"];
                                ?>
                                <option value="<?php echo $ArtistId?>"> <?php echo $ArtistName; ?></option>
                                <?php } ?>
                                
                            </select> <br>
                            <a class="btn btn-success mt-2" href="Addartist.php"><i class="fas fa-add"></i> Add new artist</a>
                        </div>
                        
           
                        <div class="row">
                            <div class="offset-1 col-lg-5" >
                                <a href="Dashboard.php" class="btn btn-success btn-block mt-3" style="width:80%"><i class="fa-solid fa-arrow-left"></i> Back To Dashboard</a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    
</body>
</html>