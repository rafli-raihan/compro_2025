<?php
if (isset($_GET['page'])) {
    if (file_exists('content/' . $_GET['page'] . ".php")) {
        include 'content/' . $_GET['page'] . ".php";         #Ini ngecek ada atau nggak route ini di dalam folder content/
    } else {
        include 'content/notfound.php';   #kalo gaada lgsg di redirect ke not found
    }
} else {
    include 'content/home.php';
}
