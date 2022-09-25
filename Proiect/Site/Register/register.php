<?php

    $username = $_POST['utilizator'];
    $email = $_POST['email'];
    $adresa = $_POST['adresa'];
    $telefon = $_POST['telefon'];
    $parola = $_POST['parola'];


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
            
            header("location:../../Cos/loader_cos.php");
            exit();
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;

    }

    function append($username, $email, $adresa, $telefon, $parola){

        $servername = "localhost";
        $dbname = "proiect";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO users (username, email, adresa, telefon, parola) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            // use exec() because no results are returned
            $stmt->execute([$username, $email, $adresa, $telefon, $parola]);
            //echo "New record created successfully";
            
            header("location:index.html");
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;

    }

    function getId(){

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "proiect";
        
        $id = 0;

        try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT id FROM users");
        $stmt->execute();

        foreach(new RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) {
            
            $id = $v['id'];

        }
        
        } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        }
        $conn = null;

        return $id;

    }


    session_start();

    $_SESSION['id'] = getId();

    append($username,$email,$adresa,$telefon,$parola);

    if($_SESSION['produs'] != '-1' ){
        adauga($_SESSION['id'], $_SESSION['produs']);
        $_SESSION['produs'] = '-1';
    }

    header($_SESSION['redirect']); 
    exit();
    
?>