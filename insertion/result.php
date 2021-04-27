<?php
    
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "../POO/class_article.php";
    require "requete.php";
    session_start();
?>
<?php
    include('../views/header.html');
    #$_SESSION['connexion'] = 'John Doe';
    $menu = new mainMenu('My Tasks');
    $menu->write();
?>
    <form method="get" action="insert.php" enctype="multipart/form-data">
        <?php
            
            $connexionbd = new ConnexionDB("localhost", "biblio", "thierry", "Th1erryG@llian0");
            $_SESSION["connexionbd"] = $connexionbd;
            #include("../POO/start_session.php");
            $pmid = "";
            $listpmid = [];
            $list_objects = [];
            if (isset($_GET["textarea"]) AND $_GET["textarea"] != "")#test l'existence d'un élément dans le textarea
            {
                if ($_GET["list_query"] == "PMID" OR $_GET["list_query"] == "DOI")#condition selon le choix de la liste déroulante
                {
                    $pmid = strip_tags($_GET["textarea"]);
                    $listpmid = explode("\n", $pmid);
                    #var_dump($listpmid);          
                }
                elseif ($_GET["list_query"] == "Author" OR $_GET["list_query"] == "Title")#condition selon le choix de la liste déroulante
                {
                    $nb = strval(10); 
                    $base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=' . $nb .'&usehistory=y&term=';
                    $text = urlencode(rtrim(strip_tags($_GET["textarea"])));
                    $search_pmid = file_get_contents($base . $text . "[" . $_GET['list_query'] . "]");
                    $search_pmid = new SimpleXMLElement($search_pmid);
                    foreach ($search_pmid->IdList->Id as $id)
                    {
                        $listpmid[] = $id;
                    }
                }
                else
                {
                    $nb = strval(10); 
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
                echo "<h1>Table of our research</h1>";
                $global_check = "<input type='checkbox' name = 'global_check' onclick = 'check(this)'>";
                echo "<table>\n<tr><th>PMID</th><th>Title</th><th>" . $global_check . "</th></tr>\n";
                $i = 0;
                while($i < count($listpmid))
                {
                    $output = search($listpmid, $i);
                    $list_info = recovery($output);
                    if (!empty($list_info))
                    {
                        $num_access = $list_info[0];
                        $doi = $list_info[1];
                        $pmcid = $list_info[2];
                        $title = $list_info[3];
                        $year = $list_info[4];
                        $abstract = $list_info[5];
                        $authors = $list_info[6];
                        $journal = $list_info[7];
                        $object_article = new Article($num_access, $title, $abstract, $year, $journal, $pmcid);
                        $list_objects[$num_access] = $object_article;
                        $check = "<input type='checkbox' name='check[]' value= '" . $object_article . "'>\n";
                        $survol = '<a style="border-style: double;" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content= "' . $object_article->abstract() . "\">\n";
                        echo "<tr><td>" .  $object_article->num_access() . "</td>\n<td>" . $survol . trim($object_article->title()) . "</a></td>\n<td>" . $check . "</td></tr>\n" ;
                    }
                    $i++;
                }
                echo "</table>";
                echo "<p><input type='submit' value='Insert'></p>";

            }
            else
            {
                include("./form.php");
                echo "<p>Merci de remplir un champ demandés </p>";
                
            }
            $_SESSION["list_articles"] = $list_objects;
            #var_dump($_SESSION["liste"]);
        ?>
<?php      
    include('../views/footer.html');
?>
