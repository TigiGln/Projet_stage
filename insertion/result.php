<?php
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "../POO/class_article.php";
    require "../POO/manager_cazy.class.php";
    require "requete.php";
    $manager_cazy = new ManagerCazy('10.1.22.207', 'extern_db', 'glyco', 'Horror3');
?>
<?php
    include('../views/header.php');
    $menu = new MainMenu('Insertion');
    $menu->write();
?>
    <form method="post" action="insert.php" id="insertion" >
<?php
    $list_num_access_bd = $manager->get_test('num_access', 'article');//requete sur la base pour récupérer les num_access présent
    $list_num_access_cazy = $manager_cazy->get_numAccess('pub_db_acc', 'pub_document');//requete pour récupérer les pmid de cazy
    $list_num_access_already_present = array_values(array_unique(array_merge($list_num_access_bd, $list_num_access_cazy)));//création d'une liste de pmid sans doublons qui sont dans les deux bases de données
    $pmid = "";
    $listpmid = [];
    $list_objects = [];
    if (isset($_POST["textarea"]) AND $_POST["textarea"] != "")#test l'existence d'un élément dans le textarea
    {
        if ($_POST["list_query"] == "PMID" OR $_POST["list_query"] == "ELocationID")#condition selon le choix de la liste déroulante PMID et DOI
        {
            $pmid = trim($_POST["textarea"]);
            $listpmid = explode("\n", str_replace("\r\n", "\n", $pmid));//création de la liste de PMID ou DOI pour la requête
            $listpmid = array_values(array_unique($listpmid));//vérification qu'il n'y ait pas de doublons
            //var_dump($listpmid);
                
        }
        elseif ($_POST["list_query"] == "Author" OR $_POST["list_query"] == "Title")#condition selon le choix de la liste déroulante Author
        {
            $nb = strval(10); //nb d'articles à récupérer
            $base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=' . $nb .'&usehistory=y&term=';//variable contenant la requête pour récupérer la liste de PMID selon les crières de requête
            $text = urlencode(rtrim(strip_tags($_POST["textarea"])));
            $search_pmid = file_get_contents($base . $text . "[" . $_POST['list_query'] . "]");//lancement de la requête
            $search_pmid = new SimpleXMLElement($search_pmid);//création de l'objet de parsing XML
            foreach ($search_pmid->IdList->Id as $id)
            {
                $listpmid[] = $id;
            }
        }
        elseif ($_POST['list_query'] == 'dp')//cas particuler pour la date de publication
        {
            $nb = strval(20); 
            $base = 'https://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=' . $nb .'&usehistory=y&term=';
            $text = strval(rtrim(strip_tags($_POST["textarea"])));
            #echo $text;
            $date = "[" . strval(strip_tags($_POST['list_query'])) . "]";
            $year_req = '"' . $text . '"' . $date . ':' . '"' . $text . '"' . $date;
            $search_pmid = file_get_contents($base . $year_req);
            $search_pmid1 = new SimpleXMLElement($search_pmid);
            foreach ($search_pmid1->IdList->Id as $id)
            {
                $listpmid[] = $id;
            }

        }
    }
    elseif (isset($_FILES["myfile"]) AND $_FILES["myfile"]["error"] == 0)
    {
        $size_file = $_FILES["myfile"]["size"];
        $name_file = $_FILES["myfile"]["tmp_name"];
        $file_imported = fopen($name_file, "r");
        $lines_file = rtrim(fread($file_imported, $size_file));
        $listpmid = explode("\n", $lines_file);
    }
    if (!empty($listpmid))
    {
        echo "<h1>Table of our research</h1>";
        $global_check = "<input type='checkbox' id = 'global_check' name = 'global_check' onclick = 'check(this)' onchange = 'checked_check(this)'>";
        echo "<table><thead><tr><th>PMID</th><th class = 'sort_column'>Title</th><th class = 'sort_column'>Authors</th><th>" . $global_check . "</th></tr></thead><tbody>";
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
                $object_article = new Article($origin, $num_access, $title, $abstract, $year, $journal, $pmcid, '1', $listauthors, '6');
                //var_dump($object_article);
                $list_objects[$num_access] = $object_article;
                $check = "<input type='checkbox' onchange = 'checked_check(this)' class = check name='check[]' id = $num_access value= '" . $object_article->getnum_access($num_access) . "'>\n";
                $survol = '<a style="border-style: double;" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content= "' . $abstract . "\">" ;
                $survolauthor = '<a style="border-style: double;" class="note1" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content= "' . $listauthor . "\">" ;
                echo "<tr><td>" .  $num_access . "</td>\n<td>" . $survol . trim($title) . "</a></td>\n<td>" . $survolauthor . $authors[0] . ", ... , " . end($authors) . "</a></td>\n<td>" . $check . "</td></tr>\n" ;
            }
            $i++;
        }
        echo "</tbody></table>";
        echo "<p><input type='submit' id = 'insert' value='Insert'></p>";

    }
    else
    {
        header("Location:./form.php");
        echo "<p>Merci de remplir un champ demandés </p>";
        
    }
    $_SESSION["list_articles"] = $list_objects;
    //var_dump($_SESSION["list_articles"]);

?>
        <script>
            var listNumAccessDb = <?php echo json_encode($list_num_access_already_present); ?>;
        </script>
    <script src="./modif_table_requete.js"></script> 
    <script src="../trie_table_statut/table_sort.js"></script> 
<?php 
    include('../views/footer.php');
?>
