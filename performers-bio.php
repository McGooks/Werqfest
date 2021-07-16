<?php

include("db/conn.php");
$a_id = $_GET['performer'];
$read = "SELECT artist_id, act_name, artimage, bio_long,wqf_timeslots.timeslot,wqf_stage.stage_name,web
FROM wqf_artist
INNER JOIN wqf_stage ON wqf_artist.stage = wqf_stage.stage_id
INNER JOIN wqf_timeslots ON wqf_artist.timeslot = wqf_timeslots.time_id
WHERE artist_id='$a_id'";

$result = $pdo->query($read);
if(!$result){
    echo $pdo->error;	
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WERQFEST</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Molle:400i&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f5c1f44cdd.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/performers-bio.css">
</head>

<body>

    <header class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item is-large" href="#">
                    <span class="icon">
                        <i class="fas fa-crown"></i>
                    </span>
                    <span>WERQFEST</span>
                </a>
                <span class="navbar-burger burger" data-target="navbarMenuHeroC">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </div>
            <div id="navbarMenuHeroC" class="navbar-menu">
                <div class="navbar-end">
                    <a href="index.php" class="navbar-item">
                        HOME
                    </a>
                    <a href="performers.php" class="navbar-item is-active">
                        PERFORMERS
                    </a>
                    <a href="schedule.php" class="navbar-item">
                        SCHEDULE
                    </a>
                    <a href="contact.php" class="navbar-item">
                        CONTACT
                    </a>
                    <a href="account/login.php" class="navbar-item">
                        MY ACCOUNT
                    </a>
                    <span class="navbar-item">
                        <a class="button is-success">
                            <span>BUY TICKETS</span>
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </header>

    <section class="section headline-image">
        <div class="container customwidth">

            <?php
                            while ($row = $result->fetch()) {

                                $a_id = $row["artist_id"];
                                $artistName = $row["act_name"];
                                $img = $row["artimage"];
                                $biolong = $row["bio_long"];
                                $date = $row["timeslot"];
                                $time = date("H:i", strtotime($date));
                                $day = date("D", strtotime($date));
                                $stage = $row["stage_name"];
                                $webAddress = $row["web"];

                                echo "
                                <h1 class='title is-1'>$artistName</h1>
                                <div class='columns'>
                                
                                    <div class='col-lg-8 col-md-6 mb-4'>
                                        
                                        <p>$biolong</p>
                                        <a href=$webAddress target='_blank' class='btn btn-primary btn-lg mt-4'>Artist Website</a>
                                    </div>
                                    <div class='column col-4'>
                                        <img src='users/images/$img' class='img-responsive img-thumbnail'/>
                                        <div class='col mx-auto mt-4'>
                                            <div class='field is-grouped is-grouped-multiline info-pills'>
                                            <div class='control'>
                                                    <div class='tags has-addons'>
                                                        <span class='tag is-dark'>Day</span>
                                                        <span class='tag is-success'>$day</span>
                                                    </div>
                                                </div>
                                                <div class='control'>
                                                    <div class='tags has-addons'>
                                                        <span class='tag is-dark'>Time</span>
                                                        <span class='tag is-info'>$time</span>
                                                    </div>
                                                </div>
                                                <div class='control'>
                                                    <div class='tags has-addons'>
                                                        <span class='tag is-dark'>Stage</span>";

                                                        if($day == "Sat"){
                                                            echo"
                                                        <span class='tag is-primary'>$day</span>
                                                    </div>";
                                                } elseif($day == "Sun") {
                                                    echo"
                                                    <span class='tag is-warning'>$day</span>
                                                </div>";
                                            } else {
                                                echo"
                                                    <span class='tag is-danger'>$day</span>
                                                </div>";
                                            }echo"
                                                </div>
                                            </div>
                                
                                        </div>
                                
                                    </div>
                                
                                </div>
                            ";};?>
            <a href='performers.php' class='btn btn-primary btn-lg'>back</a>
        </div>
    </section>

    <footer class="site-footer">
        <div class="footer-cover-title d-flex justify-content-center align-items-center">
        </div>
        <div class="footer-content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="entry-title">
                            <a href="index.php"><i class="fas fa-crown"></i>WERQFEST</a>
                            <h2>LET THE WEEKEND DRAG</h2>
                        </div>
                        <div class="entry-mail">
                            <a href="#">YASQWEEN@WERKFEST.COM</a>
                        </div>
                        <div class="iconic">
                            <div class="fa-3x">
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="js/menu-toggle.js"></script>
</body>

</html>