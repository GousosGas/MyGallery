<?php /*require_once("includes/header.php");*/?>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.php";?>
<?php

    if($session->is_signed_in()){
        redirect("index.php");
    }

    if(isset($_POST['submit'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);


        //method to check database user
        $user_found = User::verify_user($username,$password);


        if ($user_found) {
            $session->login($user_found);
            redirect("index.php");
        } else {
            $the_message = "<p class='alert alert-danger'>The Username or Password was wrong</p>";
        }

    }else{
        $username = null;
        $password = null;

    }

?>



<div class="col-md-4 col-md-offset-3">



    <div class="login">
        <h1 class="text-center jumbotron-heading">My Cloud Gallery</h1>
        <hr class="jumbotron-hr">

            <p><?php echo $the_message; ?></p>

            <form id="login-id" action="" method="post">

                <div class="form-group">
                    <label class="text-muted" for="username">Username</label>
                    <input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >

                </div>

                <div class="form-group">
                    <label class="text-muted" for="password">Password</label>
                    <input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">

                </div>


                <div class="form-group">
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block">

                </div>


            </form>
    </div>

</div>

<script></script>
