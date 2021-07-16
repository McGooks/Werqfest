<?php
session_start();
require("../db/account.php");

if (isset($_POST['loginname'])) {

    $account = new Account();
    include "../db/conn.php";
    $login = false;
    try {
        $login = $account->login($_POST['loginname'], $_POST['loginpw']);
    } catch (Exception $e) {
        echo $e->getMessage();
        header("location: login.php");
        $_SESSION['error_message'] = "I'm sorry my dear, but you are up for <strong>Elimination</strong>. You should contact us";
        exit();
        $login = false;

    }

    if ($login) {
        $_SESSION['useraccount'] = $account->getUserType();
        $_SESSION['user_id'] = $account->getId();
        $_SESSION['username'] = $account->getName();
        $uid = $account->getId();

        $accountcheck = $account->LoginAccountCheck($uid);
        if ($accountcheck) {
            header("location: index.php");
        } else {
            header("location: createaccount.php");
        }
    }

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>
    <section>
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
                            <a href="../index.php" class="navbar-item is-active">
                                HOME
                            </a>
                            <a href="../performers.php" class="navbar-item">
                                PERFORMERS
                            </a>
                            <a href="../schedule.php" class="navbar-item">
                                SCHEDULE
                            </a>
                            <a href="../contact.php" class="navbar-item">
                                CONTACT
                            </a>
                            <a href="#" class="navbar-item">
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
    </section>

    <section class="section is-medium">
        <div class="container">
            <div class="columns">
                <div class="column is-half">
                    <h1 class="title is-1">Login to My Account</h1>
                    <h2 class="subtitle">
                        Bring back my <strong>Gurls!</strong>
                    </h2>
                    <?php 
                    if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
                        echo "
                                <div class='notification is-warning is-light'>
                    <button class='delete'></button>" . $_SESSION['error_message'] . "</div>";
                        unset($_SESSION['error_message']);
                    }
                    ?>

                    <form method='POST' action='login.php' enctype='multipart/form-data' validate>
                        <div class="field">
                            Username:
                            <p class="control has-icons-left has-icons-right">
                                <input class="input" type="email" placeholder="Username" value='' name='loginname'
                                    required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </p>
                        </div>
                        <div class="field">
                            Password:
                            <p class="control has-icons-left">
                                <input class="input" type="password" placeholder="Password" value='' name='loginpw'
                                    required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </p>
                        </div>
                        <div class="field is-grouped">
                            <p class="control">
                                <button type='submit' value='login' class="button is-success">
                                    Login
                                </button>
                            </p>
                            <p class="control">
                                <a href="signup.php" value='signup' class="button is-success is-inverted">
                                    Sign Up
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
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
                            <a href="../index.php"><i class="fas fa-crown"></i>WERQFEST</a>
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

    <script src="../js/menu-toggle.js"></script>
    <script src="../js/jquery.countdown.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
            $notification = $delete.parentNode;

            $delete.addEventListener('click', () => {
                $notification.parentNode.removeChild($notification);
            });
        });
    });
    </script>
</body>

</html>