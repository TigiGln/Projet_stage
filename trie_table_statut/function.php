<?php
function gestion_select($name, $value_a_tester, $list_value_listbox)
{
    $listbox = "";
    $listbox .= "<select name= '$name'>";
    foreach($list_value_listbox as $value)
    {
        if ($value == $value_a_tester)
        {
            $listbox .= "<option value=$value selected>" . ucfirst($value) . "</option>";
        }
        else
        {
            $listbox .= "<option value=$value>" . ucfirst($value) . "</option>";
        }
    }
    $listbox .= " </select>";

    return $listbox;

}


function search_table_statut($statut)
{
    $manager = new Manager($_SESSION["connexionbd"]->pdo);#création de l'objet permettant d'agir sur la base de données
    $enum_statut = $manager->search_enum_fields('document', 'statut');
    $table_a_afficher = $manager->get_fields('statut', $statut);#requête sur la table de la base de données en fonction du statut
    $list_pmid_selon_statut = [];#création d'une liste artificiel des statut initial de chaque ligne.
    $enum_user = ['Nicolas', 'Elodie', 'Vincent', 'Marie-Line'];
    $list_user = gestion_select('user_article', "Elodie", $enum_user);
    echo "<h1>Table " . str_replace("_", " ",$statut)."</h1>";
    echo "<table><tr><th>PMID</th><th>Title</th><th>Statut</th><th>User</th></tr>";
    foreach($table_a_afficher as $line_table)#création du tableau à afficher ligne par ligne en fonction du statut demandés
    {
        $pmid = $line_table["pub_db_acc"];
        $name_id = 'statut_' . $pmid;
        $list_statut = gestion_select($name_id, $statut, $enum_statut);
        $lien_pubmed  = "<a href ='https://pubmed.ncbi.nlm.nih.gov/$pmid/' target='_blank'>";
        $survol_title = '<a style="border-style: double;" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content= "' . $line_table["abstract"] . '">';
        echo "<tr><td>" . $lien_pubmed .  $pmid . "</a></td><td>" . $survol_title . $line_table["title"] . "</a></td><td>" . $list_statut . "</td><td>" . $list_user . "</td></tr>" ;
        $list_pmid_selon_statut[$name_id] = $statut;
            
    }
    echo "</table>";
    return $list_pmid_selon_statut;
}



?>