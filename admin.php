<?php
/**
 * Created by Chris on 10/6/2014 6:47 PM.
 */

require_once 'core/init.php';

$user = new User();

if(!$user->hasPermission('admin')) {
    Redirect::to(404);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>

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
                    <h1>Admin Panel</h1>
                    <p>Shhh, this is super duper secret.</p>
                </div>
            </div>

            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">News</h3>
                    </div>
                    <div class="panel-body">
                        <form id="news" name="news" action="" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <label class="control-label" for="news-body">Title</label><br>
                                    <input class="form-control" id="news-title" name="news-title" placeholder="Title">
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="news-body">Body</label>
                                    <textarea id="news-body" name="news-body"></textarea>
                                </div>

                                <input class="btn btn-material-lightblue" style="float: left;" type="submit" value="Submit">
                                <a href="admin/news.php" class="btn btn-primary">Manage News</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Website Statistics</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="badge"><?php echo escape($user->countUserTable('users')); ?></span>
                                <b>Registered Users</b>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Newest Users</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Joined</th>
                            </thead>

                        <?php
                        foreach($user->getUserInfo('joined DESC', 10) as $users) {
                        ?>

                            <tbody>
                                <tr>
                                    <td><?php echo escape($users->id); ?></td>
                                    <td><?php echo escape($users->name); ?></td>
                                    <td><a href="profile.php?user=<?php echo escape($users->username); ?>"><?php echo escape($users->username); ?></a></td>
                                    <td><?php echo escape($users->email); ?></td>
                                    <td><?php echo escape(date('m/j/Y, g:i A',strtotime($users->joined))); ?></td>
                                </tr>
                            </tbody>

                        <?php
                        }
                        ?>

                        </table>

                        <a href="admin/members.php" class="btn btn-primary">View All Members</a>
                    </div>
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
<script src="js/snackbar.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script>
<script src="//cdn.ckeditor.com/4.4.5/standard/ckeditor.js"></script>

<script type="text/javascript">
    CKEDITOR.replace( 'news-body',
        {
            toolbar : 'Basic' /* this does the magic */
        });
</script>

</html>