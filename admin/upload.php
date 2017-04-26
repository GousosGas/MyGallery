<?php include $_SERVER["DOCUMENT_ROOT"] . "/admin/includes/header.php"; ?>

    <!--check if users is signed in with the use o sessions-->
<?php if (!$session->is_signed_in()) {
    redirect("login.php");
} ?>

<?php
// Direct uploads requires PHP 5.5 on App Engine.
if (strncmp("5.5", phpversion(), strlen("5.5")) != 0) {
    die("Direct uploads require the PHP 5.5 runtime. Your runtime: " . phpversion());
}
?>

<?php

$message = "";
if (isset($_POST['submit'])) {

    $photo = new Photo();
    $photo->title = $_POST['title'];
    $photo->description = $_POST['description'];

    $photo->set_file($_FILES['file_upload']);
    if ($photo->upload() && $photo->save_image()) {
        $message = "<p class='alert alert-success' role='alert'>
              Image uploaded successfully
            </p>";
    } else {
        $message = join("<br>", $photo->errors);

    }

}


?>    <!-- Navigation -->
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
                        Upload Photo

                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-fw fa-table"></i> Upload
                        </li>
                    </ol>
                </div>

                <div class="col-md-6">

                    <?php echo $message; ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Image title</label>
                            <input type="text" name="title" class="form-control" placeholder="title of the image">
                        </div>
                        <label>Description (<i>limit of 300 characters</i>)</label>
                        <div class="form-group">
                            <textarea maxlength="300" type="text" name="description" class="form-control"
                                      placeholder="descritpion of the image"></textarea>
                        </div>
                        <div class="form-group">

                            <!--  <input name="userfile[]" type="file" multiple="multiple"/>-->

                            <input type="file" name="file_upload" multiple>
                        </div>
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                    </form>
                </div>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>