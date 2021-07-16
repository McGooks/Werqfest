<?php
session_start();
include "../db/conn.php";
require "../db/account.php";
require "../db/myaccount.php";

$usertype = $_SESSION['useraccount'];
$username = $_SESSION['username'];
$uid = $_SESSION['user_id'];
$gender = $g;
$table = $db;
$towns = $t;
$success = false;

$read = "SELECT account_id, fname, lname, wqf_account.gender AS gennum, wqf_gender.gender, dob , wqf_users.username, users_account, address, town, wqf_geo.name, postcode, tel, profile_img, isArtist, isValid, isActive
FROM wqf_account
INNER JOIN wqf_gender ON wqf_account.gender = wqf_gender.gen_id
INNER JOIN wqf_users ON wqf_account.users_account = wqf_users.user_id
INNER JOIN wqf_geo ON wqf_account.town = wqf_geo.geo_id
WHERE users_account = $uid";
$result = $pdo->query($read);
if (!$result) {
    echo $pdo->error;
}

while ($row = $result->fetch()) {
    $acc_id = $row["account_id"];
    $firstname = $row["fname"];
    $lastname = $row["lname"];
    $gendrid = $row['gennum'];
    $gendr = $row["gender"];
    $dob = date("d/m/Y", strtotime($row["dob"]));
    $uname = $row["username"];
    $ucid = $row["users_account"];
    $address = $row["address"];
    $townid = $row["town"];
    $townname = $row["name"];
    $postcode = $row["postcode"];
    $tel = $row["tel"];
    $img = $row["profile_img"];
    $isArt = $row["isArtist"];
    $isVal = $row["isValid"];
    $isAct = $row["isActive"];
}
$townresult = $pdo->query($towns);
if (!$townresult) {
    echo $pdo->error;
}

$genderresult = $pdo->query($gender);
if (!$genderresult) {
    echo $pdo->error;
}

if (!isset($_SESSION['user_id'])) {
    echo "user not allowed";
    header("location: http://gmcgookin01.lampt.eeecs.qub.ac.uk/Werqfest/");
}

