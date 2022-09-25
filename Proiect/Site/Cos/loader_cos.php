<?php

    function cos_cumparaturi(){

        $myfile = fopen("ActualPage/index.html", "w");
        $txt = "";
        $total = 0;

        $id = $_SESSION['id'];
        $_SESSION['produs'] = '-1';

        
        function main(&$txt){
            $txt = "
            <!DOCTYPE html>
            <html lang=\"en\">
            <head>
                <meta charset=\"UTF-8\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            
                <link rel=\"stylesheet\" href=\"style.css\">
            
                <title>Cos de cumparaturi</title>
            </head>
            <body>
                
            <body>
                
            <table id=\"header\">
                <tr id=\"menu\">
                    
                    <td id=\"meniu\" onmouseover=\"open_menu()\" onmouseleave=\"close_menu()\"></td>
        
                    <td id=\"spatiu_titlu\"></td>

                    <td id=\"Nume_Site\" onclick = \"window.location='../../Homepage/loader_homepage.php';\">SNKRS</td>

                    <td></td>
        
                    <td id=\"spatiu_dr\"></td>
                </tr>
                
            </table>

            <div id=\"dropdown\" onmouseover=\"open_menu()\" onmouseleave=\"close_menu()\">
                    <a href=\"../../Homepage/loader_homepage.php\">Home</a>
                    <a href=\"../../Cont/loader_cont.php\">Cont</a>
                    <a href=\"../../Despre/index.html\">Despre</a>
            </div>
                
                <table id=\"articole\">

                <tr class=\"hd\">
                    <td class=\"icon\"></td>
                    <td class=\"nume_h\">Nume</td>
                    <td class=\"colorway\">Culoare</td>
                    <td class=\"gen\">Gen</td>
                    <td class=\"pret\">Pret</td>
                    <td class=\"remove\"></td>
                </tr>

                <tr class=\"mini-space\"><td colspan=\"6\"></td></tr>

                ";


        }

        function fin(&$txt,$total){

            if( $total == 0 ){
                $fin = "
                        
                        <tr class=\"total\">
                            <td colspan=\"2\"></td>
                            <td class=\"gen\" colspan=\"2\">Total:</td>
                            <td class=\"pret\">" . $total . "$</td>
                            <td class=\"remove\"><button class=\"sterge disabled\">Comanda!</button></td>

                        </tr>

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
            }   
            else{
                $fin = "
                        
                        <tr class=\"total\">
                        <form method=\"post\" action=\"comanda.php\">
                            <td colspan=\"2\"></td>
                            <td class=\"gen\" colspan=\"2\">Total:</td>
                            <td class=\"pret\">" . $total . "$</td>
                            <td class=\"remove\"><button class=\"sterge\">Comanda!</button></td>
                        </form>
                        </tr>

                        <tr class=\"big-space\"><td colspan=\"6\"></td></tr>

                    </table>

                </body>

                ";

                $fin .= "
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
            }

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

        function item($id_produs,$image, $nume, $color, $gen, $pret){

            $row = "
            <tr class=\"item\">
            <form method=\"post\" action=\"sterge.php\">
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
                    <td class=\"remove\"><button class=\"sterge\">Sterge</button></td>
                    <td style=\"display: none;\"><input type=\"text\" value=" . $id_produs . " name=\"id_prod\" ></td>
                </form>
            </tr>
            
            <tr class=\"spacing\"><td colspan=\"6\"></td></tr>
            ";
            

            return $row;

        }

        function core(&$txt, $id, &$total){

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
                $stmt = $conn->prepare("SELECT id_produs FROM cos_cumparaturi WHERE id_user = $id ");
                $stmt->execute();
                
                foreach(new RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) {
                    
                    $id_produs = $v['id_produs'];
                    get_data($id_produs, $image, $nume, $color, $gen, $pret);
                    $txt .= item($id_produs,$image, $nume, $color, $gen, $pret);

                    $total += (int) $pret;

        
                }
                
                } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                }
                $conn = null;

            
        }



        main($txt);
        core($txt, $id, $total);
        fin($txt, $total); 


        fwrite($myfile, $txt);
        fclose($myfile);

        header("location:ActualPage/index.html"); 
            exit();

    }


    session_start();
    if($_SESSION['id'] == '-1'){
        header("location:../LogIn/index.html"); 
            exit();
    }
    else
        cos_cumparaturi();

?>