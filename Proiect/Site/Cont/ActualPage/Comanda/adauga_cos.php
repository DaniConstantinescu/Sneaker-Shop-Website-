<?php

    session_start();
    $id_produs = $_POST['id_prod'];
    $id = $_SESSION['id'];

    function adauga($id, $id_produs){

        $servername = "localhost";
        $dbname = "proiect";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO cos_cumparaturi (id_user, id_produs) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            // use exec() because no results are returned
            $stmt->execute([$id, $id_produs]);
            //echo "New record created successfully";
            
            header("location:../../../Cos/loader_cos.php");
            exit();
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;

    }


    $_SESSION['produs'] = $id_produs;

    if($_SESSION['id'] == -1 ){
        $_SESSION['redirect'] = "../Cos/loader_cos.php";
        header("location:../../LogIn/index.html"); 
            exit();
    }
    else{
        adauga($id, $id_produs);
    }
?>