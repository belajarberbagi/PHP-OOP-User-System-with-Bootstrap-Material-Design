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
        width: 305px;
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
        }
    });
</script>

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a href="index.php" class="navbar-brand">Site Demo</a>
        </div>
        <?php
            if($user->isLoggedIn()) {
        ?>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li id="index"><a href="index.php">Dashboard</a></li>
                <li id="profile"><a href="profile.php?user=<?php echo escape($user->data()->username); ?>">Profile</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
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
                                    <div class="col-lg-4">
                                        <p class="text-center">
                                            <span class="glyphicon glyphicon-user icon-size"></span>
                                        </p>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="text-left"><strong><?php echo escape($user->data()->name); ?></strong></p>
                                        <p class="text-left small"><?php echo escape($user->data()->email); ?></p>
                                        <p class="text-left">
                                            <button class="btn btn-primary btn-block btn-sm" onclick="location.href='update.php'">Update Profile</button>
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
                                            <button class="btn btn-danger btn-block" onclick="location.href='logout.php'">Log out</button>
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
                } else {
            ?>

            <div class="collapse navbar-collapse">
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
    body { padding-top: 70px; }
</style>