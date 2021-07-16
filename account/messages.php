<?php
session_start();
include("../db/conn.php");
require( "../db/account.php");
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

$table = $db;
$read = 'SELECT msg_id, status, wqf_status.status_name, owner, wqf_users.username AS rec, sender, wqf_users.username AS sen , img, subject, body, wqf_messages.created_date, isDeleted
FROM wqf_messages
INNER JOIN wqf_status ON status = wqf_status.status_id
INNER JOIN wqf_users ON owner = wqf_users.user_id AND sender = wqf_users.user_id WHERE isDeleted = 0 AND wqf_messages.owner = '.$uid.'';
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
            <h1 class="title is-1">Messages</h1>
            <h2 class="subtitle">
            She done already done had herses!
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

                    <li class="is-active">
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
  <button class='delete'></button>".$_SESSION['success_message']."</div>";unset($_SESSION['success_message']);
                    }
                    ?>
            <?php

while ($row = $result->fetch()) {
    $msg_id = $row["msg_id"];
    $stat= $row["status"];
    $status= $row["status_name"];
    $user = $row["owner"];
    $sender = $row["sender"];
    $sender = $row["sen"];
    $img = $row["img"];
    $sentdate = date("d/m/Y H:i", strtotime($row["created_date"]));
    $subject = $row["subject"];
    $User[] = array('msg_id' => $msg_id, 'status' => $status, 'sender' => $sender, 'subject' => $subject, 'sent' => $sentdate, 'edit' => '<a href=\'messenger.php?msg='.$msg_id.'\'class=\'button is-small\' disabled>
                                    <span class=\'icon\'>
                                    <i class=\'fas fa-envelope\'></i>
                                    </span>
                                    </a>');

}
?>


            <?php
            if(!empty($User)){

echo "</tbody>
                </table>
                                <table class='table is-hoverable is-striped'>
                    <thead>
                        <tr>

                            <th class='is-narrow'>ID</th>
                            <th class='is-narrow'>Status</th>
                            <th class='is-narrow'>From</th>
                            <th>Subject</th>
                            <th>Sent<th>
                            <th class='is-narrow'></th>
                        </tr>
                    </thead>
                    <tbody>";
    
            if (is_array($User) || is_object($User)) {
                foreach ($User as $row) {
                    echo "<tr>";
                    foreach ($row as $x => $value) {
                        echo "<td>" . $value . "</td>";
                    }
                    echo "</tr>";
                }         
            }};

            echo "</tbody></table>";
?> </div>
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
});</script>
    <script src="../js/menu-toggle.js"></script>
    <script src="../js/jquery.countdown.js"></script>
    <script src="../js/main.js"></script>
    <script src="../validation.js"></script>
</body>

</html>