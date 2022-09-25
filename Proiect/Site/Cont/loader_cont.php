<?php

    session_start();

    function cont(){

        $myfile = fopen("ActualPage/index.html", "w");
        $txt = "";
        $total = 0;

        $id = $_SESSION['id'];


        function info($id, &$user, &$email, &$telefon, &$adresa){

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "proiect";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("SELECT usename, email, adresa, telefon FROM users WHERE id = $id ");
                $stmt->execute();
                
        
                foreach(new RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) {
                    
                    $user = $v['username'];
                    $email = $v['email'];
                    $adresa = $v['adresa'];
                    $telefon = $v['telefon'];
        
                }
                
                } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                }
                $conn = null;

        }

        function main(&$txt){

            $user = "";
            $email = "";
            $telefon = "";
            $adresa = "";

            info($_SESSION['id'], $user, $email, $telefon, $adresa);    

            $txt = "
            <!DOCTYPE html>
            <html lang=\"en\">
            <head>
                <meta charset=\"UTF-8\">
                <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <title>Cont</title>

                <link rel=\"stylesheet\" href=\"style.css\">

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
                    <a href=\"../../Homepage/loader_homepage.php\">Home</a>
                    <a href=\"../../Cos/loader_cos.php\">Cos de cumparaturi</a>
                    <a href=\"../../Despre/index.html\">Despre</a>
                    <a href=\"logOut.php\">Log Out</a>
                </div>

                <table id = \"cont\">

                    <tr id=\"dateP\"><td colspan=\"2\">Date Personale</td></tr>

                    <tr class=\"mini-space\"><td colspan=\"2\"></td></tr>

                    <tr class=\"date\">
                        <td id=\"col1\">Utilizator: ". $user ."</td>
                        <td id=\"col2\">Email: ". $email ."</td>
                    </tr>

                    <tr class=\"date\">
                        <td id=\"col1\">Telefon: ". $telefon ."</td>
                        <td id=\"col2\">Adresa: ". $adresa ."</td>
                    </tr>

                    <tr id=\"big-space\"><td colspan=\"2\"></td></tr>
                </table>

                <table id = \"comenzi\">
        
                <tr id=\"titluCom\"><td colspan=\"3\">Comenzi</td></tr>

                <tr class=\"mini-space\"><td colspan=\"3\"></td></tr>
                ";


        }

        function fin(&$txt){

            $txt .= "
            
                <tr id=\"final-space\"><td colspan=\"3\"></td></tr>

                </table>

                
            </body>


            <script>

                function open_menu() {

                    document.getElementById(\"dropdown\").style.visibility = \"visible\";

                }

                function close_menu() {


                    document.getElementById(\"dropdown\").style.visibility = \"hidden\";

                }

                document.getElementById(\"dropdown\").style.visibility = \"hidden\";


            </script>

            </html>

            ";
            

        }

        function get_data($id_comanda, &$data, &$ora){
            
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "proiect";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("SELECT dataa,ora FROM facturi WHERE id_factura = $id_comanda ");
                $stmt->execute();
                
        
                foreach(new RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) {
                    
                    $data = $v['dataa'];
                    $ora = $v['ora'];
        
                }
                
                } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                }
                $conn = null;

        }

        function item($id_comanda, $data, $ora){

            $row = "
            <form method=\"POST\" action=\"loader_comanda.php\">
                <tr class=\"comanda\">
                    <td class=\"id_comanda\">Nr. comanda: ". $id_comanda ."</td>
                    <td class=\"data\">Data plasarii comenzii: ". $data ." &#65279; &#65279; &#65279; Ora: ". $ora ."</td>
                    <td class=\"buton\"><button class=\"apasa\">Afiseaza Comanda</button></td>
                    <td style=\"display: none;\"><input type=\"text\" value= ". $id_comanda ." name=\"id_comanda\"></td>
                </tr>
            </form>
            ";
            

            return $row;

        }

        function core(&$txt, $id){

            $id_comanda = "";
            $data = "";
            $ora = "";


            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "proiect";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("SELECT id_factura FROM facturi WHERE id_client = $id ");
                $stmt->execute();
                
                foreach(new RecursiveArrayIterator($stmt->fetchAll()) as $k=>$v) {
                    
                    $id_comanda = $v['id_factura'];
                    get_data($id_comanda, $data, $ora);
                    $txt .= item($id_comanda, $data, $ora);

        
                }
                
                } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                }
                $conn = null;

            
        }



        main($txt);
        core($txt, $_SESSION['id']);
        fin($txt); 


        fwrite($myfile, $txt);
        fclose($myfile);

        header("location:ActualPage/index.html"); 
            exit();

    }


    
    if($_SESSION['id'] == '-1'){
        $_SESSION['redirect'] = '../Cont/loader_cont.php';
        header("location:../LogIn/index.html"); 
            exit();
    }
    else
        cont();

?>