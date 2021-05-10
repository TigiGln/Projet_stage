<?php
    
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "../POO/class_article.php";
    require "request.php";
?>
<?php
    include('../views/header.php');
    #$_SESSION['connexion'] = 'John Doe';
    $menu = new mainMenu('Insertion');
    $menu->write();
?>
    <form method="get" action="insert.php" enctype="multipart/form-data">
        <?php
            //connexion base de donnée
            $connexionbd = new ConnexionDB("localhost", "biblio", "root", '');//connexion à la bse de donnée
            $_SESSION["connexionbd"] = $connexionbd;//stockage de cette connexion dans une variable de session pour le transit entre les pages
            
            $manager = new Manager($_SESSION["connexionbd"]->pdo);//création de l'objet de requete
            $list_num_access_bd = $manager->get_test('num_access', 'article');//requete sur la base pour récupérer les num_access présent
            $pmid = "";
            $listpmid = [];
            $list_objects = [];
            if (isset($_GET["textarea"]) AND $_GET["textarea"] != "")#test l'existence d'un élément dans le textarea
            {
                if ($_GET["list_query"] == "PMID" OR $_GET["list_query"] == "ELocationID")#condition selon le choix de la liste déroulante PMID et DOI
                {
                    $pmid = trim($_GET["textarea"]);
                    $listpmid = explode("\n", str_replace("\r\n", "\n", $pmid));//création de la liste de PMID ou DOI pour la requête
                    $listpmid = array_values(array_unique($listpmid));//vérification qu'il n'y ait pas de doublons
                    //var_dump($listpmid);
                       
                }
                elseif ($_GET["list_query"] == "Author" OR $_GET["list_query"] == "Title")#condition selon le choix de la liste déroulante Author
                {
                    $nb = strval(10); //nb d'articles à récupérer
                    $base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=' . $nb .'&usehistory=y&term=';//variable contenant la requête pour récupérer la liste de PMID selon les crières de requête
                    $text = urlencode(rtrim(strip_tags($_GET["textarea"])));
                    $search_pmid = file_get_contents($base . $text . "[" . $_GET['list_query'] . "]");//lancement de la requête
                    $search_pmid = new SimpleXMLElement($search_pmid);//création de l'objet de parsing XML
                    foreach ($search_pmid->IdList->Id as $id)
                    {
                        $listpmid[] = $id;
                    }
                }
                elseif ($_GET['list_query'] == 'dp')//cas particuler pour la date de publication
                {
                    $nb = strval(20); 
                    $base = 'https://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=' . $nb .'&usehistory=y&term=';
                    $text = strval(rtrim(strip_tags($_GET["textarea"])));
                    #echo $text;
                    $date = "[" . strval(strip_tags($_GET['list_query'])) . "]";
                    $year_req = '"' . $text . '"' . $date . ':' . '"' . $text . '"' . $date;
                    $search_pmid = file_get_contents($base . $year_req);
                    $search_pmid1 = new SimpleXMLElement($search_pmid);
                    foreach ($search_pmid1->IdList->Id as $id)
                    {
                        $listpmid[] = $id;
                    }

                }
            }
            /*elseif (isset($_FILES[$_GET["myfile"]]) AND $_FILES[$_GET["myfile"]]["error"] != 0)
            {
                $size = $_FILES[$_GET["myfile"]]["size"];
                $name = $_FILES[$_GET["myfile"]]["tmp_name"];
                $file = fopen($name, "r");
                $lines = rtrim(fread($file, $size));
                $listpmid = explode("\n", $lines);
            }*/
            if (!empty($listpmid))
            {
                echo "<div class='flex p-4 w-100 overflow-auto' style='height: 100vh;'><h1>Table of our research</h1>";
                $global_check = "<input type='checkbox' name = 'global_check' onclick = 'check(this)'>";
                echo "<table class='table table-responsive table-hover table-bordered'>\n<tr class='table-info'><th>PMID</th><th>Title</th><th>Authors</th><th>" . $global_check . "</th></tr>\n";
                $i = 0;
                while($i < count($listpmid))//boucle sur la liste de pmid remplissant les conditions
                {
                    //$id = $listpmid[$i];
                    $output = search($listpmid, $i);
                    $list_info = recovery($output);
                    if (!empty($list_info))
                    {
                        $origin = "";
                        $num_access = $list_info[0];
                        $doi = $list_info[1];
                        $pmcid = $list_info[2];
                        $title = $list_info[3];
                        $title = str_replace('"', "'", $title);
                        $year = $list_info[4];
                        $abstract = $list_info[5];
                        $abstract = str_replace('"', "'", $abstract);
                        $authors = $list_info[6];
                        //$authors = rtrim($authors);
                        $journal = $list_info[7];
                        $listauthors = $list_info[8];
                        $listauthor = implode(', ', $listauthors);
                        if ($num_access != "")
                        {
                            $origin = 'pubmed';
                        }
                        else
                        {
                            $origin = 'doi';
                        }
                        $object_article = new Article($origin, $num_access, $title, $abstract, $year, $journal, $pmcid, '1', $listauthors, $_SESSION['userID']);
                        //var_dump($object_article);
                        $list_objects[$num_access] = $object_article;
                        $check = "<input type='checkbox' class = check name='check[]' id = $num_access value= '" . $object_article->getnum_access($num_access) . "'>\n";
                        $survol = '<a class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content= "' . $abstract . "\">" ;
                        $survolauthor = '<a class="note1" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content= "' . $listauthor . "\">" ;
                        echo "<tr><td>" .  $num_access . "</td>\n<td>" . $survol . trim($title) . "</a></td>\n<td>" . $survolauthor . $authors[0] . ", ... , " . end($authors) . "</a></td>\n<td>" . $check . "</td></tr>\n" ;
                    }
                    $i++;
                }
                echo "</table>";
                echo "<p><input class='btn btn-outline-success' type='submit' value='Insert'></p>";

            }
            else
            {
                include("./form.php");
                echo "<p>Merci de remplir un champ demandés </p>";
                
            }
            $_SESSION["list_articles"] = $list_objects;
            //var_dump($_SESSION["list_articles"]);

        ?>
        </div>
        <script>
            var listNumAccessDb = <?php echo json_encode($list_num_access_bd); ?>;
        </script>
    <script src="./update_request_table.js"></script> 
<?php
         
    include('../views/footer.php');
?>
