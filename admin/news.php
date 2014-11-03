<?php
/**
 * Created by Chris on 9/29/2014 3:42 PM.
 */

require_once '../core/init.php';

$user = new User(); //Current

if(!$user->hasPermission('admin')) {
    Redirect::to(404);
}

//Submit News
if(Input::exists()) {
    $validate = new Validate();

    $validate->check($_POST, array(
        'news-title' => array(
            'field_name' => 'Title',
            'required' => true,
            'min' => 1,
            'max' => 255
        ),
        'news-body' => array(
            'field_name' => 'Body',
            'required' => true,
            'min' => 1
        )
    ));

    if($validate->passed()) {
        $admin = new Admin();

        try {
            $admin->insertNews(array(
                'title' => Input::get('news-title'),
                'body' => Input::get('news-body'),
                'author' => $user->data()->username,
                'date' => date('Y-m-d H:i:s')
            ));

            Session::flash('success', '<b>' . Input::get('news-title') . '</b> has been created.');
            Redirect::to('../admin/news.php?page=1');
        } catch (Exception $e) {
            echo $error, '<br>';
        }
    }
}

//Delete News
if(Input::get('delete')) {
    $admin = new Admin();

    $admin->deleteNews(Input::get('id'));

    Session::put('success', '<b>Successfully Deleted.</b>');
    Redirect::to('../admin/news.php?page=1');
}

//Submit edited news
if(Input::get('submit')) {
    $admin = new Admin();

    $admin->updateNews(array(
        'title' => Input::get('news-title'),
        'body' => Input::get('news-body')
    ), Input::get('id'));

    Session::put('success', '<b>Successfully Updated.</b>');
    Redirect::to('../admin/news.php?page=1');
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>OOP Login/Register</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/material.css" rel="stylesheet">
    <link href="../css/ripples.css" rel="stylesheet">
    <link href="../css/material-wfont.min.css" rel="stylesheet">
    <link href="../css/icons-material-design.css" rel="stylesheet">
    <link href="../css/snackbar.css" rel="stylesheet">

    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>

    <?php require_once '../header.php'; ?>

</head>

<body>

<script type="text/javascript">
    $(document).ready(function () {
        if(window.location.href.indexOf("#active") > -1) {
            $('html, body').animate({
                scrollTop: $('#news').offset().top
            }, 'slow');
        }
    });
</script>

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
        if(Input::get('edit')) { //Edit News
            $admin = new Admin();

            $news = $admin->getNews(Input::get('id'));

            foreach ($news as $new) {
                //Blah Blah
            }
        ?>

            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">News</h3>
                    </div>
                    <div class="panel-body">
                        <form id="news" name="news" action="" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <label class="control-label" for="news-title">Title</label><br>
                                    <input class="form-control" id="news-title" name="news-title" placeholder="Title"
                                           value="<?php echo escape($new->title); ?>">
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="news-body">Body</label>
                                    <textarea id="news-body"
                                              name="news-body"><?php echo escape($new->body); ?></textarea>
                                </div>

                                <input class="btn btn-sm btn-material-lightblue" style="float: left;" type="submit"
                                       id="submit" name="submit" value="Update">
                                <a class="btn btn-sm btn-material-red"
                                   href="?id=<?php echo escape(Input::get('id')); ?>&delete=true"
                                   onclick="return confirm('Are you sure you want to delete this?');"
                                   style="text-decoration: none;">Delete</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>



        <?php
        } else { //Show News Panel
        ?>


        <div class="col-md-8">
            <div class="panel panel-default-blue">
                <div class="panel-heading">
                    <h3 class="panel-title">Create News</h3>
                </div>
                <div class="panel-body">
                    <form id="news" name="news" action="" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label class="control-label" for="news-title">Title</label><br>
                                <input class="form-control" id="news-title" name="news-title" placeholder="Title" value="<?php echo escape(Input::get('news-title')); ?>">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="news-body">Body</label>
                                <textarea id="news-body" name="news-body" style="width: auto !important;"><?php echo escape(Input::get('news-body')); ?></textarea>
                            </div>

                            <input class="btn btn-success" style="float: left;" type="submit" value="Submit">
                        </fieldset>
                    </form>
                </div>
            </div>

            <div id="news" class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Manage News</h3>
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
                            $numbers = $pages->paginate($data, 6);
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
                    </div>

                    <?php
                    if(count($data) < 1) {
                        echo '<b>Hmm, looks like there\'s no news.</b>';
                    } else if(count($data) >= 6) {
                    ?>

                    <div style="text-align:center">
                        <nav>
                            <ul class="pagination">
                                <li><a href="news.php?page=<?php if(Input::get('page') == 1) { echo Input::get('page'); } else { echo Input::get('page') - 1; } ?>#active">&laquo;</a></li>
                                <?php
                                foreach($numbers as $num) {
                                    ?>

                                    <li class="<?php if(Input::get('page') == $num) { echo 'active'; } ?>"><a href="news.php?page=<?php echo $num; ?>#active"><?php echo $num; ?></a></li>

                                <?php
                                }
                                ?>
                                <li><a href="news.php?page=<?php echo Input::get('page') + 1; ?>#active">&raquo;</a></li>
                            </ul>
                        </nav>
                    </div>

                    <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

        <?php
        }

        require_once '../footer.php';
        ?>

</body>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="../js/ripples.js"></script>
<script src="../js/material.js"></script>
<script src="../js/snackbar.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script>
<script src="//cdn.ckeditor.com/4.4.5/standard/ckeditor.js"></script>

<script type="text/javascript">
    CKEDITOR.replace( 'news-body',
        {
            toolbar : 'Basic'
        });
</script>

</html>