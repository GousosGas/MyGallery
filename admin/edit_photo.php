<?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.php"; ?>
<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>

<?php
$message = "";
$photo = new Photo();

if (empty($_GET['id'])) {
    redirect('photos.php');
} else {
    $photo = Photo::find_by_id($_GET['id']);

    if (isset($_POST['update'])) {

        if ($photo) {
            $photo->title = $_POST['title'];
            $photo->caption = $_POST['caption'];
            $photo->alternative = $_POST['alternative'];
            $photo->description = $_POST['description'];

            $photo->update();
            $message = "<p class='alert alert-success' role='alert'>The Photo was updated successfully</p>";


        } else {
            $message = "<p class='alert alert-danger' role='alert'>The Photo was not updated</p>";

        }
    }
}
?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <?php /*include("includes/top_nav.php"); */ ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/top_nav.php"; ?>
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
                        Edit Photos
                    </h1>

                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-fw fa fa-picture-o"></i> <a href="photos.php">Photos</a>
                        </li>

                        <li class="active">
                            <i class="fa fa-file"></i> Edit Photo
                        </li>
                    </ol>

                    <form action="" method="post">
                        <div class="col-md-8">
                            <?php echo $message ?>

                            <div class="form-group">
                                <label for="caption">Title</label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="The title of the image" value="<?php echo $photo->title ?>">

                            </div>

                            <div class="form-group">
                                <label for="description">Description (<i>limit of 300 characters</i>)</label>
                                <textarea maxlength="300" placeholder="Give a description to the image"
                                          class="form-control" name="description" id="" cols="30"
                                          rows="10"><?php echo $photo->description ?></textarea>
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="photo-info-box">
                                <div class="info-box-header">
                                    <h4>Save <span id="toggle"></span></h4>
                                </div>
                                <div class="inside">
                                    <div class="box-inner">

                                        <p class="text ">
                                            Photo Id: <span class="data photo_id_box"><?php echo $photo->id ?></span>
                                        </p>
                                        <p class="text">
                                            Filename: <span class="data"><?php echo $photo->filename ?></span>
                                        </p>
                                        <p class="text">
                                            File Type: <span class="data"><?php echo $photo->type ?></span>
                                        </p>
                                        <p class="text">
                                            File Size: <span class="data"><?php echo $photo->size ?> bytes</span>
                                        </p>
                                    </div>
                                    <div class="info-box-footer clearfix">
                                        <div class="info-box-delete pull-left">
                                            <a href="delete_photo.php?id=<?php echo $photo->id; ?>"
                                               class="btn btn-danger btn-lg ">Delete</a>
                                        </div>
                                        <div class="info-box-update pull-right ">
                                            <input type="submit" name="update" value="Update"
                                                   class="btn btn-primary btn-lg ">
                                        </div>
                                    </div>
                                </div>
                            </div>
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