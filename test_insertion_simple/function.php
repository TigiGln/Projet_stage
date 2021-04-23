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
    $table_a_afficher = $manager->get_statut($statut);#requête sur la table de la base de données en fonction du statut
    $list_pmid_selon_statut = [];#création d'une liste artificiel des statut initial de chaque ligne.
    $list_user = "<select name='user_article'  id='user_article'>
                    <option value='Nicolas'>Nicolas</option>.
                    <option value='Elodie'>Elodie</option>.
                    <option value='Vincent'>Vincent</option>.
                    <option value='Marie-Line'>Marie-Line</option>
                </select>";

    echo "<h1>Table " . str_replace("_", " ",$statut)."</h1>";
    echo "<table><tr><th>PMID</th><th>Title</th><th>Statut</th><th>User</th></tr>";
    foreach($table_a_afficher as $line_table)#création du tableau à afficher ligne par ligne en fonction du statut demandés
    {
        $pmid = $line_table["pub_db_acc"];
        $name_id = 'statut_' . $pmid;
        $list_statut = gestion_select($name_id, $statut, $enum_statut);
        /*
        $list_statut ="<select name= '$name_id' id='$pmid'>
                    <option value='undefined'>Undefined</option>
                    <option value='to treat'>To treat</option>
                    <option value='treat' >Treat</option>
                    <option value='reject' selected>Reject</option>
                </select>";
        if ($statut == "undefined")
        {
            $list_statut = "<select name='$name_id' id='$pmid'>
                            <option value='undefined' selected>Undefined</option>
                            <option value='to_treat'>To treat</option>
                            <option value='treat'>Treat</option>
                            <option value='reject'>Reject</option>
                        </select>";
        }
        elseif($statut == "to_treat")
        {
            $list_statut =   "<select name='$name_id' id='$pmid'>
                            <option value='undefined'>Undefined</option>
                            <option value='to_treat'selected>To treat</option>
                            <option value='treat'>Treat</option>
                            <option value='reject'>Reject</option>
                        </select>";
        }
        elseif($statut == "treat")
        {
            $list_statut =   "<select name='$name_id' id='$pmid'>
                            <option value='undefined'>Undefined</option>
                            <option value='to_treat'>To treat</option>
                            <option value='treat' selected>Treat</option>
                            <option value='reject'>Reject</option>
                        </select>";
        }
        */
        $lien_pubmed  = "<a href ='https://pubmed.ncbi.nlm.nih.gov/$pmid/' target='_blank'>";
        $survol_title = '<a style="border-style: double;" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content= "' . $line_table["abstract"] . '">';
        echo "<tr><td>" . $lien_pubmed .  $pmid . "</a></td><td>" . $survol_title . $line_table["title"] . "</a></td><td>" . $list_statut . "</td><td>$list_user</td></tr>" ;
        $list_pmid_selon_statut[$name_id] = $statut;
            
    }
    echo "</table>";
    return $list_pmid_selon_statut;
}



?>