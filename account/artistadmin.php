<?php
session_start();
include("../db/conn.php");
require("../db/account.php");
require("../db/myaccount.php");


if(isset($_GET['performer'])){
    $aid = $_GET['performer'];
} else {
    $aid = $_POST['userID'];
}

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

$statq = $s;
$statusresult = $pdo->query($statq);
if (!$statusresult) {
    echo $pdo->error;
}
$actq = $at;
$actresult = $pdo->query($actq);
if (!$actresult) {
    echo $pdo->error;
}
$perfq = $ps;
$perfresult = $pdo->query($perfq);
if (!$perfresult) {
    echo $pdo->error;
}
$timeq = $ti;
$timeresult = $pdo->query($timeq);
if (!$timeresult) {
    echo $pdo->error;
}
$eqtypes = $eq;
$eqresults = $pdo->query($eqtypes);
if (!$eqresults) {
    echo $pdo->error;
}


$table = $db;
$read = "SELECT artist_id, userid, wqf_artist.astatus AS artstat, wqf_status.status_name, act_name,  wqf_artist.stage, wqf_stage.stage_name, wqf_artist.timeslot AS tslot, wqf_timeslots.timeslot, artimage, wqf_artist.act_type AS acttypeid, wqf_act.act_type, web, bio_short, bio_long, is_confirmed, wqf_artist.is_active, last_edited_by
FROM wqf_artist
INNER JOIN wqf_status ON wqf_artist.astatus = wqf_status.status_id
INNER JOIN wqf_stage ON stage = wqf_stage.stage_id
INNER JOIN wqf_timeslots ON wqf_artist.timeslot = wqf_timeslots.time_id
INNER JOIN wqf_act ON wqf_artist.act_type = wqf_act.act_id
WHERE artist_id = '$aid'";
$result = $pdo->query($read);
if (!$result) {
    echo $pdo->error;
}

if ($usertype > 3) {
    header("location: index.php");
}


while ($row = $result->fetch()) {
    $artist_id = $row["artist_id"];
    $acc_id = $row["userid"];
    $status = $row["status_name"];
    $artstat = $row['artstat'];
    $actname = $row["act_name"];
    $stageidx = $row['stage'];
    $stage = $row["stage_name"];
    $tslotnum = $row['tslot'];
    $cal = $row['timeslot'];
    $day = date("l", strtotime($row["timeslot"]));
    $daysh = date("D", strtotime($row["timeslot"]));
    $date = date("d/m/Y", strtotime($row["timeslot"]));
    $time = date("g:i A", strtotime($row["timeslot"]));
    $img = $row["artimage"];
    $acttypeid = $row['acttypeid'];
    $act = $row["act_type"];
    $url = $row["web"];
    $bioshort = $row["bio_short"];
    $biolong = $row["bio_long"];
    $isConfirmed = $row["is_confirmed"];
    $isAct = $row["is_active"];
    $edited = $row["last_edited_by"];
}

if (isset($_POST['artist_id'])) {
    if($_POST['appstatus'] == 7){
        $conf = 1;
    } else {
        $conf = 0;
    }
    $artist_id = $_POST['artist_id'];
    $account = new Account();
    $checkbox = $_POST['requirement'];
    try {
        $input = $account->AdminUpdateArtistProfile($_POST['artist_id'], $_POST['appstatus'], $_POST['actname'], $_POST['acttype'], 
        $_POST['stage'], $_POST['time'], $_POST['webaddress'], $_POST['shortbio'], $_POST['longbio'], $conf , 1, $uid);
        $enquiry = $account->RequirementsCheck($artist_id);
        if($enquiry){
        $deletequery = "DELETE FROM wqf_req_artist WHERE wqf_req_artist.artistid = $artist_id";
        $pdo->query($deletequery);
        }
        for ($i=0; $i<sizeof ($checkbox);$i++) { 
        $query="INSERT INTO wqf_req_artist (artistid, reqid) VALUES ($artist_id,'" . $checkbox[$i] . "')";
        $pdo->query($query);
        }
        $_SESSION['success_message'] = "Submitted! Can I get an <strong>Amen</strong> up in here?";
        header("location: artistedit.php");
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
        echo "Dead";
    }
}

