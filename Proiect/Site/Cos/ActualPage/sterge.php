<?php

    $id_produs = $_POST['id_prod'];
    session_start();
    $id = $_SESSION['id'];

    function sterge($id, $id_produs){

        $servername = "localhost";
        $dbname = "proiect";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM cos_cumparaturi WHERE id_user = $id AND id_produs = $id_produs ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            header("location:../loader_cos.php");
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;

    }

    sterge($id, $id_produs);

?>