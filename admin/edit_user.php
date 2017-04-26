<?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.php"; ?>
<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>

<?php

$messsage = "";

if (empty($_GET['id'])) {
    redirect("users.php");
}
$user = User::find_by_id($_GET['id']);
if (isset($_POST['update'])) {
    if ($user) {
        $user->username = $_POST['username'];
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->password = $_POST['password'];
        $user->email = $_POST['email'];
        $user->user_image = $_POST['user_image'];

        $user->save();
        $message = "<p class='alert alert-success' role='alert'>The User was updated successfully</p>";
    } else {
        $message = "<p class='alert alert-danger' role='alert'>There was an error</p>";

    }

}
if (isset($_POST['delete'])) {
    $user->delete();
    redirect("users.php");
}

?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <?php include("includes/top_nav.php"); ?>

        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <?php include("includes/sidebar.php") ?>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Edit User
                    </h1>

                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-fw fa-bar-chart-o"></i> <a href="users.php">Users</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-file"></i> Edit User
                        </li>
                    </ol>

                    <form action="" enctype="multipart/form-data" method="post">

                        <?php echo $message ?>
                        <div class="col-md-6">


                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control"
                                       value="<?php echo $user->username ?>">
                            </div>

                            <div class="form-group">
                                <label for="first-name">First Name</label>
                                <input type="text" name="first_name" class="form-control"
                                       value="<?php echo $user->first_name ?>">
                            </div>

                            <div class="form-group ">
                                <label for="last-name">Last Name</label>
                                <input type="text" name="last_name" class="form-control"
                                       value="<?php echo $user->last_name ?>">
                            </div>

                            <div class="form-group ">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="<?php echo $user->email ?>">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control"
                                       value="<?php echo $user->password ?>">

                            </div>
                            <input type="submit" name="update" class="pull-right btn btn-primary" value="Update">
                            <input type="submit" name="delete" class="pull-left btn btn-danger" value="Delete">

                        </div>

                    </form>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>