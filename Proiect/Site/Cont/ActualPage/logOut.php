<?php

    session_start();
    $_SESSION['id'] = '-1';

    

    header("location:../../Homepage/loader_homepage.php");
    exit();

?>