if (isset($_POST['updateimage'])) {
    $path_parts = pathinfo($_FILES['uploadfile']['name']);
    $upload = $aid.'_'.time().'.'.$path_parts['extension'];
    $location = $_FILES['uploadfile']['tmp_name'];
    $move = move_uploaded_file($location,"../users/images/$upload");
    $account = new Account();
    try {
        $newuserprofile = $account->AdminUpdateArtistProfileImage($aid, $upload , $uid);
        $_SESSION['success_message'] = "Submitted! Can I get an <strong>Amen</strong> up in here?";
        header("location: artistedit.php");
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
    <link rel="stylesheet" href="https://cdn.rawgit.com/octoshrimpy/bulma-o-steps/master/bulma-steps.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
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

    <section class="myaccount-main">
        <div class="container">
            <h1 class="title is-1">My Account</h1>
            <h2 class="subtitle">
                Miss <strong> <?php echo $actname ?></strong>,
                is thankful for your edits!!
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
                    <li class="is-active">
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
    echo "<li>
                    <a href='editschedule.php'>
                        <span class='icon is-small'><i class='fas fa-calendar-plus' aria-hidden='true'></i></span>
                        <span>Artist Schedule</span>
                    </a>
                </li>
					";
}
?>
                </ul>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <a href="artistedit.php" class="button">
                < Back</a>
                    <hr>
                    <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { 
            echo "
            <div class='notification is-success is-light'>
  <button class='delete'></button>".$_SESSION['success_message']."</div>";unset($_SESSION['success_message']);
                    }
                    ?>
                    <form method='POST' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
                        enctype='multipart/form-data' validate>
                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    <figure class="media">
                                        <p class="image is-128x128">
                                            <img class="is-rounded" src=<?php echo "../users/images/$img" ?>>
                                        </p>
                                    </figure>
                                    <div class="field">
                                        Upload Artist Image:
                                        <div class="file has-name">
                                            <label class="file-label">
                                                <input class="file-input" type="file" name="uploadfile">
                                                <span class="file-cta">
                                                    <span class="file-icon">
                                                        <i class="fas fa-upload"></i>
                                                    </span>
                                                    <span class="file-label">
                                                        Choose a file…
                                                    </span>
                                                </span>
                                                <span class="file-name"><?php echo $img ?>
                                                </span>
                                            </label>
                                        </div>
                                        <div class="field">
                                            <p class="control">
                                                <button type='submit' name="updateimage" value="updateimage" class="button is-success">
                                                    Save Profile Picture
                                                </button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="field is-narrow">
                                <p class="control is-expanded has-icons-left">
                                    <input class="input" type="text" placeholder="User ID"
                                        value='<?php echo $acc_id ?>' name='userID' hidden>
                                    </span>
                                </p>
                            </div>
                            </div>
                    </form>
        </div>
        <hr>
        <div class="columns is-vcentered">
            <div class="column is-6">

                <h3 class="subtitle">Artist: <strong><?php echo $actname ?> </strong></h3>

            </div>
            <form method='POST' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" enctype='multipart/form-data'
                validate>
                <div class="column">
                    <div class="field is-horizontal">
                        <div class="field-body">
                            <div class="field is-narrow">
                                Artist ID:
                                <p class="control is-expanded has-icons-left">
                                    <input class="input" type="text" placeholder="Artist ID"
                                        value='<?php echo $artist_id ?>' name='artist_id' readonly>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-info"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="field is-narrow">
                                User ID:
                                <p class="control is-expanded has-icons-left">
                                    <input class="input" type="text" placeholder="User ID"
                                        value='<?php echo $acc_id ?>' name='userID' readonly>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-info"></i>
                                    </span>
                                </p>
                            </div>
                            <div class="field is-narrow">
                                Application Status:
                                <p class="control has-icons-left">
                                    <span class="select">
                                        <select name='appstatus' required>
                                            <?php 
                                                        echo "<option selected value='$artstat'>$status</option>";
                                                        while ($row = $statusresult->fetch()) {
                                                            $statid = $row['status_id'];
                                                            $statusn = $row['status_name'];
                                                            if($artstat != $statid){
                                                            echo "
					                                        <option value='$statid'>$statusn</option>
                                                    ";}}
                                                        ?>
                                        </select>
                                    </span>
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
        </div>
        <hr>

        <div class="field is-horizontal">
            <div class="field-body">
                <div class="field">
                    Act Name:
                    <p class="control is-expanded has-icons-left">
                        <input class="input" type="text" placeholder="Act Name" value='<?php echo $actname ?>'
                            name='actname' is-active required>
                        <span class="icon is-small is-left">
                            <i class="fas fa-crown"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    Act Type:
                    <p class="control is-expanded has-icons-left">
                        <span class="select">
                            <select name='acttype' required>
                                <?php 
                                                echo "<option selected value='$acttypeid'>$act</option>";
                                                
                                                while ($row = $actresult->fetch()) {
                                                        $actid = $row['act_id'];
                                                        $acttype = $row['act_type'];

                                                        if($acttypeid != $actid){
                                                        echo "
					                            <option value='$actid'>$acttype</option>
                                                    ";}}
?>
                            </select>
                        </span>
                        <span class="icon is-small is-left">
                            <i class="fas fa-star"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-body">
                <div class="field is-narrow">
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
                <div class="field is-narrow">
                    Performance Day:
                    <p class="control is-expanded has-icons-left">
                        <input class="input" type="text" placeholder="Day" value='<?php echo $day ?>' name='day'
                            readonly>
                        <span class="icon is-small is-left">
                            <i class="fas fa-calendar-day"></i>
                        </span>
                    </p>
                </div>

                <div class="field is-narrow">
                    Performance Time:
                    <p class="control is-expanded has-icons-left">
                        <span class="select">
                            <select name='time' required>
                                <?php

                                                echo "<option selected value='$tslotnum'>$daysh $time</option>";
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
                <div class="field">
                    Artist Website Address:
                    <p class="control is-expanded has-icons-left has-icons-right">
                        <input class="input" type="url" placeholder="Web Address" value='<?php echo $url ?>'
                            name='webaddress' pattern="https?://.+">
                        <span class="icon is-small is-left">
                            <i class="fas fa-globe-europe"></i>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="field">
            <p>Please select your performance requirements:</p>


            <?php 

            $equipuser = $pdo->prepare("SELECT artistid, reqid FROM wqf_req_artist WHERE artistid = :artid");
            $equipuser->execute(array(":artid"=>$aid));
            $equipresult=$equipuser->fetchAll(PDO::FETCH_ASSOC);
            foreach ($eqresults as $row2) {
            ?>
            
            <label class='checkbox'>
            <input type="checkbox" name="requirement[]" value="<?php echo $row2['req_id']?>" 
            <?php 
            $r = $row2['req_id'];
            $row2['req_id'];
            $check = searchForId($r, $equipresult);
            echo $check;?> >

            <?php 
                echo $row2['requirement']; 
                echo ' ';?>
            </label>
            <br>
            <?php
            }
            function searchForId($id, $array) {
                foreach ($array as $key => $val) {
                    if ($val['reqid'] === $id) {
                        return 'checked';
                    }
                }
                return null;
             }
            ?>


        </div>

        <hr>
        <h3 class="subtitle">A bit more about <strong> <?php echo $actname ?> </strong></h3>
        <hr>
        <div class="field">
            Short Bio (200 Max):
            <p class="control is-expanded">
                <textarea class="textarea" name='shortbio' maxlength='200'><?php echo $bioshort ?></textarea>
                <script>
                CKEDITOR.replace('shortbio');
                </script>
            </p>
        </div>
        <div class="field">
            Long Bio (5000 Max):
            <p class="control is-expanded">
                <textarea class="textarea" rows=15 name='longbio' maxlength='5000'><?php echo $biolong ?></textarea>
                <script>
                CKEDITOR.replace('longbio');
                </script>
            </p>
        </div>

        <div class="field is-grouped is-grouped-right">
            <p class="control">
                <button type='reset' value='' class="button is-light">
                    Cancel
                </button>
            </p>
            <p class="control">
                <button type='submit' name="updateprofile" value='updateprofile' class="button is-success">
                    Save
                </button>
            </p>
        </div>

        </form>

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
    <script src="../js/jquery.countdown.js"></script>
    <script src="../js/main.js"></script>
</body>

</html>