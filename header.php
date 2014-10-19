<?php
/**
 * Created by Chris on 10/5/2014 1:27 PM.
 */

require_once 'core/init.php';

$user = new User();
?>

<script>
    $(document).ready(function() {
        $(document).on('click', '.dropdown-menu', function (e) {
            $(this).hasClass('keep_open') && e.stopPropagation();
        });
        $('.nav.navbar-nav > li').on('click', function(e) {
            $('.nav.navbar-nav > li').removeClass('active');
            $(this).addClass('active');
        });
    });

    function getPageName() {
        var url = document.location.href;

        url = url.substring(0, (url.indexOf("#") == -1) ? url.length : url.indexOf("#"));
        url = url.substring(0, (url.indexOf("?") == -1) ? url.length : url.indexOf("?"));
        url = url.substring(url.lastIndexOf("/") + 1, url.length);
            return url;
    }

    $(document).ready(function(){
        var currentPage = getPageName();

        switch(currentPage){
            case 'index.php':
                $('#index').addClass('active');
                break;
            case 'login.php':
                $('#login').addClass('active');
                break;
            case 'register.php':
                $('#register').addClass('active');
                break;
            case 'profile.php':
                $('#profile').addClass('active');
                break;
            case 'update.php':
                $('#update').addClass('active');
                break;
        }
    });
</script>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='css/style.css' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
</head>

<div class="navbar navbar-default navbar-material-googlegrey navbar-fixed-top" style="background-color: #404040; font-family: 'Roboto Condensed', sans-serif; font-size: 15px; font-weight: 400;" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="<?php echo SITE_ROOT; ?>/index.php" class="navbar-brand">Chris <strong>Tran</a></strong>

            <a class="navbar-toggle" data-toggle="collapse" data-target=".navbarCollapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
        </div>

        <?php
            if($user->isLoggedIn()) {
        ?>

        <div class="collapse navbar-collapse navbarCollapse">
            <ul class="nav navbar-nav">
                <li id="index"><a href="<?php echo SITE_ROOT; ?>/index.php">Dashboard</a></li>
                <li id="profile"><a href="<?php echo SITE_ROOT; ?>/profile.php?user=<?php echo escape($user->data()->username); ?>">Profile</a></li>
                <li class="visible-sm visible-xs" id="update"><a href="<?php echo SITE_ROOT; ?>/update.php">Edit Profile</a></li>
                <?php
                if($user->hasPermission('admin')) { //Show button for Admin Panel
                    ?>
                    <li class="visible-sm visible-xs" id="admin"><a href="<?php echo SITE_ROOT; ?>/admin.php">Admin Panel</a></li>
                <?php
                }
                ?>
                <li class="visible-sm visible-xs" id="logout"><a href="<?php echo SITE_ROOT; ?>/logout.php">Log out</a></li>
            </ul>


            <ul class="visible-lg visible-md nav navbar-nav navbar-right">
                <li class="dropdown keep_open">
                    <a href="#" class="dropdown-toggle keep_open" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span> 
                        <strong><?php echo escape($user->data()->username); ?></strong>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu keep_open">
                        <li>
                            <div class="navbar-login">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="text-center" style="font-size: 18px;"><strong><?php echo escape($user->data()->name); ?></strong></p>
                                        <p class="text-center" style="font-size: 12px;"><?php echo escape($user->data()->email); ?></p>
                                        <p class="text-center">
                                            <?php
                                            if($user->hasPermission('admin')) { //Show button for Admin Panel
                                            ?>

                                                <button class="btn btn-success btn-md" onclick="location.href='<?php echo SITE_ROOT; ?>/admin.php'">Admin Panel</button>

                                            <?php
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="navbar-login navbar-login-session">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="text-center">
                                                <button class="btn btn-primary btn-sm" onclick="location.href='<?php echo SITE_ROOT; ?>/update.php'">Edit Profile</button>
                                                <button class="btn btn-default btn-sm" onclick="location.href='<?php echo SITE_ROOT; ?>/logout.php'">Log out</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

            <?php
                } else { //Show this for users that aren't logged in
            ?>

            <div class="collapse navbar-collapse navbarCollapse">
                <ul class="nav navbar-nav">
                    <li id="login"><a href="login.php">Login</a></li>
                    <li id="register"><a href="register.php">Register</a></li>
                </ul>
            </div>

            <?php
                }
            ?>

    </div>
</div>

<style>
    body {
        padding-top: 70px;
        padding-bottom: 70px;
    }
</style>
