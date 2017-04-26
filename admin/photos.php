<?php /*include("includes/header.php"); */ ?>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.php"; ?>

    <!--check if users is signed in with the use o sessions-->

<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>

<?php

$photos = Photo::find_all();

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
                        Photos
                    </h1>

                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-fw fa fa-picture-o"></i> Photos
                        </li>
                    </ol>

                    <div class="col-md-12">

                        <table class="table table-hover">
                            <thead>
                            <tr>

                                <th>Photo</th>
                                <!--<th>Id</th>-->
                                <th>File name</th>
                                <th>Title</th>
                                <th>Size (bytes)</th>
                                <!-- <th>Link</th>-->

                            </tr>

                            </thead>
                            <tbody>

                            <?php foreach ($photos as $photo): ?>
                                <tr>
                                    <td>

                                        <img class="admin-photo-thumbnail" src="<?php echo $photo->image_link ?>"/>

                                        <div class="pictures">
                                            <a href="delete_photo.php?id=<?php echo $photo->id ?>"> Delete</a>
                                            <a href="edit_photo.php?id=<?php echo $photo->id ?>"> Edit</a>

                                        </div>
                                    </td>
                                    <!--<td><?php /*echo $photo->id; */ ?></td>-->
                                    <td><?php echo $photo->filename; ?></td>
                                    <td><?php echo $photo->title; ?></td>
                                    <td><?php echo $photo->size; ?></td>
                                    <!--<td><?php /*echo $photo->image_link; */ ?></td>-->
                                </tr>
                            <?php endforeach; ?>
                            </tbody>


                        </table>


                    </div>


                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>