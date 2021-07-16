<?php
session_start();
include("../db/conn.php");
require("../db/account.php");
require("../db/myaccount.php");

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

if (isset($_POST['actname'])) {
    $artist_id = $_POST['artistid'];
    $account = new Account();
    $checkbox = $_POST['requirement'];
    try {
        $input = $account->UpdateArtistProfile($_POST['artistid'], $_POST['actname'], $_POST['webaddress'], $_POST['shortbio'], $_POST['longbio'], $uid);
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
        header("location: artist.php");
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
        echo "Dead";
    }
}

$read = "SELECT artist_id, userid, wqf_status.status_name, act_name, wqf_stage.stage_name, wqf_timeslots.timeslot, artimage, wqf_act.act_type, web, bio_short, bio_long, is_confirmed, wqf_artist.is_active, last_edited_by
FROM wqf_artist
INNER JOIN wqf_status ON wqf_artist.astatus = wqf_status.status_id
INNER JOIN wqf_stage ON stage = wqf_stage.stage_id
INNER JOIN wqf_timeslots ON wqf_artist.timeslot = wqf_timeslots.time_id
INNER JOIN wqf_act ON wqf_artist.act_type = wqf_act.act_id
WHERE userid = $uid";
$result = $pdo->query($read);
if (!$result) {
    echo $pdo->error;
}

if ($usertype > 3) {
    header("location: index.php");
}

$eqtypes = $eq;
$eqresults = $pdo->query($eqtypes);
if (!$eqresults) {
    echo $pdo->error;
}


