<?php
session_start();
include "conn.php";

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
                            <a href="performers.php" class="navbar-item">
                                PERFORMERS
                            </a>
                            <a href="schedule.php" class="navbar-item">
                                SCHEDULE
                            </a>
                            <a href="#" class="navbar-item is-active">
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

    <section class="section headline-image">
        <div class="container headline">
            <h1 class="title is-1">Headline Performers</h1>
            <h2 class="subtitle">
                A simple container to divide your page into <strong>sections</strong>, like the one you're currently
                reading
            </h2>

            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Get in Touch</h2>
                </div>
                <div class="col-lg-8">
                    <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm"
                        novalidate="novalidate">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">

                                    <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'"
                                        placeholder='Enter Message'></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="name" id="name" type="text"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'"
                                        placeholder='Enter your name'>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="email" id="email" type="email"
                                        onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = 'Enter email address'"
                                        placeholder='Enter email address'>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="subject" id="subject" type="text"
                                        onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'"
                                        placeholder='Enter Subject'>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm btn_4 boxed-btn">Send
                                Message</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info">
                        <span class="address"><i class="fas fa-home"></i></span>
                        <div class="media-body">
                            <h3>Oremau Park, Belfast</h3>
                            <p>County Antrim, Northern Ireland</p>
                        </div>
                    </div>
                    <div class="contact-info">
                        <span class="tel"><i class="fas fa-mobile"></i></span>
                        <div class="media-body">
                            <h3>+44 (0) 0123456789</h3>
                        </div>
                    </div>
                    <div class="contact-info">
                        <span class="email"><i class="fas fa-envelope"></i></span>
                        <div class="media-body">
                            <h3>YASQWEEN@WERKFEST.COM</h3>
                        </div>
                    </div>
                </div>
            </div>
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