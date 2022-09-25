<?php

    session_start();
    $_SESSION['id'] = '-1';
    $_SESSION['produs'] = '-1';
    $_SESSION['redirect'] = "";

    header("location:Homepage/loader_homepage.php"); 
    exit();

?>