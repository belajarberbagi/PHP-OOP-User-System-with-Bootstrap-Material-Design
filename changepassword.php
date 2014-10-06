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
            'current_password' => array(
                'required' => true,
                'min' => 6
            ),
            'new_password' => array(
                'required' => true,
                'min' => 6
            ),
            'new_password_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'new_password'
            )
        ));
    }

    if($validate->passed()) {
        if(Hash::make(Input::get('current_password'), $user->data()->salt) !== $user->data()->password) {
            echo 'Your current password is wrong.';
        } else {
            $salt = Hash::salt(32);
            $user->update(array(
                'password' => Hash::make(Input::get('new_password'), $salt),
                'salt' => $salt
            ));

            Session::flash('home', 'Your password has been changed!');
            Redirect::to('index.php');
        }
    } else {
        foreach($validate->errors() as $error) {
            echo $error, '<br>';
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
                    <h3 class="panel-title">Change Password</h3>
                </div>
                <div class="panel-body">
                    <form action="" method="post" name="changepassword" id="changepassword" data-parsley-validate>
                        <fieldset>
                            <div class="form-group">
                                <label class="control-label" for="current_password">Current Password</label>
                                <input class="form-control" type="password" placeholder="Current Password" name="current_password" id="current_password" autofocus="" data-parsley-trigger="change" data-parsley-minlength="6" required>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="new_password">New Password</label>
                                <input class="form-control" type="password" placeholder="New Password" name="new_password" id="new_password" data-parsley-trigger="change" data-parsley-minlength="6" required>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="new_password_again">Confirm New Password</label>
                                <input class="form-control" type="password" placeholder="Repeat Password" name="new_password_again" id="new_password_again" data-parsley-trigger="change" data-parsley-equalto="#new_password" required>
                            </div>

                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                            <input class="btn btn-primary" style="float:left;" type="submit" value="Change Password">
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
    $("#changepassword").parsley({
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