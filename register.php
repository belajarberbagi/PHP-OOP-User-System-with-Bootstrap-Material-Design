<?php
/**
 * Created by Chris on 9/29/2014 3:53 PM.
 */

require_once 'core/init.php';

$user = new User();

if($user->isLoggedIn()) {
    Redirect::to('index.php');
}

if (Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'name' => array(
                'field_name' => 'Name',
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'username' => array(
                'field_name' => 'Username',
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'email' => array(
                'field_name' => 'Email',
                'required' => true,
                'min' => 1,
                'max' => 255,
                'unique' => 'users'
            ),
            'password' => array(
                'field_name' => 'Password',
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(
                'field_name' => 'Repeated Password',
                'required' => true,
                'matches' => 'password_again'
            ),
        ));

        if ($validate->passed()) {
            $user = new User();
            $salt = Hash::salt(32);

            try {
                $user->create(array(
                    'name' => Input::get('name'),
                    'username' => Input::get('username'),
                    'email' => Input::get('email'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'joined' => date('Y-m-d H:i:s'),
                    'group' => 1
                ));

                Session::flash('success', 'Welcome <b>' . Input::get('username') . '</b>!<br>Your account has been registered. You may now log in.');
                Redirect::to('login.php');
            } catch(Exception $e) {
                echo $error, '<br>';
            }
        } else {
            foreach ($validate->errors() as $error) {
                $errors .= '<div class="bs-component" style="padding: "><div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$error.'</div></div>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Register</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/material.css" rel="stylesheet">
    <link href="css/ripples.css" rel="stylesheet">
    <link href="css/material-wfont.min.css" rel="stylesheet">
    <link href="css/icons-material-design.css" rel="stylesheet">
    <link href="//fezvrasta.github.io/snackbarjs/dist/snackbar.min.css" rel="stylesheet">

    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/parsley.js/2.0.5/parsley.js"></script>

    <?php require_once 'header.php'; ?>

</head>

<body>

<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Register</h3>
                </div>
                <div class="panel-body">
                    <?php
                    if(isset($errors)) {
                        echo $errors;
                    }
                    ?>

                    <form role="form" action="" method="post" name="register" id="register" data-parsley-validate>
                        <fieldset>
                            <div class="form-group">
                                <label class="control-label" for="name">Full Name</label>
                                <input class="form-control" type="text" name="name" placeholder="Full Name" id="name" value="<?php echo escape(Input::get('name')); ?>" autofocus="" data-parsley-trigger="change" data-parsley-minlength="2" data-parsley-maxlength="50" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input class="form-control" type="text" name="username" placeholder="Username" id="username" value="<?php echo escape(Input::get('username')); ?>" data-parsley-trigger="change" data-parsley-minlength="2" data-parsley-maxlength="20" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="email">Email</label>
                                <input class="form-control" type="email" name="email" placeholder="johndoe@email.com" id="username" value="<?php echo escape(Input::get('email')); ?>" data-parsley-trigger="change" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input class="form-control" type="password" name="password" placeholder="Password" id="password" data-parsley-trigger="change" data-parsley-minlength="6" required/>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="password_agains">Confirm Password</label>
                                <input class="form-control" type="password" name="password_again" placeholder="Confirm Password" id="password_again" data-parsley-trigger="change" data-parsley-equalto="#password" required/>
                            </div>

                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Register">
                            <a style="float: right;" href="login.php">Already registered?</a>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="js/ripples.js"></script>
<script src="js/material.js"></script>
<script src="//fezvrasta.github.io/snackbarjs/dist/snackbar.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script>

<script>
    $("#register").parsley({
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

<?php require_once 'footer.php'; ?>

</body>

</html>