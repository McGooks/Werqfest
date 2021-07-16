<?php
session_start();
require("../db/account.php");
$usertype = $_SESSION['useraccount'];
$username = $_SESSION['username'];
$uid = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    header("location: http://gmcgookin01.lampt.eeecs.qub.ac.uk/Werqfest/");
}


if(isset($_POST['actname'])){
    $path_parts = pathinfo($_FILES['uploadfile']['name']);
    $upload = $uid.'_'.time().'.'.$path_parts['extension'];
    $location = $_FILES['uploadfile']['tmp_name'];
    $move = move_uploaded_file($location,"../users/images/$upload");  
    $account = new Account();
    include("../db/conn.php");
    try{
    $newartistprofile = $account->CreateArtistProfile($uid, $_POST['actname'], $upload, $_POST['webaddress'], $_POST['shortbio'], $_POST['longbio'], $uid);
    $updateexsiting = $account->UpdateUserToArtist($uid, 3, 1);
    } catch (Exception $e){
    echo $e->getMessage();
	die();
    }
    header("location: artistcomplete.php");
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="../ckeditor/ckeditor.js"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/octoshrimpy/bulma-o-steps/master/bulma-steps.css">
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
                            <a href="index.php" class="navbar-item is-active">
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
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column is-half">
                    <h1 class="title is-1">Apply</h1>
                    <h2 class="subtitle">
                        The time has come for you to lipsync for your <strong>life!</strong>
                    </h2>
                    <ul class="steps has-content-centered">
                        <li class="steps-segment is-active">
                            <span class="steps-marker"></span>
                            <div class="steps-content">
                                <p class="is-size-4">Step 1</p>
                            </div>
                        </li>
                        <li class="steps-segment">
                            <span class="steps-marker"></span>
                            <div class="steps-content">
                                <p class="is-size-4">Step 2</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <form method='POST' action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>' enctype='multipart/form-data'>

                <hr>
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                            Act Name:
                            <p class="control is-expanded has-icons-left">
                                <input class="input" type="text" placeholder="Act Name" value='' name='actname'
                                    is-active>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-crown"></i>
                                </span>
                            </p>
                        </div>
                        <div class="field">
                            Upload Profile Image:
                            <div class="file">
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
                        </div>
                    </div>
                </div>
                <div class="field">
                    Your Website Address (Full Address inc. http):
                    <p class="control is-expanded has-icons-left has-icons-right">
                        <input class="input" type="text" placeholder="Web Address" value='' name='webaddress' pattern="https?://.+">
                        <span class="icon is-small is-left">
                            <i class="fas fa-globe-europe"></i>
                        </span>
                    </p>
                </div>
                <hr>
                <h3 class="subtitle">Your Story</h3>
                <hr>
                <div class="field">
                    Short Bio (200 Max):
                    <p class="control is-expanded">
                        <textarea class="textarea" name='shortbio' rows='10' maxlength='200'></textarea>
                        <script>
                        CKEDITOR.replace('shortbio');
                        </script>
                    </p>
                </div>
                <div class="field">
                    Long Bio (5000 Max):
                    <p class="control is-expanded">
                        <textarea class="textarea" rows='15' name='longbio' maxlength='5000'></textarea>
                        <script>
                        CKEDITOR.replace('longbio');
                        </script>
                    </p>
                </div>


                <div class="field is-grouped is-grouped-right">
                    <div>
                        <label class="checkbox">
                            <input id="check" name="checkbox" type="checkbox">
                            I agree to the <a href="#">terms and conditions</a>
                        </label>
                    </div>
                </div>
                <div class="field is-grouped is-grouped-right">
                <div class="field">
                        <p class="control">
                            <button type='submit' value='addartist' class="button is-success" id="btncheck">
                                Create Account
                            </button>
                        </p>
                    </div>
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
    <script src="../js/main.js"></script>
</body>

</html>