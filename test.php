<?php
/**
 * Created by Chris on 10/8/2014 11:20 PM.
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

<?php
//Bootstrap Alert Boxes
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
            <h1>News</h1>
            <p>You are in control of the news.</p>
        </div>
    </div>

    <div class="col-md-4">
        <?php
        //Admin Navigation
        require_once ROOT . '/admin/header.php';
        ?>
    </div>
    <?php
    if(Input::get('page')) { //View All News

    ?>

    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Newe</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date Created</th>
                        <th>Action</th>
                        </thead>

                        <?php

                        $pages = new Pagination(); //Pagination Initialization
                        $data = $user->getTable('news', array('id', 'title', 'author', 'date'), 'date DESC', 100);
                        $numbers = $pages->paginate($data, 10);
                        $result = $pages->fetchResult();;

                        foreach($result as $news) { //Output Last 10 Registered Users
                        ?>

                            <tbody>
                                <tr>
                                    <td><?php echo escape($news->id); ?></td>
                                    <td><?php echo escape($news->title); ?></td>
                                    <td><?php echo escape($news->author); ?></td>
                                    <td><?php echo escape(date('m/j/Y \a\t g:i A',strtotime($news->date))); ?></td>
                                    <td align="center"><a href="?id=<?php echo escape($news->id); ?>&edit=true" class="icon icon-material-settings icon-material-bluegrey" style="text-decoration: none;"></a>&nbsp;&nbsp;&nbsp;<a href="?id=<?php echo escape($news->id); ?>&delete=true" onclick="return confirm('Are you sure you want to delete this?');" class="icon icon-material-close icon-material-red" style="text-decoration: none;"></a></td>
                                </tr>
                            </tbody>

                        <?php
                        }
                        ?>
                    </table>

                    <div style="text-align:center">
                        <nav>
                            <ul class="pagination">
                                <li><a href="test.php?page=<?php if(Input::get('page') == 1) { echo Input::get('page'); } else { echo Input::get('page') - 1; } ?>">&laquo;</a></li>
                            <?php
                                foreach($numbers as $num) {
                            ?>

                                    <li class="<?php if(Input::get('page') == $num) { echo 'active'; } ?>"><a href="test.php?page=<?php echo $num; ?>"><?php echo $num; ?></a></li>

                            <?php
                                }
                            ?>
                                <li><a href="test.php?page=<?php echo Input::get('page') + 1; ?>">&raquo;</a></li>
                            </ul>
                        </nav>
                    </div>

                        <?php
                            if(count($data) < 1) {
                                echo '&nbsp;<b>Hmm, looks like there\'s no news.</b>';
                            }
                        ?>

                </div>
            </div>
        </div>
    </div>

<?php
} else { //Show News Panel
?>



</div>
</div>

<?php
}

require_once 'footer.php';
?>

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
            toolbar : 'Basic'
        });
</script>

</html>