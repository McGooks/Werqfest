<?php

include("db/conn.php");
include("db/home.php");
$inputa = $a;
$inputb = $b;

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
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <section class="hero is-light is-fullheight hero-image">
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
                            <a href="#" class="navbar-item is-active">
                                HOME
                            </a>
                            <a href="performers.php" class="navbar-item">
                                PERFORMERS
                            </a>
                            <a href="schedule.php" class="navbar-item">
                                SCHEDULE
                            </a>
                            <a class="navbar-item">
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
                <div id="clock"></div>
            </div>
        </div>
        <div class="container is-center mid-button-nav">
            <button onclick="window.location.href = 'performers.php'"
                class="button is-info is-inverted is-outlined">Performers</button>
            <button class="button is-primary is-inverted is-outlined">Buy Tickets</button>
        </div>
    </section>

    <section class="section headline-image">
        <div class="container">
            <h1 class="title is-1">Headline Performers</h1>
            <h2 class="subtitle">
                We have hand picked the <strong>biggest</strong>, acts from around the globe
            </h2>
            <div class="row">
                <?php
                            
                            $output = $pdo->query($inputa);
                            if (!$output) {
                                echo $pdo->error;
                            }
                            while ($row = $output->fetch()) {

                                $artistid = $row["artist_id"];
                                $artistName = $row["act_name"];
                                $img = $row["artimage"];
                                $bioshort = $row["bio_short"];
                                $time = $row["timeslot"];
                                $time = date("H:i", strtotime($time));
                                $stage = $row["stage_name"];
                                $webAddress = $row["web"];

                                echo "
                                <div class='col-lg-4 col-md-6 mb-4'>
                                    <div class='card'>
                                        <div class='card-header headline-performer-name mx-auto'>
                                        <p class='h3'>$artistName</p>
                                        </div>
                                        <img src='users/images/$img' class='card-img-top'>
                                        <div class='card-body'>
                                            <p class='card-text mb-2'>$bioshort</p>
                                            <div class='columns is-mobile'>
                                                <div class='column is-half is-offset-one-quarter'>
                                                    <a class='button is-fullwidth' href='performers-bio.php?performer=$artistid'>Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='card-footer mx-auto'>
                                            <div class='field is-grouped is-grouped-multiline info-pills'>
                                                <div class='control'>
                                                    <div class='tags has-addons'>
                                                        <span class='tag is-dark'>Time</span>
                                                        <span class='tag is-info'>$time</span>
                                                    </div>
                                                </div>
                                                <div class='control'>
                                                    <div class='tags has-addons'>
                                                        <span class='tag is-dark'>Stage</span>
                                                        <span class='tag is-success'>$stage</span>
                                                    </div>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ";};
                            ?>
            </div>
        </div>
    </section>
    <section class="section performer-image">
        <div class="container">
            <h1 class="title">Performers</h1>
            <h2 class="subtitle">
                Oh and did we not mention that there will be performances from these <strong>fierce</strong> queens?
            </h2>
            <div class="row">


                <?php 

                    $output = $pdo->query($inputb);
                    if (!$output) {
                        echo $pdo->error;
                    }
                    while ($row = $output->fetch()) {

                    $artistid = $row["artist_id"];
                    $artistName = $row["act_name"];
                    $img = $row["artimage"];
                    
                                   
                    echo "
                    <div class='col-6 col-lg-2 mb-4'>
                    
                        <div class='card'>
                        <div class='card-header performer mx-auto'>
                                        <p class='h6'>$artistName</p>
                                        </div>
                            <img src='users/images/$img' class='card-img-top'>
                            <div class='card-body'>
                            <div class='columns is-mobile'>
                                    <div class='column'>
                                    <a class='button is-fullwidth is-small' href='performers-bio.php?performer=$artistid'>Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div> 
                        ";};
                        ?>
            </div>
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
    <script src="js/jquery.countdown.js"></script>
    <script>
    $('#clock').countdown('2020/06/07').on('update.countdown', function(event) {
        var $this = $(this).html(event.strftime('' +
            '<span>%-D</span> day%!D ' +
            '<span>%H</span> hr ' +
            '<span>%M</span> min ' +
            '<span>%S</span> sec'));
    });
    </script>
</body>

</html>