if (isset($uid)) {
    $showlink = false;
    $account = new Account();
    $checkresult = $account->ArtistCheck($uid);
    $showlink = $checkresult;
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

if (isset($_POST['fname'])) {
    $orgDate = strtr($_POST['dob'], '/', '-');
    $newDate = date("Y-m-d", strtotime($orgDate));
    $account = new Account();
    try {
        $query = 'UPDATE gmcgookin01.wqf_account SET wqf_account.profile_img = :useimage, wqf_account.last_edited_by = :last_edited_by WHERE
            wqf_account.users_account = :useid';
        $input = $account->EditUserProfile($uid, $_POST['fname'], $_POST['lname'], $_POST['gender'], $newDate, $_POST['address'], $_POST['town'], $_POST['postcode'], $_POST['tel'], $uid, $_POST['username']);
        session_start();
        $_SESSION['success_message'] = "Submitted! Can I get an <strong>Amen</strong> up in here?";
        header("Location: index.php");
        exit();

    } catch (Exception $e) {
        echo $e->getMessage();
        die();
        echo "Dead";
    }
}

if (isset($_POST['userprofile'])) {
    $path_parts = pathinfo($_FILES['uploadfile']['name']);
    $upload = $uid.'_'.time().'.'.$path_parts['extension'];
    $location = $_FILES['uploadfile']['tmp_name'];
    $move = move_uploaded_file($location,"../users/images/$upload");
    $account = new Account();
    try {
        $newuserprofile = $account->EditUserProfilePhoto($_SESSION['user_id'], $upload ,$_SESSION['user_id']);
        $_SESSION['success_message'] = "Submitted! Can I get an <strong>Amen</strong> up in here?";
        header("Location: index.php");
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
                Hi <strong> <?php echo $firstname ?></strong>,
                let's get to WERQ!!
            </h2>
            <div class="tabs is-centered is-boxed is-medium">
                <ul>
                    <li class="is-active">
                        <a href="#">
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
                    </li>";
}
?>
                    <?php if ($usertype == 3) {
    echo "<li>
                    <a href='artist.php'>
                        <span class='icon is-small'><i class='fas fa-music' aria-hidden='true'></i></span>
                        <span>My Artist Details</span>
                    </a>
                </li>
					";
}
?>
                    <?php if ($usertype < 3) {
    echo "<li>
                    <a href='artistedit.php'>
                        <span class='icon is-small'><i class='fas fa-music' aria-hidden='true'></i></span>
                        <span>Artist Admin </span>
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

                    <?php if ($usertype > 2) {
/*     echo "<li>
<a href='schedule.php'>
<span class='icon is-small'><i class='fas fa-calendar-day' aria-hidden='true'></i></span>
<span>My Schedule</span>
</a>
</li>
"; */
}
?>
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

            <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) {
    echo "
            <div class='notification is-success is-light'>
  <button class='delete'></button>" . $_SESSION['success_message'] . "</div>";unset($_SESSION['success_message']);
}
?>
            <form method='POST' action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>'
                enctype='multipart/form-data' validate>
                <div class="field">
                    <figure class="media">
                        <p class="image is-128x128">
                            <img class="is-rounded" src=<?php echo "../users/images/$img"; ?>>
                        </p>
                    </figure>
                </div>
                <div class="field is-narrow">
                    Upload Profile Image:
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
                        </label>
                    </div>
                    <div class="field">
                        <p class="control">
                            <button type='submit' name="userprofile" value='updateimage' class="button is-success">
                            Save Profile Picture
                            </button>
                        </p>
                    </div>
                </div>
            </form>

            <form method='POST' action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>'
                enctype='multipart/form-data' validate>
                <hr>
                <h3 class="subtitle">The bit about you</h3>
                <hr>
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                            First Name:
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="text" placeholder="First Name"
                                    value='<?php echo $firstname ?>' name='fname' required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>

                            </p>
                        </div>
                        <div class="field">
                            Last Name:
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="text" placeholder="Last Name" value='<?php echo $lastname ?>'
                                    name='lname' required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="field">
                    Address:
                    <p class="control is-expanded has-icons-left has-icons-right">
                        <input class="input" type="text" placeholder="Address" value='<?php echo $address ?>'
                            name='address' required>
                        <span class="icon is-small is-left">
                            <i class="fas fa-home"></i>
                        </span>
                    </p>
                </div>
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field is-narrow">
                            Town:
                            <p class="control has-icons-left">
                                <span class="select">
                                    <select name='town' required>
                                        <?php
                                        echo "<option value='$townid' required>$townname</option>";
                                        while ($row = $townresult->fetch()) {
                                            $id = $row['geo_id'];
                                            $name = $row['name'];
                                            if ($townid != $id) {
                                                echo "<option value='$id'>$name </option>";
                                            }}
                                        ?>
                                    </select>
                                </span>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-home"></i>
                                </span>
                            </p>
                        </div>
                        <div class="field is-narrow">
                            Postcode:
                            <p class="control has-icons-left">
                                <input class="input" type="text" placeholder="Postcode" value='<?php echo $postcode ?>'
                                    name='postcode' required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-home"></i>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field is-narrow">
                            Date of Birth:
                            <div>
                                <input id="datepicker" width="276" name='dob' value='<?php echo $dob ?>' required>
                                <script>
                                $('#datepicker').datepicker({
                                    uiLibrary: 'bootstrap4',
                                    iconsLibrary: 'fontawesome',
                                    minDate: new Date(1920, 1 - 1, 1),
                                    maxDate: '-16Y',
                                    format: 'dd/mm/yyyy',
                                    defaultDate: new Date(2020, 6 - 1, 7),
                                    changeMonth: true,
                                    changeYear: true,
                                    yearRange: '-100:-16',
                                });
                                </script>
                            </div>
                        </div>
                        <div class="field is-narrow">
                            Gender:
                            <p class="control has-icons-left">
                                <span class="select">
                                    <select name='gender'>
                                        <?php
                                            echo "<option selected value='$gendrid'>$gendr</option>";
                                            while ($row = $genderresult->fetch()) {
                                                $id = $row['gen_id'];
                                                $name = $row['gender'];
                                                if ($gendrid != $id) {
                                                    echo "<option value='$id'>$name</option>";}}
                                            ?>
                                    </select>
                                </span>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </p>
                        </div>
                        <div class="field is-narrow">
                            Tel:
                            <p class="control has-icons-left">
                                <input class="input" type="tel" placeholder="Mobile Number" value='<?php echo $tel ?>'
                                    name='tel' required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-mobile"></i>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="field">
                    User Email:
                    <p class="control has-icons-left">
                        <input class="input" type="email" placeholder="Email Address" value='<?php echo $uname ?>'
                            name='username' required>
                        <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                        </span>
                    </p>
                </div>
                <div class="field is-grouped is-grouped-right">
                    <p class="control">
                        <button type='submit' id='submit' name="formdata" value='updateuser' class="button is-success">
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
                            <?php
                                if ($showlink) {
                                    echo "<div class='apply'>
                                <a href='artistapply.php'>
                                    <p>Apply here to perform on our stage</p>
                                </a>
                            </div>
                        ";}?>
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
    <script src="../js/main.js"></script>
</body>

</html>