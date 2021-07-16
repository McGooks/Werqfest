<?php
session_start();
include "db/conn.php";
require "db/account.php";
include "db/artists.php";

$read = $perf;
$result = $pdo->query($read);
if (!$result) {
    echo $pdo->error;
}

$stage = $ps;
$stageresults = $pdo->query($stage);

if (!$stageresults) {
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
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/performers.css">
</head>

<body>
    <section class="hero is-light is-medium hero-image">
        <div class="hero-head top-nav">
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
                            <a href="#" class="navbar-item is-active">
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
        </div>
        <div class="hero-body">
            <div class="container has-text-centered splash-central">
                <div class="icon mid-title-text"><i class="fas fa-3x fa-crown"></i></div>
                <div class="date-title">
                    <p>Sunday, 7th June 2020</p>
                </div>
                <h2 class="subtitle mid-subtitle-text">WERQFEST</h2>
            </div>
        </div>
        </section>


        <section class="section performers">
            <div class="container">
                <h1 class="title is-1">Performers</h1>
                <h2 class="subtitle">
                    We have Qweens, Kweens and <strong>Queens</strong>. They're spillin' the T, check out what they have to say...
                </h2>
                <div class="tabs is-toggle is-centered">
                <ul>
                <li>
                        <a href='performers.php'>
                            <span class='icon is-small'><i class='fas fa-music' aria-hidden='true'></i></span>
                            <span>All</span>
                        </a>
                    </li>
                    <?php 
                    while ($row = $stageresults->fetch()) {
                    $stage = $row['stage_name'];
                    $stageid = $row['stage_id'];
                    echo "
                    
                    <li>
                        <a href='performer-stage.php?stage_id=$stageid'>
                            <span class='icon is-small'><i class='fas fa-music' aria-hidden='true'></i></span>
                            <span>$stage</span>
                        </a>
                    </li>
					";
                    }?>
                    <hr>
                </ul>
                </div>

                <?php

                    echo "<div class='row pt-2'>";
                    while ($row = $result->fetch()) {
                        $artistid = $row["artist_id"];
                        $artistName = $row["act_name"];
                        $img = $row["artimage"];
                        $date0 = $row["timeslot"];
                        $time = date("H:i", strtotime($date0));
                        $day = date("D", strtotime($date0));

                        echo "
                        <div class='col col-lg-3 mb-4'>

                        <div class='card'>
                            <div class='card-header headliner mx-auto'>
                                <p class='h6'>$artistName</p>
                            </div>
                            <img src='users/images/$img' class='card-img-top'>
                            <div class='card-body'>
                                <div class='columns is-mobile'>
                                    <div class='column'>
                                        <a href='performers-bio.php?performer=$artistid' class='button is-fullwidth is-small'>Read More</a>
                                    </div>
                                </div>
                            </div>
                            <div class='card-footer mx-auto'>
                                <div class='field is-grouped is-grouped-multiline info-pills'>
                                <div class='control'>
                                        <div class='tags has-addons'>
                                            <span class='tag is-dark'>Day</span>";

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
                                    }
                                        
                                        echo"
                                    </div>
                                    <div class='control'>
                                        <div class='tags has-addons'>
                                            <span class='tag is-dark'>Time</span>
                                            <span class='tag is-info'>$time</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        ";}

                    echo "</div>";?>
            </div>
        </section>

<footer class="site-footer">
        <div class="footer-cover-title d-flex justify-content-center align-items-center"></div>
        <div class="footer-content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="entry-title">
                            <a href="#"><i class="fas fa-crown"></i>WERQFEST</a>
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