<?php
//Création du menu déroulant avec le selected au bon endroit et les options souhaités.
function gestion_select($name, $value_a_tester, $id, $list_value_listbox)
{
    //onchange = changeStatus(this)
    $listbox = "";
    $listbox .= "<select name= '$name' id = '$id' onchange = changeStatus(this)>";
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

//fonction d'affichage de la table en fonction du statut souhaité.
function search_table_status($status)
{
    $manager = new Manager($_SESSION["connexionbd"]->pdo);#création de l'objet permettant d'agir sur la base de données
    $enum_status = $manager->search_enum_fields('article', 'status');
    $table_a_afficher = $manager->get_fields('status', $status);#requête sur la table de la base de données en fonction du statut
    $list_pmid_selon_status = [];#création d'une liste artificiel des statut initial de chaque ligne.
    $enum_user = ['Nicolas', 'Elodie', 'Vincent', 'Marie-Line', 'Pedro'];//utilisateur artificiel pour l'instant
    $list_user = gestion_select('user_article', "Elodie", 'user',$enum_user);// création du menu déroulant des utilisateurs
    echo "<h1>Table " . str_replace("_", " ",$status)."</h1>";
    echo "<table><tr><th>PMID</th><th>Title</th><th>Status</th><th>User</th></tr>";
    foreach($table_a_afficher as $line_table)#création du tableau à afficher ligne par ligne en fonction du statut demandés
    {
        $num_access = $line_table["num_access"];
        $name_id = 'status_' . $num_access;
        $list_status = gestion_select($name_id, $status, $num_access, $enum_status);
        $lien_pubmed  = "<a href ='https://pubmed.ncbi.nlm.nih.gov/$num_access/' target='_blank'>";
        $survol_title = '<a style="border-style: double;" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content= "' . $line_table["abstract"] . '">';
        echo "<tr id = line_$num_access><td>" . $lien_pubmed .  $num_access . "</a></td><td>" . $survol_title . $line_table["title"] . "</a></td><td>" . $list_status . "</td><td>" . $list_user . "</td></tr>" ;
        $list_pmid_selon_status[$name_id] = $status;
        
            
    }
    echo "</table>";
    //echo "<p><input type='submit' value='Enregistrer' id='submit'></p>";
    return $list_pmid_selon_status;
}



?>