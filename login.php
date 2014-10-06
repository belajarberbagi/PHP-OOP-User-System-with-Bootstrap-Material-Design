<?php
/**
 * Created by Chris on 9/29/2014 3:52 PM.
 */

require_once 'core/init.php';

$user = new User();

if($user->isLoggedIn()) {
    Redirect::to('index.php');
}

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'field_name' => 'Username',
                'required' => true
            ),
            'password' => array(
                'field_name' => 'Password',
                'required' => true
            )
        ));

        if($validate->passed()) {
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if($login) {
                Redirect::to('index.php');
            } else {
                $errors = '<div class="bs-component"><div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><b>Incorrect</b> username or password.</div></div>';
            }
        } else {
            foreach($validate->errors() as $error) {
                $errors .= '<div class="bs-component"><div class="alert alert-dismissable alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$error.'</div></div>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>

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
                    <h3 class="panel-title">Login</h3>
                </div>
                <div class="panel-body">
                    <?php
                    if(isset($errors)) {
                        echo $errors;
                    }
                    ?>

                        <form action="" method="post" name="login" id="login" data-parsley-validate>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Username" name="username" id="username" autofocus="" required>
                                </div>

                                <div class="form-group">
                                    <input class="form-control" type="password" placeholder="Password" name="password" id="password" required>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" id="remember">Remember Me
                                    </label>
                                </div>

                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                <input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
                                    <a style="float: right;" href="register.php">Need a account?</a>
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
        $("#login").parsley({
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