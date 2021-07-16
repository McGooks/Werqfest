<?php
session_start();
include("../db/conn.php");
require("../db/account.php");
include("../db/signup.php");

$towns = $t;
$gender = $g;

$cid = $_SESSION['user_id'];
$user = $_SESSION['username'];
if(!isset($cid)){
    echo "user not allowed";
    /* header("location: signup.php"); */
}


$townresult = $pdo->query($towns);
if (!$townresult) {
   echo $pdo->error;
}

$genderresult = $pdo->query($gender);
if (!$genderresult) {
   echo $pdo->error;
}

if(isset($_POST['fname'])){
    $orgDate = $_POST['dob'];
    $newDate = date("Y-m-d", strtotime($orgDate));  
    $account = new Account();
    try{
    $login = $account->CreateUserProfile($_POST['fname'], $_POST['lname'], $_POST['gender'], $newDate , $cid, $_POST['address'], $_POST['town'],$_POST['postcode'],$cid);
    } catch (Exception $e){
    echo $e->getMessage();
    die();
    }
    $_SESSION['fname'] = $_POST['fname'];
    header("location: complete.php");
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
                            <a href="../index.php" class="navbar-item">
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
                            <a href="login.php" class="navbar-item is-active">
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
                    <h1 class="title is-1">Complete Your Profile</h1>
                    <h2 class="subtitle">
                        Ok <strong><?php echo $user ?></strong>, Let's SLAY this sign up form!
                    </h2>
                    <ul class="steps has-content-centered">
                        <li class="steps-segment">
                            <span class="steps-marker"></span>
                            <div class="steps-content">
                                <p class="is-size-4">Step 1</p>
                            </div>
                        </li>
                        <li class="steps-segment is-active">
                            <span class="steps-marker"></span>
                            <div class="steps-content">
                                <p class="is-size-4">Step 2</p>
                            </div>
                        </li>
                        <li class="steps-segment ">
                            <span class="steps-marker"></span>
                            <div class="steps-content">
                                <p class="is-size-4">Step 3</p>
                            </div>
                        </li>
                    </ul>
                    <form method='POST' action='createaccount.php' enctype='multipart/form-data'>
                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    First Name:
                                    <p class="control is-expanded has-icons-left">
                                        <input class="input" type="text" placeholder="First Name" value='' name='fname'
                                            required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </p>
                                </div>
                                <div class="field">
                                    Last Name:
                                    <p class="control is-expanded has-icons-left">
                                        <input class="input" type="text" placeholder="Last Name" value='' name='lname'
                                            required>
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
                                <input class="input" type="text" placeholder="Address" value='' name='address' required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-home"></i>
                                </span>
                            </p>
                        </div>
                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    Town:
                                    <p class="control has-icons-left">
                                        <span class="select">
                                            <select name='town' required>
                                                <option selected>Select a town</option>
                                                <?php while ($row = $townresult->fetch()){ 
					                                $town=$row['name'];
					                                $areaid=$row['geo_id'];
					                                echo "
					                            <option value='$areaid'>$town</option>
                                                    ";}
                                                ?>
                                            </select>
                                        </span>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-home"></i>
                                        </span>
                                    </p>
                                </div>
                                <div class="field">
                                    Postcode:
                                    <p class="control is-expanded has-icons-left">
                                        <input class="input" type="text" placeholder="Postcode" value='' name='postcode'
                                            required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-home"></i>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    Date of Birth:
                                    <div>
                                        <input id="datepicker" width="276" name='dob' required>
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
                                <div class="field">
                                    Gender:
                                    <p class="control has-icons-left">
                                        <span class="select">
                                            <select name='gender' required>
                                                <option selected>Select</option>
                                                <?php while ($row = $genderresult->fetch()){ 
					                                $gen=$row['gender'];
					                                $genid=$row['gen_id'];
					                                echo "
					                            <option value='$genid'>$gen</option>
                                                    ";}
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
                        <label class="checkbox">
                            <input id="check" name="checkbox" type="checkbox">
                            I agree to the <a href="#">terms and conditions</a>
                        </label>
                        <div class="field">
                            <p class="control">
                                <button type='submit' value='login' class="button is-success" id="btncheck">
                                    Create Account
                                </button>
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
    <script src="../js/main.js"></script>
</body>

</html>