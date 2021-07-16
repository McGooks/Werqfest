<?php
session_start();
include "../db/conn.php";
require "../db/account.php";
require "../db/myaccount.php";
include "../db/artists.php";

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

$schedule1 = $s1;
$schedule2 = $s2;
$schedule3 = $s3;

$table = $db;
$read = $artistedit;
$result = $pdo->query($read);
if (!$result) {
    echo $pdo->error;
}

if ($usertype > 2) {
    header("location: index.php");
}
$confartistread = $confartist;
$confartistresult = $pdo->query($confartistread);
if (!$confartistresult) {
    echo $pdo->error;
}
$timeq = $ti;
$timeresult = $pdo->query($timeq);
if (!$timeresult) {
    echo $pdo->error;
}
$perfq = $ps;
$perfresult = $pdo->query($perfq);
if (!$perfresult) {
    echo $pdo->error;
}

if (isset($_POST['updateschedule'])) {
    $account = new Account();
    try {
        $bookslots = $account->Schedule($_POST['act'], $_POST['stage'],$_POST['slot'], $uid);
        $_SESSION['success_message'] = "Submitted! Can I get an <strong>Amen</strong> up in here?";
        header("location: editschedule.php");
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
        echo "Dead";
    }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" href="../css/sched.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/schedule.css">
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
                            saturday
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
                    <?php if ($usertype < 3) {
    echo "<li>
                    <a href='useredit.php'>
                        <span class='icon is-small'><i class='fas fa-users-cog' aria-hidden='true'></i></span>
                        <span>User Admin</span>
                    </a>
                </li>
					";
}
?>
                    <li>
                        <?php if ($usertype < 3) {
    echo "
                            <a href='artistedit.php'>
                            <span class='icon is-small'><i class='fas fa-crown' aria-hidden='true'></i></span>
                            <span>Artist Admin</span>
                            </a>

				        	";}?>
                    </li>
                    <li>
                        <a href="messages.php?userid=$u_id">
                            <span class="icon is-small"><i class="fas fa-envelope" aria-hidden="true"></i></span>
                            <span>Messages</span>
                        </a>
                    </li>
                    <?php if ($usertype < 3) {
    echo "<li class='is-active'>
                    <a href='editschedule.php'>
                        <span class='icon is-small'><i class='fas fa-calendar-plus' aria-hidden='true'></i></span>
                        <span>Artist Schedule</span>
                    </a>
                </li>
					";
}
?>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="section performers">
        <div class="container">
        <?php
while ($row = $result->fetch()) {
    $artist_id = $row["artist_id"];
    $u_id = $row["userid"];
    $stat = $row["astatus"]; // Normalised Status 1-5 In Progress, 6 Confirmed, 7 Rejected;
    $status = $row["statusname"]; // Status In words
    $actname = $row["act_name"];
    $stageidx = $row['stage'];
    $stage = $row["stage_name"];
    $slot = $row["timeslot"];
    $day = date("l", strtotime($row["timeslot"]));
    $daysh = date("D", strtotime($row["timeslot"]));
    $date = date("d/m/Y", strtotime($row["timeslot"]));
    $time = date("g:i A", strtotime($row["timeslot"]));
    $isConfirmed = $row["is_confirmed"];
    if ($isConfirmed == 1) {
        $isConf = 'Yes';
    } else {
        $isConf = 'No';
    }}

?>
            <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) {
    echo "
            <div class='notification is-success is-light'>
  <button class='delete'></button>" . $_SESSION['success_message'] . "</div>";unset($_SESSION['success_message']);
}
?>
            <div class="columns">
            <div class="column is-4">
                    <form method='POST' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
                        enctype='multipart/form-data' validate>
                        <div class="field ">
                                    Act:
                                    <p class="control is-expanded has-icons-left">
                                        <span class="select">
                                            <select name='act' required>
                                                <?php 
                                                        echo "<option selected value='$artist_id'>$actname</option>";
                                                        while ($row = $confartistresult->fetch()) {
                                                            $artid = $row['artist_id'];
                                                            $artname = $row['act_name'];
                                                            if($artist_id != $artid){
                                                            echo "
					                                        <option value='$artid'>$artname</option>
                                                    ";}}
                                                        ?>
                                            </select>
                                        </span>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    </p>
                                </div>
                                <div class="field is-expanded">
                                    Stage:
                                    <p class="control is-expanded has-icons-left">
                                        <span class="select">
                                            <select name='stage' required>
                                                <?php 
                                                        echo "<option selected value='$stageidx'>$stage</option>";
                                                
                                                        while ($row = $perfresult->fetch()) {
                                                            $stageid = $row['stage_id'];
                                                            $psname = $row['stage_name'];
                                                            if($stageidx != $stageid){
                                                            echo "
                                                        <option value='$stageid'>$psname</option>
                                                            ";}}
                                                        ?>
                                            </select>
                                        </span>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                    </p>
                                </div>
                                <div class="field is-expanded">
                                    Slot:
                                    <p class="control is-expanded has-icons-left">
                                        <span class="select">
                                            <select name='slot' required>
                                                <?php 
                                                        echo "<option selected value='$slot'>$daysh $time</option>";
                                                        while ($row = $timeresult->fetch()) {
                                                            $tid = $row['time_id'];
                                                            $day = date("D", strtotime($row["timeslot"]));
                                                            $tslot = date("g:i A", strtotime($row["timeslot"]));
                                                            echo "
                                                        <option value='$tid'>$day $tslot</option>
                                                            ";}
                                                        ?>
                                            </select>
                                        </span>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </p>
                                </div>
                                <div class="field is-grouped">

            <p class="control">
                <button type='submit' name="updateschedule" value='updateschedule' class="button is-success">
                    Set Schedule
                </button>
            </p>
        </div>
                    </form>
                </div>
                <div class="column is-8">
                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-saturday-tab" data-toggle="pill" href="#pills-saturday"
                                role="tab" aria-controls="pills-saturday" aria-selected="true"><span
                                    class="icon is-small"><i class="fas fa-calendar-day"></i></span>
                                <span>Saturday</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-sunday-tab" data-toggle="pill" href="#pills-sunday" role="tab"
                                aria-controls="pills-sunday" aria-selected="false"><span class="icon is-small"><i
                                        class="fas fa-calendar-day"></i></span>
                                <span>Sunday</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-monday-tab" data-toggle="pill" href="#pills-monday" role="tab"
                                aria-controls="pills-monday" aria-selected="false"><span class="icon is-small"><i
                                        class="fas fa-calendar-day"></i></span>
                                <span>Monday</span></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-saturday" role="tabpanel"
                            aria-labelledby="pills-saturday-tab">
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

                                <div class="events day-1">
                                    <?php
$output1 = $pdo->query($schedule1);
if (!$output1) {
    echo $pdo->error;
}
while ($row1 = $output1->fetch()) {
    $artistName1 = $row1["act_name"];
    $locale1 = $row1["locale"];
    $stage1 = $row1['stage'];
    $starttime1 = $row1["timeslot"];
    $day1 = $row1['perfday'];
    $stime1 = date("H:i", strtotime($starttime1));
    $etime1 = date("H:i", strtotime($starttime1) + 3600);
    $actype1 = strtolower($row1["atype"]);

    switch ($stage1) {
        case 1:
            $mainstg1[] = array("<li class='single-event' data-start='$stime1' data-end='$etime1' data-content='event-$actype1' data-event='event-1'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName1</em>
                                        </a>
                                    </li>");
            break;
        case 2:
            $dancestg1[] = array("<li class='single-event' data-start='$stime1' data-end='$etime1' data-content='event-$actype1' data-event='event-2'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName1</em>
                                        </a>
                                    </li>");
            break;
        case 3:
            $qweensstg1[] = array("<li class='single-event' data-start='$stime1' data-end='$etime1' data-content='event-$actype1' data-event='event-3'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName1</em>
                                        </a>
                                    </li>");
            break;
        case 4:
            $villagestg1[] = array("
                                        <li class='single-event' data-start='$stime1' data-end='$etime1' data-content='event-$actype1' data-event='event-4'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName1</em>
                                        </a>
                                        </li>");
            break;
    }
}

?>
                                    <ul class="wrap">
                                        <?php
if (!empty($mainstg1)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Main Stage</span></div>
                        <ul>";
    if (is_array($mainstg1) || is_object($mainstg1)) {
        foreach ($mainstg1 as $row) {
            echo implode("', '", $row);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;

if (!empty($dancestg1)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Dance Stage</span></div>
                        <ul>";
    if (is_array($dancestg1) || is_object($dancestg1)) {
        foreach ($dancestg1 as $row) {
            echo implode("', '", $row);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;

if (!empty($qweensstg1)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Qweens</span></div>
                        <ul>";
    if (is_array($qweensstg1) || is_object($qweensstg1)) {
        foreach ($qweensstg1 as $row) {
            echo implode("', '", $row);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;

if (!empty($villagestg1)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Village</span></div>
                        <ul>";
    if (is_array($villagestg1) || is_object($villagestg1)) {
        foreach ($villagestg1 as $row) {
            echo implode("', '", $row);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;?>

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
                        <div class="tab-pane fade" id="pills-sunday" role="tabpanel" aria-labelledby="pills-sunday-tab">

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

                                <div class="events day-2">
                                    <?php
$output = $pdo->query($schedule2);
if (!$output) {
    echo $pdo->error;
}
while ($row = $output->fetch()) {
    $artistName = $row["act_name"];
    $locale = $row["locale"];
    $stage = $row['stage'];
    $starttime = $row["timeslot"];
    $day = $row['perfday'];
    $stime = date("H:i", strtotime($starttime));
    $etime = date("H:i", strtotime($starttime) + 3600);
    $actype = strtolower($row["atype"]);

    switch ($stage) {
        case 1:
            $mainstg[] = array("<li class='single-event' data-start='$stime' data-end='$etime' data-content='event-$actype' data-event='event-1'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName</em>
                                        </a>
                                    </li>");
            break;
        case 2:
            $dancestg[] = array("<li class='single-event' data-start='$stime' data-end='$etime' data-content='event-$actype' data-event='event-2'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName</em>
                                        </a>
                                    </li>");
            break;
        case 3:
            $qweensstg[] = array("<li class='single-event' data-start='$stime' data-end='$etime' data-content='event-$actype' data-event='event-3'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName</em>
                                        </a>
                                    </li>");
            break;
        case 4:
            $villagestg[] = array("
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
if (!empty($mainstg)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Main Stage</span></div>
                        <ul>";
    if (is_array($mainstg) || is_object($mainstg)) {
        foreach ($mainstg as $row) {
            echo implode("', '", $row);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;

if (!empty($dancestg)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Dance Stage</span></div>
                        <ul>";
    if (is_array($dancestg) || is_object($dancestg)) {
        foreach ($dancestg as $row) {
            echo implode("', '", $row);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;

if (!empty($qweensstg)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Qweens</span></div>
                        <ul>";
    if (is_array($qweensstg) || is_object($qweensstg)) {
        foreach ($qweensstg as $row) {
            echo implode("', '", $row);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;

if (!empty($villagestg)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Village</span></div>
                        <ul>";
    if (is_array($villagestg) || is_object($villagestg)) {
        foreach ($villagestg as $row) {
            echo implode("', '", $row);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;?>

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
                        <div class="tab-pane fade" id="pills-monday" role="tabpanel" aria-labelledby="pills-monday-tab">

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
                                <div class="events day-3">
                                    <?php
$output3 = $pdo->query($schedule3);
if (!$output3) {
    echo $pdo->error;
}
while ($row3 = $output3->fetch()) {
    $artistName3 = $row3["act_name"];
    $locale3 = $row3["locale"];
    $stage3 = $row3['stage'];
    $starttime3 = $row3["timeslot"];
    $day3 = $row3['perfday'];
    $stime3 = date("H:i", strtotime($starttime3));
    $etime3 = date("H:i", strtotime($starttime3) + 3600);
    $actype3 = strtolower($row3["atype"]);

    switch ($stage3) {
        case 1:
            $mainstg3[] = array("<li class='single-event' data-start='$stime3' data-end='$etime3' data-content='event-$actype3' data-event='event-1'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName3</em>
                                        </a>
                                    </li>");
            break;
        case 2:
            $dancestg3[] = array("<li class='single-event' data-start='$stime3' data-end='$etime3' data-content='event-$actype3' data-event='event-2'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName3</em>
                                        </a>
                                    </li>");
            break;
        case 3:
            $qweensstg3[] = array("<li class='single-event' data-start='$stime3' data-end='$etime3' data-content='event-$actype3' data-event='event-3'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName3</em>
                                        </a>
                                    </li>");
            break;
        case 4:
            $villagestg3[] = array("
                                        <li class='single-event' data-start='$stime3' data-end='$etime3' data-content='event-$actype3' data-event='event-4'>
                                        <a href='#'>
                                            <em class='event-name'>$artistName3</em>
                                        </a>
                                        </li>");
            break;
    }
}

?>
                                    <ul class="wrap">
                                        <?php
if (!empty($mainstg3)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Main Stage</span></div>
                        <ul>";
    if (is_array($mainstg3) || is_object($mainstg3)) {
        foreach ($mainstg3 as $row3) {
            echo implode("', '", $row3);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;

if (!empty($dancestg3)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Dance Stage</span></div>
                        <ul>";
    if (is_array($dancestg3) || is_object($dancestg3)) {
        foreach ($dancestg3 as $row3) {
            echo implode("', '", $row3);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;

if (!empty($qweensstg3)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Qweens</span></div>
                        <ul>";
    if (is_array($qweensstg3) || is_object($qweensstg3)) {
        foreach ($qweensstg3 as $row3) {
            echo implode("', '", $row3);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;

if (!empty($villagestg3)) {
    echo "<li class='events-group'>
                        <div class='top-info'><span>Village</span></div>
                        <ul>";
    if (is_array($villagestg3) || is_object($villagestg3)) {
        foreach ($villagestg3 as $row3) {
            echo implode("', '", $row3);
        }
    }
    ;
    echo "</ul>
                        </li>";
}
;?>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
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
    <script src="../js/menu-toggle.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/sched.js"></script>
</body>

</html>