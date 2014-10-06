<?php
/**
 * Created by Chris on 9/29/2014 3:42 PM.
 */

require_once 'core/init.php';


if(Session::exists('home')) {
    echo '<div class="bs-component" style="padding: "><div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' . Session::flash('home'). '</div></div>';
}

$user = new User(); //Current

/*
 * if($user->isLoggedIn()) {
?>

    <p>Hello, <a href="profile.php?user=<?php echo escape($user->data()->username);?>"><?php echo escape($user->data()->username); ?></p>

    <ul>
        <li><a href="update.php">Update Profile</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
        <li><a href="logout.php">Log out</a></li>
    </ul>
<?php

    if($user->hasPermission('admin')) {
        echo '<p>You are a Administrator!</p>';
    }

} else {
    Redirect::to('login.php');
}
*/
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OOP Login/Register</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/material.css" rel="stylesheet">
    <link href="css/ripples.css" rel="stylesheet">
    <link href="css/material-wfont.min.css" rel="stylesheet">
    <link href="css/icons-material-design.css" rel="stylesheet">
    <link href="//fezvrasta.github.io/snackbarjs/dist/snackbar.min.css" rel="stylesheet">

    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>

    <?php require_once 'header.php'; ?>
</head>

<body>

    <div class="container">
        <div class="row">
            <?php
            if($user->isLoggedIn()) {
            ?>
                <div class="jumbotron">
                    <div class="container">
                        <h1>What's up <?php echo escape($user->data()->username); ?>!</h1>
                        <p>This is a PHP OOP Member System with Bootstrap Material Design.</p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

<?php require_once 'footer.php'; ?>

</body>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="js/ripples.js"></script>
    <script src="js/material.js"></script>
    <script src="//fezvrasta.github.io/snackbarjs/dist/snackbar.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script>

</html>