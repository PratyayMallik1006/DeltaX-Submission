<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $SearchQueryParameter = $_GET["id"];?>
<?php
    //Fetchinng song from songs table
        global $ConnectingDB;
        $sql = "SELECT * FROM songs WHERE id='$SearchQueryParameter'";
        $stmt = $ConnectingDB->query($sql);
        while ($DataRows = $stmt->fetch()) {
            $SongId = $DataRows["id"];
            $SongName = $DataRows["name"];
            $SongDate = $DataRows["date"];
            $Artists = $DataRows["artists"];
            $Image = $DataRows["image"];
            $rating = $DataRows["rating"];
            $ratingCount = $DataRows["rating_count"];
            
            }
            if(isset($_GET["play"])){
                echo '<audio autoplay="true" style="display:none;"><source src="songs/music.mp3"></audio>';
            }
            if(isset($_POST["Submit"])){
                $UserRating = $_POST["rating"];
                if(empty($UserRating)){
                  $_SESSION["ErrorMessage"]= "Rating fields must be filled out";
                  Redirect_to("song.php?id={$SearchQueryParameter}");
                } else{
                    $rating*=$ratingCount;
                    $ratingCount++;
                    $NewRating = (float) round((($rating + $UserRating)/$ratingCount),1);
                    $sql = "UPDATE songs SET 
                    rating = '$NewRating',
                    rating_count= '$ratingCount' 
                    WHERE id=$SearchQueryParameter";
                    $Execute =$ConnectingDB->query($sql);
                    if($Execute){
                    $_SESSION["SuccessMessage"]="Rating of song with id : " .$SearchQueryParameter." updated Successfully";
                    Redirect_to("song.php?id={$SearchQueryParameter}");
                    }else {
                    $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
                    Redirect_to("song.php?id={$SearchQueryParameter}");
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
    <title>Song</title>
</head>
<body id="app">
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
    <!--Main Area-->
    <header class="py-3">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
            <?php
               echo ErrorMessage();
               echo SuccessMessage();
           ?>
                <div class="card border-0">
                <img src="uploads/<?php echo htmlentities($Image);?>" class="img-fluid float-start rounded mx-auto" style="width: 200px; height: 200px;" />
                <div class="card-body text-center">
                        
                        <h4 class="card-title"><?php echo htmlentities($SongName); ?></h4>
                        <span>
                        <a href="song.php?id=1">
                        <i class="fa-solid fa-backward-fast fa-4x"></i>
                        </a>
                        <!-- <audio autoplay="true" style="display:none;"><source src="songs/music.mp3"></audio> -->
                        <a href="song.php?id=<?php echo $SearchQueryParameter?>&play=1">
                        <i class="fa-solid fa-circle-play fa-4x"></i>
                        </a>
                        <?php
                        $next= $SearchQueryParameter+1;
                        ?>
                        <a href="song.php?id=<?php echo $next;?>">
                        <i class="fa-solid fa-forward-fast fa-4x"></i>
                        </a>
                        </span>
                        <p class="Card-text">
                            <small class="text-muted"><b>Released on:</b> <?php echo htmlentities($SongDate); ?></small>
                            <br>
                            <p><b>Artists: </b><?php echo htmlentities($Artists); ?></p>
                            
                            <span class="badge bg-dark"><i class="fas fa-heart text-success"></i>
                            <?php echo htmlentities($rating); ?>
                            </span>
                            <span> <?php echo htmlentities($ratingCount); ?> Ratings</span>
                            <br>
                            <hr>
                            <div class="mt-2 py-2 container">
                                <span><i class="fas fa-heart text-success"></i><b> Rate this song</b></span>
                                <span>
                                <form action="song.php?id=<?php echo $SongId;?>" method="POST">
                                <div class="bg-dark my-2 mx-auto py-2" style="width: 250px;">
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating" id="inlineRadio1" value=1>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating" id="inlineRadio1" value=2>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating" id="inlineRadio1" value=3>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating" id="inlineRadio1" value=4>
                                </div>
                                <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating" id="inlineRadio1" value=5>
                                </div>
                                
                            </div>
                                <button type="submit" class="btn btn-success" name="Submit">Rate</button>
                                </form>
                                </span>
                            </div>
                            <hr>

                        </p>
                        
                    </div>
                </div>
            </div>
            
            </div>
            
        </div>
        
    </header>
    <!--Main Area END-->
    <!--Main Area-->
    <div class="container">
        <div class="row mt-4">
            <div class="col-sm-8">
            
           
            </div>
        </div>
        </div>
        <!-- Main Area End-->
   

    
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