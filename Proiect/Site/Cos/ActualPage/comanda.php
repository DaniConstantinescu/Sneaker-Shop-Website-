<?php

    session_start();
    $id = $_SESSION['id'];

    function nr_factura(){

        $contor = 0;

        $servername = "localhost";
        $dbname = "proiect";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT id_factura FROM facturi");
            $stmt->execute();
                
                foreach(new RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) {
                    
                    $contor = $v['id_factura'];
        
                }
        
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;

        $contor += 1;

        return $contor;


    }

    function factura($id){

        $servername = "localhost";
        $dbname = "proiect";

        $id_factura = nr_factura();
        
        $produse = array();

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT id_produs FROM cos_cumparaturi WHERE id_user = $id ");
            $stmt->execute();
                
                foreach(new RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) {
                    
                    $id_produs = $v['id_produs'];
                    array_push($produse,$id_produs);
        
                }

            
            $comanda = json_encode(array(
                "produse" => $produse
            ));

            $data = date("d.m.Y");
            $ora = date("h:i");

            $sql = "INSERT INTO facturi (id_factura, id_client, comanda, dataa, ora) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id_factura, $id, $comanda, $data, $ora]);


            
            $sql = "DELETE FROM cos_cumparaturi WHERE id_user = $id ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            
            
            header("location:../../../Homepage/index.html");
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;

    }

    factura($id);

?>