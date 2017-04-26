<?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.php"; ?>

<!--check if users is signed in with the use o sessions-->
<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>
<?php

$users = User::find_all();

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
                    <h2 class="page-header">
                        Users
                    </h2>

                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                        </li>
                        <li class="active">
                            Users
                        </li>
                    </ol>

                    <div class="col-md-12">

                        <table class="table table-hover">
                            <thead>
                            <tr>

                                <!--<th>Id</th>-->
                                <th>Photo</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <!--<th>img link</th>-->

                            </tr>
                            </thead>

                            <tbody>

                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <!--<td><?php /*echo $user->id; */ ?></td>-->
                                    <td><img class="user-photo-size" src="<?php echo $user->image_link ?>" alt=""></td>
                                    <td><?php echo $user->username; ?>
                                        <div class="action_links">
                                            <a href="delete_user.php?id=<?php echo $user->id ?>"> Delete</a>
                                            <a href="edit_user.php?id=<?php echo $user->id ?>"> Edit</a>
                                        </div>
                                    </td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo $user->first_name; ?></td>
                                    <td><?php echo $user->last_name; ?></td>
                                    <!--<td><?php /*echo $user->image_link; */ ?></td>-->
                                </tr>
                            <?php endforeach; ?>
                            </tbody>


                        </table>
                        <hr>
                        <a href="create_user.php" class="btn btn-primary">Create a new User</a>
                    </div>


                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>