<!DOCTYPE html >
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Page de résultat de recherche</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="result.css" />
    </head>
    <body>
        <?php
        require "class_manager_simple.php";
        include("../POO/start_session.php");

        $manager = new Manager($_SESSION["connexion"]->pdo);

        $table = $manager->get_statut("undefined");

        #print_r($table[0]["pmid"]);
        $statut = "<select name='list_statut' id='list_statut'>
                        <option value='undefined'>Undefined</option>
                        <option value='to treat'>To treat</option>
                        <option value='treated'>Treadted</option>
                        <option value='rejeted'>Rejeted</option>
                    </select>";
        echo "<h1>Table Undefined</h1>";
        echo "<table><tr><th>PMID</th><th>Title</th><th>Statut</th></tr>";
        foreach($table as $line)
        {
            $pmid = $line["pub_db_acc"];
            $lien  = "<a href ='https://pubmed.ncbi.nlm.nih.gov/$pmid/' target='_blank'>";
            $survol = '<a style="border-style: double;" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content= "' . $line["abstract"] . '">';
            echo "<tr><td>" . $lien .  $line["pub_db_acc"] . "</a></td><td>" . $survol . $line["title"] . "</a></td><td>" . $statut . "</td></tr>" ;
        }
        echo "</table>";
        session_destroy();
        ?>
        <script>
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map
            (function (popoverTriggerEl) 
            {
                return new bootstrap.Popover(popoverTriggerEl)
            }
            )
        </script>
    </body>
</html>
