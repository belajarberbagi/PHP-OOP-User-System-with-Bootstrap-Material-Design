<?php
/**
 * Created by Chris on 10/5/2014 1:27 PM.
 */

require_once 'core/init.php';

$user = new User();
?>
<style>
    .navbar-login
    {
        width: 280px;
        padding: 10px;
        padding-bottom: 0px;
    }

    .navbar-login-session
    {
        padding: 10px;
        padding-bottom: 0px;
        padding-top: 0px;
    }

    .icon-size
    {
        font-size: 87px;
    }

    @media (max-width: 991px) {
        .navbar-header {
            float: none;
        }
        .navbar-left,.navbar-right {
            float: none !important;
        }
        .navbar-toggle {
            display: block;
        }
        .navbar-collapse {
            border-top: 1px solid transparent;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
        }
        .navbar-fixed-top {
            top: 0;
            border-width: 0 0 1px;
        }
        .navbar-collapse.collapse {
            display: none!important;
        }
        .navbar-nav {
            float: none!important;
            margin-top: 7.5px;
        }
        .navbar-nav>li {
            float: none;
        }
        .navbar-nav>li>a {
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .collapse.in{
            display:block !important;
        }
    }
</style>

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
</head>

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="<?php echo SITE_ROOT; ?>/index.php" class="navbar-brand">Site Demo</a>

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
                                            <button class="btn btn-primary btn-block btn-sm" onclick="location.href='<?php echo SITE_ROOT; ?>/update.php'">Edit Profile</button>
                                            <?php
                                            if($user->hasPermission('admin')) { //Show button for Admin Panel
                                            ?>

                                                <button class="btn btn-success btn-block btn-sm" onclick="location.href='<?php echo SITE_ROOT; ?>/admin.php'">Admin Panel</button>

                                            <?php
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="navbar-login navbar-login-session">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>
                                            <button class="btn btn-danger btn-block" onclick="location.href='<?php echo SITE_ROOT; ?>/logout.php'">Log out</button>
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
