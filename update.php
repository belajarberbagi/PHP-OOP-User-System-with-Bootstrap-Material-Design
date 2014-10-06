<?php
/**
 * Created by Chris on 9/29/2014 3:53 PM.
 */

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'email' => array(
                'required' => trye,
                'min' => 1,
                'max' => 255
            )
        ));

        if($validate->passed()) {
            try {
                $user->update(array(
                    'name' => Input::get('name')
                ));

                Session::flash('home', 'Your details have been updated.');
                Redirect::to('index.php');

            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            foreach($validate->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
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
    <link href="//fezvrasta.github.io/snackbarjs/dist/snackbar.min.css" rel="stylesheet">

    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>

    <?php require_once 'header.php'; ?>
</head>

<body>

<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Update Profile</h3>
                </div>
                <div class="panel-body">
                        <form action="" method="post" name="update" id="update" data-parsley-validate>
                            <fieldset>
                                <div class="form-group">
                                    <label class="control-label" for="name">Full Name</label>
                                    <input class="form-control" type="text" placeholder="Full Name" name="name" id="name" value="<?php echo escape($user->data()->name); ?>" autofocus="" data-parsley-trigger="change" data-parsley-minlength="2" data-parsley-maxlength="50" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="email">Email Address</label>
                                    <input class="form-control" type="email" placeholder="johndoe@email.com" name="email" id="email" value="<?php echo escape($user->data()->email); ?>" data-parsley-trigger="change" data-parsley-minlength="1" data-parsley-maxlength="255" required>
                                </div>


                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                <input class="btn btn-primary" style="float:left;" type="submit" value="Update">
                                <a class="btn btn-danger" style="float:right;" onclick="location.href='changepassword.php'">Change Password</a>
                            </fieldset>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>

</body>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="js/ripples.js"></script>
    <script src="js/material.js"></script>
    <script src="//fezvrasta.github.io/snackbarjs/dist/snackbar.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/parsley.js/2.0.5/parsley.js"></script>

    <script>
        $("#update").parsley({
            successClass: "has-success",
            errorClass: "has-error",
            classHandler: function (el) {
                return el.$element.closest(".form-group");
            },
            errorsContainer: function (el) {
                return el.$element.closest(".form-group");
            },
            errorsWrapper: "<span class='help-block'></span>",
            errorTemplate: "<span></span>"
        });
    </script>

</html>