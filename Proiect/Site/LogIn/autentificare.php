<?php

    $utilizator = $_POST['utilizator'];
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

    function afisare($utilizator,$parola){

        $id = -1;

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "proiect";
        

        try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT id,username,parola FROM users");
        $stmt->execute();
        
        
        $verif_user = "";
        $verif_parola = "";

        foreach(new RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) {
            
            if( $utilizator == $v['username'] && $parola == $v['parola'] )
                $id = $v['id'];

        }
        
        } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        }
        $conn = null;

        return $id;

    }

    $id = afisare($utilizator,$parola);

    session_start();
    $_SESSION['id'] = $id;
    
    if( $_SESSION['id'] == -1 ){
        header("location:index.html"); 
        exit();
    }
    else{

        if($_SESSION['produs'] != '-1' ){
            adauga($_SESSION['id'], $_SESSION['produs']);
            $_SESSION['produs'] = '-1';
            header($loc); 
            exit();
        }

        $loc = "location:" . $_SESSION['redirect'];
        header($loc); 
        exit();
    }
    

?>