<?php
/**
 * Created by Chris on 9/29/2014 3:42 PM.
 */

require_once 'core/init.php';

$user = new User(); //Current

if(!$user->isLoggedIn()) {
    Redirect::to('login.php');
}
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
    <link href="css/snackbar.css" rel="stylesheet">

    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>

    <?php require_once 'header.php'; ?>

</head>

<body>

<div class="container">
    <div class="row">

        <?php
        if($user->isLoggedIn()) {

            //Alert Boxes
            if(Session::exists('success')) {
                echo '<div class="bs-component" style="padding: "><div class="alert alert-dismissable alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>' . Session::flash('success'). '</div></div>';
            } else {
                if (Session::exists('error')) {
                    echo '<div class="bs-component" style="padding: "><div class="alert alert-dismissable alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>' . Session::flash('error') . '</div></div>';
                } else {
                    if (Session::exists('info')) {
                        echo '<div class="bs-component" style="padding: "><div class="alert alert-dismissable alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>' . Session::flash('info') . '</div></div>';
                    }
                }
            }
            ?>

            <div class="jumbotron">
                <div class="container">
                    <h1>What's up <?php echo escape($user->data()->username); ?>!</h1>
                    <p>This is a PHP OOP Member System with Bootstrap Material Design.</p>
                </div>
            </div>

            <div class="col-md-8 panel panel-default">
                <div class="panel-body">
                    <div class="panel-header">
                        <h1>News</h1>
                    </div>
                    <hr>

                    <?php
                        foreach($user->getTable('news', array('title', 'author', 'body', 'date'), 'date DESC', 4) as $news) { //Output Last 4 News
                    ?>

                    <h3><?php echo escape($news->title); ?> <small>by <?php echo escape($news->author); ?></small></h3>

                    <div class="panel panel-default">
                        <div class="panel-body">

                                <?php echo html_entity_decode($news->body); ?>

                        <hr>
                        <h5 class="pull-right"><small>Posted on <?php echo escape(date('m/j/Y \a\t g:i A',strtotime($news->date))); ?></small></h5>
                        </div>
                    </div>
                    <br>

                    <?php
                        }
                    ?>

                </div>
            </div>

        <?php
        }
        ?>

    </div>
</div>

<?php require_once 'footer.php'; ?>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="js/ripples.js"></script>
<script src="js/material.js"></script>
<script src="js/snackbar.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script>

    <?php

    if(Session::exists('welcome_back')) {

    ?>

        <script>
            $(document).ready(function () {
                $.snackbar({
                    content: "Welcome back <b><?php echo escape($user->data()->username); ?>!</b>",
                    style: "snackbox",
                    timeout: 3000
                });
            });

        </script>

    <?php
        Session::delete('welcome_back');
    }
    ?>

</body>

</html>