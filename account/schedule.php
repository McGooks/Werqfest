<?php
session_start();
include("../db/conn.php");
require("../db/account.php");
require("../db/myaccount.php");
include("../db/artists.php");

$usertype = $_SESSION['useraccount'];
$username = $_SESSION['username'];
$uid = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    echo "user not allowed";
    header("location: http://gmcgookin01.lampt.eeecs.qub.ac.uk/Werqfest/");
}

if (isset($_POST['logout'])) {
    $account = new Account();
    $login = true;
    try {
        $account->logout();
        if ($login) {
            session_destroy();
            header("location: http://gmcgookin01.lampt.eeecs.qub.ac.uk/Werqfest/");
        } else {
            echo 'Authentication failed.<br>';
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
}



$schedule = $s1;
$schedule2 = $s2;

$table = $db;
$read = $artistedit;
$result = $pdo->query($read);
if (!$result) {
    echo $pdo->error;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Account</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Molle:400i&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/f5c1f44cdd.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="../ckeditor/ckeditor.js"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.rawgit.com/octoshrimpy/bulma-o-steps/master/bulma-steps.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" href="../css/sched.css">
    <link rel="stylesheet" href="../css/schedule.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/my-account.css">
</head>

<body>
    <section>
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
                        <a href="#" class="navbar-item is-active">
                            MY ACCOUNT
                        </a>
                        <span class="navbar-item">
                            <form method="POST">
                                <input class="button is-success" type="submit" name="logout" value="LOGOUT" />
                            </form>
                        </span>
                    </div>
                </div>
            </div>
        </header>
    </section>

    <section class="editartist-nav-main">
        <div class="container">
            <h1 class="title is-1">My Schedule</h1>
            <h2 class="subtitle">
                Lets make a plan, ma'am
            </h2>
            <div class="tabs is-centered is-boxed is-medium">
                <ul>
                    <li>
                        <a href="index.php">
                            <span class="icon is-small"><i class="fas fa-user" aria-hidden="true"></i></span>
                            <span>My User Details</span>
                        </a>
                    </li>
                    <li>
                        <?php if ($usertype == 3){ 
					echo "
                    <a href='artist.php'>
                        <span class='icon is-small'><i class='fas fa-music' aria-hidden='true'></i></span>
                        <span>My Artist Details</span>
                    </a>
                </li>
					";
				}
				?>
                    <li>
                        <a href="messages.php?userid=$u_id">
                            <span class="icon is-small"><i class="fas fa-envelope" aria-hidden="true"></i></span>
                            <span>Messages</span>
                        </a>
                    </li>
                    <li>
                    <li class="is-active">
                        <a href='schedule.php'>
                            <span class='icon is-small'><i class='fas fa-calendar-day' aria-hidden='true'></i></span>
                            <span>My Schedule</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </section>
    <section class="section performers">
        <div class="container">
            <div class="columns">
                <div class="column is-8">
                    <div class="cd-schedule loading">
                        <div class="timeline">
                            <ul>
                                <li><span>14:00</span></li>
                                <li><span>14:30</span></li>
                                <li><span>15:00</span></li>
                                <li><span>15:30</span></li>
                                <li><span>16:00</span></li>
                                <li><span>16:30</span></li>
                                <li><span>17:00</span></li>
                                <li><span>17:30</span></li>
                                <li><span>18:00</span></li>
                                <li><span>18:30</span></li>
                                <li><span>19:00</span></li>
                                <li><span>19:30</span></li>
                                <li><span>20:00</span></li>
                                <li><span>20:30</span></li>
                                <li><span>21:00</span></li>
                                <li><span>21:30</span></li>
                                <li><span>22:00</span></li>
                                <li><span>22:30</span></li>
                                <li><span>23:00</span></li>
                            </ul>
                        </div>

                        <div class="events">
                            <?php
                                $output = $pdo->query($schedule);
                                    if (!$output) {
                                echo $pdo->error;
                            } 
                             while ($row = $output->fetch()){
                                $artistName = $row["act_name"];
                                $locale = $row["locale"];
                                $stage = $row['stage'];
                                $starttime = $row["timeslot"];
                                $day = $row['perfday'];
                                $stime = date("H:i", strtotime($starttime));
                                $etime = date("H:i", strtotime($starttime) + 3600);
                                $actype = strtolower($row["atype"]);

                                
                                switch ($stage){
                                    case 1:
                                        $mainstg1[] = array("<li class='single-event' data-start='$stime' data-end='$etime' data-content='event-$actype' data-event='event-1'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName</em>
                                        </a>
                                    </li>");
                                    break;
                                    case 2:
                                        $dancestg1[] = array("<li class='single-event' data-start='$stime' data-end='$etime' data-content='event-$actype' data-event='event-2'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName</em>
                                        </a>
                                    </li>");
                                    break;
                                    case 3:
                                        $qweensstg1[]= array("<li class='single-event' data-start='$stime' data-end='$etime' data-content='event-$actype' data-event='event-3'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName</em>
                                        </a>
                                    </li>");
                                     break;
                                     case 4:
                                        $villagestg1[]= array("
                                        <li class='single-event' data-start='$stime' data-end='$etime' data-content='event-$actype' data-event='event-4'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName</em>
                                        </a>
                                        </li>");
                                     break;
                                    }
                            }
                        
                        ?>
                            <ul class="wrap">
                                <?php
                        if(!empty($mainstg1)){
                        echo "<li class='events-group'>
                        <div class='top-info'><span>Main Stage</span></div>
                        <ul>";
                            if (is_array($mainstg1) || is_object($mainstg1)) {
                                foreach ($mainstg1 as $row) {
                                    echo implode("', '", $row);
                                }         
                            };
                        echo"</ul> 
                        </li>";
                     };

                     if(!empty($dancestg1)){
                        echo "<li class='events-group'>
                        <div class='top-info'><span>Dance Stage</span></div>
                        <ul>";
                            if (is_array($dancestg1) || is_object($dancestg1)) {
                                foreach ($dancestg1 as $row) {
                                    echo implode("', '", $row);
                                }         
                            };
                        echo"</ul> 
                        </li>";
                     };

                     if(!empty($qweensstg1)){
                        echo "<li class='events-group'>
                        <div class='top-info'><span>Qweens</span></div>
                        <ul>";
                            if (is_array($qweensstg1) || is_object($qweensstg1)) {
                                foreach ($qweensstg1 as $row) {
                                    echo implode("', '", $row);
                                }         
                            };
                        echo"</ul> 
                        </li>";
                     };

                     if(!empty($villagestg1)){
                        echo "<li class='events-group'>
                        <div class='top-info'><span>Village/span></div>
                        <ul>";
                            if (is_array($villagestg1) || is_object($villagestg1)) {
                                foreach ($villagestg1 as $row) {
                                    echo implode("', '", $row);
                                }         
                            };
                        echo"</ul> 
                        </li>";
                     }; ?>

                            </ul>
                        </div>
                        <div class="event-modal">
                            <header class="header">
                                <div class="content">
                                    <span class="event-date"></span>
                                    <h3 class="event-name"></h3>
                                </div>
                                <div class="header-bg"></div>
                            </header>
                            <div class="body">
                                <div class="event-info"></div>
                                <div class="body-bg"></div>
                            </div>
                            <a href="#0" class="close"></a>
                        </div>
                        <div class="cover-layer"></div>
                    </div>
                    
                </div>
                <div class="column is-4">Auto</div>
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
    <script src="../js/menu-toggle.js"></script>
    <script src="../js/jquery.countdown.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/sched.js"></script>
</body>

</html>