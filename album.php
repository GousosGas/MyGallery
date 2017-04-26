<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/album_header.php"; ?>


<!--nav album-->

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/album_navigation.php"; ?>
<?php
  $photos = Photo::find_all();


?>


<section class="jumbotron text-xs-center">
  <div class="container">
    <h1 class="jumbotron-heading">My Cloud Gallery</h1>
    <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
    <p>
      <a href="/admin/login.php" class="btn btn-lg btn-outline-secondary ">Login</a>


    </p>
  </div>
</section>

<!--images-->

<div class="album text-muted">
  <div class="container">


    <div class="row">
      <!-- Blog Entries Column -->
      <div class="col-md-12">

        <div class="row">
          <?php  foreach ($photos as $photo): ?>
          <div class="card">
            <img id="imageSource" class="card-img-top img-fluid " src="<?php echo $photo->image_link?>" alt="Card image cap">

            <div class="card-block">
              <div>
              <h4 class="card-title"><?php echo $photo->title ?></h4>
              <p class="card-text"><?php echo $photo->description ?></p>
              </div>

              <!--modal button-->
              <a href="<?php echo $photo->image_link?>"  download class="btn btn-outline-secondary"> Download</a>

            </div>

          </div>
          <?php endforeach;?>



      </div>
    </div>
  </div>
</div>


<!--foooter-->

<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/includes/album_footer.php"; ?>