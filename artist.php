<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $SearchQueryParameter = $_GET["id"];?>
<?php
            //Fetchinng all the artists
                    global $ConnectingDB;
                    $sql = "SELECT * FROM artists WHERE id='$SearchQueryParameter'";
                    $stmt = $ConnectingDB->query($sql);
                    while ($DataRows = $stmt->fetch()) {
                        $ArtistId = $DataRows["id"];
                        $ArtistName = $DataRows["name"];
                        $ArtistDOB = $DataRows["dob"];
                        $ArtistBio = $DataRows["bio"];
                    }?>
                                

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
    <title>Artist</title>
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
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <form class="d-flex" action="home.php">
                        
                        <input type="text" name="Search" class="form-control me-2" placeholder="song/artist/date">
                        <button class="btn btn-success" name="SearchButton"><i class="fa fa-search"></i></button>
                        
                    </form>
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
                <div class="card border-0">
                <div class="card-body">
                        <img src="images/concert.jpg" class="img-fluid float-start rounded me-4" style="width: 300px; height: 300px;" />
                        <h4 class="card-title"><?php echo htmlentities($ArtistName); ?></h4>
                        <small class="text-muted"><b>Born:</b> <?php echo htmlentities($ArtistDOB); ?></small>
                        <br>
                        <hr>
                        <p class="Card-text">
                            <?php echo htmlentities($ArtistBio); ?>
                        </p>
                        
                    </div>
                </div>
            </div>
            
            </div>
            <h2 class="mt-2 text-success">Top Rated Songs of <?php echo htmlentities($ArtistName); ?></h2>
        </div>
        
    </header>
    <!--HEADER END-->
    <!--Main Area-->
    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-8" style="min-height:800px;">
            <?php
               echo ErrorMessage();
               echo SuccessMessage();
           ?>
           <?php
                global $ConnectingDB;
                //SQLMquery fro searc
                if(isset($_GET["SearchButton"])){
                    $Search = $_GET["Search"];
                    $sql = "SELECT * FROM songs 
                    WHERE date LIKE :search
                    OR name LIKE :search
                    OR artists LIKE :search ORDER BY rating desc";
                    
                    $stmt = $ConnectingDB->prepare($sql);
                    $stmt->bindValue(':search','%'.$Search.'%');
                    $stmt->execute();
                }
                
                  
                  // The default SQL query
                  else{
                    $PostIdFromURL = $_GET["id"];
                    if(!isset($PostIdFromURL)){
                        $_SESSION["ErrorMessage"] = "Bad Reequest";
                        Redirect_to("blog.php");
                    }
                    $sql  = "SELECT * FROM songs 
                    WHERE artists LIKE :search ORDER BY rating desc";
                    $stmt = $ConnectingDB->prepare($sql);
                    $stmt->bindValue(':search','%'.$ArtistName.'%');
                    $stmt->execute();
                  }

                  
                while($DataRows = $stmt->fetch()){
                    $SongId = $DataRows["id"];
                    $SongName = $DataRows["name"];
                    $SongDate = $DataRows["date"];
                    $artists = $DataRows["artists"];
                    $rating = $DataRows["rating"];
                    $Image = $DataRows["image"];
                
                ?>
                
                <div class="card mb-4" style="background-color:#eee;">
                    
                    <div class="card-body">
                        <img src="uploads/<?php echo htmlentities($Image);?>" class="img-fluid float-start rounded-circle me-4" style="width: 150px; height: 150px;" />
                        <h4 class="card-title"><?php echo htmlentities($SongName); ?></h4>
                        <small class="text-muted">Released on <?php echo htmlentities($SongDate); ?></small>
                        <span style="float:right;" class="badge bg-dark"><i class="fas fa-heart text-success"></i> Rating 
                        <?php echo htmlentities($rating); ?>
                        </span><br>
                        <hr>
                        <p>
                            Artists: <?php echo htmlentities($artists); ?>
                        </p>
                        <a href="song.php?id=<?php echo $SongId;?>" style="float:right;">
                            <span class="btn btn-success">Play >></span>
                        </a>
                    </div>
                </div>
                <?php } ?>
            </div>
        <!-- </div>
        </div> -->
        <!-- Main Area End-->
          <!--Side Area-->
    <div class="col-sm-4" style="min-height:40px;">  
    
    <div class="card">
        <div class="card-header bg-success text-white">
            <h2>Artists</h2>
        </div>
        <div class="card-body" style="background-color:#eee">
            <p> Click on name to know more</p>
            

                
            <!--Artists-->
            
                    <?php
                                //Fetchinng all the artists
                                global $ConnectingDB;
                                $sql = "SELECT id,name FROM artists";
                                $stmt = $ConnectingDB->query($sql);
                                while ($DataRows = $stmt->fetch()) {
                                $ArtistId = $DataRows["id"];
                                $ArtistName = $DataRows["name"];
                                ?>
                                <div class="card">
                                <div class="card-body" style="background-color:#eee">
                                <img src="images/comment.png" class="img-fluid float-start rounded-circle me-4" style="width: 35px; height: 35px;" />
                                <a href="artist.php?id=<?php echo $ArtistId;?>">
                                    <h5 class="card-title"> <?php echo $ArtistName; ?></h5>
                                </a>
                                </div>
                                </div>
                                <?php } ?>
                        

                </div>
            </div>
        </div>
       
        
        
        </div>
    </div>
    
</div>
    </div>
    </div>
    </div>
                
    <!--End Side Area-->

    
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