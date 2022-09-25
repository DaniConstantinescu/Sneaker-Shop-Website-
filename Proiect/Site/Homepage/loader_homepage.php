<?php

    function homepage(){

        $myfile = fopen("ActualPage/index.html", "w");
        $txt = "";
        $total = 0;

        session_start();
        $id = $_SESSION['id'];

        
        function main(&$txt){
            $txt = "
            <!DOCTYPE html>
            <html lang=\"en\">
            <head>
                <meta charset=\"UTF-8\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            
                <link rel=\"stylesheet\" href=\"style.css\">
            
                <title>Homepage</title>
            </head>
            <body>
                
                <table id=\"header\">
                    <tr id=\"menu\">
                        <td id=\"meniu\" onmouseover=\"open_menu()\" onmouseleave=\"close_menu()\"></td>
            
                        <td id=\"spatiu_titlu\"></td>

                        <td id=\"Nume_Site\">SNKRS</td>

                        <td></td>
            
                        <td id=\"spatiu_dr\"></td>
                    </tr>
                    
                </table>

                <div id=\"dropdown\" onmouseover=\"open_menu()\" onmouseleave=\"close_menu()\">
                    <a href=\"../../Cont/loader_cont.php\">Cont</a>
                    <a href=\"../../Cos/loader_cos.php\">Cos de cumparaturi</a>
                    <a href=\"../../Despre/index.html\">Despre</a>
                </div>
                
                <table id=\"articole\">


                ";


        }

        function fin(&$txt){

            $fin = "
                        <tr class=\"big-space\"><td colspan=\"6\"></td></tr>

                    </table>

                </body>

                <script>

                    function open_menu(){

                        document.getElementById(\"dropdown\").style.visibility = \"visible\";

                    }

                    function close_menu(){

                        
                        document.getElementById(\"dropdown\").style.visibility = \"hidden\";

                    }

                    document.getElementById(\"dropdown\").style.visibility = \"hidden\";


                </script>

                </html>
                ";

            $txt .= $fin;

        }

        function get_data($id ,&$image, &$nume, &$color, &$gen, &$pret){
            
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "proiect";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("SELECT id, nume, gen, colorway, pret, imagine FROM produse WHERE id = $id ");
                $stmt->execute();
                
        
                foreach(new RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) {
                    
                    $image = $v['imagine'];
                    $nume = ucfirst($v['nume']);
                    $color = $v['colorway'];
                    $pret = $v['pret'] . '$';
                    $gen = ucfirst($v['gen']);
        
                }
                
                } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                }
                $conn = null;

        }

        function item($id_produs, $image, $nume, $color, $gen, $pret){

            $row = "
            <tr class=\"item\">
                <td class=\"icon\"><img class=\"icon\" src=\"" . $image . "\"></td>";
            
            $row .= "
            <td class=\"nume\">" . $nume ."</td>";

            $row .= "
            <td class=\"colorway\">" . $color . "</td>";

            $row .= "
            <td class=\"gen\">" . $gen . "</td>";

            $row .= "
            <td class=\"pret\">" . $pret . "</td>";


            $row .= "
            <form method=\"post\" action=\"adauga_cos.php\">
            <td class=\"remove\"><button class=\"sterge\">Adauga in cos</button></td>

            <td style=\"display: none;\"> <input type=\"text\" value=" . $id_produs . " name=\"id_prod\" ></td>
            </form> 
            </tr>
            
            <tr class=\"spacing\"><td colspan=\"6\"></td></tr>
            ";

            return $row;

        }

        function core(&$txt){

            $image = "";
            $nume = "";
            $color = "";
            $gen = "";
            $pret = "";

            $id_produs = "";


            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "proiect";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("SELECT id FROM produse");
                $stmt->execute();
                
                foreach(new RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) {
                    
                    $id_produs = $v['id'];
                    get_data($id_produs, $image, $nume, $color, $gen, $pret);
                    $txt .= item($id_produs, $image, $nume, $color, $gen, $pret);

        
                }
                
                } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                }
                $conn = null;

            
        }



        main($txt);
        core($txt);
        fin($txt); 


        fwrite($myfile, $txt);
        fclose($myfile);

        header("location:ActualPage/index.html"); 
            exit();

    }

    homepage();

?>