while ($row = $result->fetch()) {
    $artist_id = $row["artist_id"];
    $acc_id = $row["userid"];
    $status = $row["status_name"];
    $actname = $row["act_name"];
    $stage = $row["stage_name"];
    $day = date("l", strtotime($row["timeslot"]));
    $date = date("d/m/Y", strtotime($row["timeslot"]));
    $time = date("g:i A", strtotime($row["timeslot"]));
    $img = $row["artimage"];
    $act = $row["act_type"];
    $url = $row["web"];
    $bioshort = $row["bio_short"];
    $biolong = $row["bio_long"];
    $isConfirmed = $row["is_confirmed"];
    $isAct = $row["is_active"];
    $edited = $row["last_edited_by"];
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
                Hi <strong> <?php echo $actname ?></strong>,
                let's get to WERQ!!
            </h2>
            <div class="tabs is-centered is-boxed is-medium">
                <ul>
                    <li>
                        <a href="index.php">
                            <span class="icon is-small"><i class="fas fa-user" aria-hidden="true"></i></span>
                            <span>My User Details</span>
                        </a>
                    </li>
                    <li class="is-active">
                        <?php if ($usertype == 3) {
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
                        <a href="messages.php">
                            <span class="icon is-small"><i class="fas fa-envelope" aria-hidden="true"></i></span>
                            <span>Messages</span>
                        </a>
                    </li>
                    <!--<li>
                    <a href='schedule.php'>
                        <span class='icon is-small'><i class='fas fa-calendar-day' aria-hidden='true'></i></span>
                        <span>My Schedule</span>
                    </a>
                </li>-->
                </ul>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
        <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { 
            echo "
            <div class='notification is-success is-light'>
  <button class='delete'></button>".$_SESSION['success_message']."</div>";unset($_SESSION['success_message']);
                    }
                    ?>
            <form method='POST' action='artist.php' enctype='multipart/form-data'>
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                            <figure class="media">
                                <p class="image is-128x128">
                                    <img class="is-rounded" src=<?php echo "../users/images/$img" ?>>
                                </p>
                            </figure>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="columns is-vcentered">
                    <div class="column is-8">

                        <h3 class="subtitle">About Your Act</h3>

                    </div>
                    <div class="column">
                        <div class="field is-narrow">
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="text" placeholder="Artist ID"
                                    value='<?php echo $artist_id ?>' name='artistid' hidden>
                            </p>
                        </div>
                        <div class="field is-narrow">
                            Application Status:
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="text" placeholder="Status" value='<?php echo $status ?>'
                                    name='status' readonly>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-info"></i>
                                </span>
                            </p>
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
                                    name='actname' is-active>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-crown"></i>
                                </span>
                            </p>
                        </div>
                        
                    <?php
                    if($status == "Confirmed"){
                    echo"
                        <div class='field'>
                            Act Type:
                            <p class='control is-expanded has-icons-left'>
                                <input class='input' type='text' placeholder='Act Type' value='$act' name='acttype' readonly>
                                <span class='icon is-small is-left'>
                                    <i class='fas fa-star'></i>
                                </span>
                            </p>
                        </div>";}
                        ?>
                    </div>
                </div>
                
<?php 

if($status == "Confirmed")

{echo"
                <div class='field is-horizontal'>
                    <div class='field-body'>
                        <div class='field'>
                            Performance Stage:
                            <p class='control is-expanded has-icons-left'>
                                <input class='input' type='text' placeholder='Stage' value='$stage'
                                    name='stage' readonly>
                                <span class='icon is-small is-left'>
                                    <i class='fas fa-map-marker-alt'></i>
                                </span>
                            </p>
                        </div>
                        <div class='field'>
                            Performance Day:
                            <p class='control is-expanded has-icons-left'>
                                <input class='input' type='text' placeholder='Day' value='$day' name='day'
                                    readonly>
                                <span class='icon is-small is-left'>
                                    <i class='fas fa-calendar-day'></i>
                                </span>
                            </p>
                        </div>
                        <div class='field'>
                            Performance Date:
                            <p class='control is-expanded has-icons-left'>
                                <input class='input' type='text' placeholder='Date' value='$date'
                                    name='date' readonly>
                                <span class='icon is-small is-left'>
                                    <i class='fas fa-calendar'></i>
                                </span>
                            </p>
                        </div>
                        <div class='field'>
                            Performance Time:
                            <p class='control is-expanded has-icons-left'>
                                <input class='input' type='text' placeholder='Time' value='$time'
                                    name='time' readonly>
                                <span class='icon is-small is-left'>
                                    <i class='fas fa-clock'></i>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>";

                            }?>


                <div class="field">
                    Your Website Address:
                    <p class="control is-expanded has-icons-left has-icons-right">
                        <input class="input" type="text" placeholder="Web Address" value='<?php echo $url ?>'
                            name='webaddress' pattern="https?://.+">
                        <span class="icon is-small is-left">
                            <i class="fas fa-globe-europe"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
<?php 

if($status == "Confirmed"){

echo"
                
            <p>Please select your performance requirements:</p>";


            

            $equipuser = $pdo->prepare("SELECT artistid, reqid FROM wqf_req_artist WHERE artistid = :artid");
            $equipuser->execute(array(":artid"=>$artist_id));
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
            }}
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
                <h3 class="subtitle">Your Story</h3>
                <hr>
                <div class="field">
                    Short Bio (200 Max):
                    <p class="control is-expanded">
                        <textarea class="textarea" name='shortbio' rows='10'
                            maxlength='200'><?php echo $bioshort ?></textarea>
                        <script>
                        CKEDITOR.replace('shortbio');
                        </script>
                    </p>
                </div>
                <div class="field">
                    Long Bio (5000 Max):
                    <p class="control is-expanded">
                        <textarea class="textarea" rows='15' name='longbio'
                            maxlength='5000'><?php echo $biolong ?></textarea>
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
                        <button type='submit' value='save' class="button is-success">
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
    <script>
    const textarea = document.querySelector("textarea");
    textarea.addEventListener("input", event => {
        const target = event.currentTarget;
        const maxLength = target.getAttribute("maxlength");
        const currentLength = target.value.length;

        if (currentLength >= maxLength) {
            return console.log("You have reached the maximum number of characters.");
        }

        console.log(`${maxLength - currentLength} chars left`);
    });
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
</body>

</html>