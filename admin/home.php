# home.php adalah master template


<?php
session_start();
ob_start();
include 'koneksi.php';
if (empty($_SESSION['ID_USER'])) {
  header('location:index.php?access=failed'); // Ini buat proteksi login, jadi klo id gak ketemu di db
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

  <?php
  include 'inc/css.php';
  ?>
</head>

<body>
  <?php
  include 'inc/header.php';  // ini buat misahin html jadi component a la in Vue_Components / Flutter Widget, komponen2 html ke dalam folder inc/ biar bisa dipake berkali2
  ?>

  <?php
  include 'inc/sidebar.php';
  ?>

  <main id="main" class="main">
    <!--  ini kya <RouterView /> ibaratnya -->
    <?php
    if (isset($_GET['page'])) {
      if (file_exists('content/' . $_GET['page'] . ".php")) {
        include 'content/' . $_GET['page'] . ".php";         #Ini ngecek ada atau nggak route ini di dalam folder content/
      } else {
        include 'content/notfound.php';   #kalo gaada lgsg di redirect ke not found
      }
    } else {
      include 'content/dashboard.php';
    }
    ?>



  </main><!-- End #main -->

  <?php
  include 'inc/footer.php';
  ?>

  <?php
  include 'inc/js.php';
  ?>

  <!-- Summernote itu form kya di github markdown editor, cara manggilnya cek di tambah-about.php -->
  <script>
    $('#summernote').summernote({
      height: 300, // set editor height
      minHeight: null, // set minimum height of editor
      maxHeight: null, // set maximum height of editor
      focus: true // set focus to editable area after initializing summernote
    });
  </script>
</body>

<!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

</html>