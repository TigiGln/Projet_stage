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
        <form method="get" action="insert.php" enctype="multipart/form-data">
            <?php
                require "class_article_simple.php";
                require "requete.php";
                include("../POO/start_session.php");
                $pmid = "";
                $listpmid = [];
                $list_objects = [];
                if (isset($_GET["pmid"]) AND $_GET["pmid"] != "")
                {
                    $pmid = strip_tags($_GET["pmid"]);
                    $listpmid = explode("\n", $pmid);
                    #var_dump($listpmid);          
                }
                else
                {
                    echo "Merci de remplir le champs PMID";
                }
                if ($listpmid != "")
                {
                    echo "<h1>Table of our research</h1>";
                    $global_check = "<input type='checkbox' name = 'global_check' onclick = 'check(this)'>";
                    echo "<p><table><tr><th>PMID</th><th>Title</th><th>" . $global_check . "</th></tr>";
                    $i = 0;
                    while($i < count($listpmid))
                    {
                        $output = search($listpmid, $i);
                        $list_info = recovery($output);
                        $pmid1 = $list_info[0];
                        $title = $list_info[1];
                        $abstract = $list_info[2];
                        $object_article = new ArticleSimple($pmid1, $title, $abstract);
                        $list_objects[$pmid1] = $object_article;
                        $check = "<input type='checkbox' name='check[]' value= '" . $object_article . "'>";
                        $survol = '<a style="border-style: double;" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content= "' . $object_article->abstract() . '">';
                        echo "<tr><td>" .  $object_article->pmid() . "<br>" . "</td><td>" . $survol . $object_article->title() . "</a></td><td>" . $check . "</td></tr>" ;
                        echo "</p>";
                        $i++;
                    }
                    echo "</table> </p>";

                }
                else
                {
                    echo "Merci de rentrer le champ demandés";
                }
                $_SESSION["liste"] = $list_objects;
                var_dump($_SESSION["liste"]);
            ?>
            <script>
                        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                        var popoverList = popoverTriggerList.map
                        (function (popoverTriggerEl) 
                        {
                        return new bootstrap.Popover(popoverTriggerEl)
                        }
                        )
                    function check(source) 
                    {
                        checkboxes = document.querySelectorAll("input[name^='check']");
                        for(var i=0, n=checkboxes.length;i<n;i++) {
                        checkboxes[i].checked = source.checked;
                        }
                    }
            </script>
            <p>
                <input type="submit" value="Insert">
            </p>
        </form>
    </body>
</html>
