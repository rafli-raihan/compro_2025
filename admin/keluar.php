<?php 
    // ini buat end_session e.g. logout

    session_start();
    session_destroy();

    header("location:index.php");
?>