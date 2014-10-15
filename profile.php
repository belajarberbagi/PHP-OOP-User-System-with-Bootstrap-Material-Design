<?php
/**
 * Created by Chris on 9/29/2014 3:52 PM.
 */

require_once 'core/init.php';

if(!$username = Input::get('user')) {
    Redirect::to('index.php');
} else {
    $user = new User($username);

    if(!$user->exists()) {
        Redirect::to(404);
    } else {
        $data = $user->data();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OOP Login/Register</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/material.css" rel="stylesheet">
    <link href="css/ripples.css" rel="stylesheet">
    <link href="css/material-wfont.min.css" rel="stylesheet">
    <link href="css/icons-material-design.css" rel="stylesheet">
    <link href="css/snackbar.css" rel="stylesheet">

    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>

    <?php require_once 'header.php'; ?>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #ffffff;">
                    <h3 class="panel-title"><?php echo escape($data->username); ?></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3" align="center"> <img alt="Profile Picture" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=100" class="img-circle"> </div>

                        <br class="visible-sm visible-xs">

                        <div class="col-md-9 col-lg-9">
                            <table class="table table-user-information">
                                <tbody>
                                <tr>
                                    <td><b>Full Name:</b></td>
                                    <td><?php echo escape($data->name); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Join Date:</b></td>
                                    <td><?php echo escape(date('m/j/Y', strtotime($data->joined))); ?></td>
                                </tr>
                                <tr>
                                    <td><b>Group</b></td>
                                    <td><?php echo escape($data->group); ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php
                if(Input::get('user') === $user->data()->username) {
                    ?>
                    <div class="panel-footer">
                        <a href="update.php" class="btn btn-primary">Edit Profile</a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>

</body>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="js/ripples.js"></script>
<script src="js/material.js"></script>
<script src="js/snackbar.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script>

</html>