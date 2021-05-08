<?php
//Création du menu déroulant avec le selected au bon endroit et les options souhaités.
function gestion_select($name, $value_a_tester, $id, $list_value_listbox)
{
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
function search_table_status($status, $user, $manager)
{
    $enum_status = $manager->search_enum_fields('status', 'article', 'name_status', 'status');
    $enum_user = $manager->search_enum_fields('user', 'article', 'name_user', 'user');
    $table_a_afficher = "";
    if($status == 'undefined' OR $status =='to_treat')
    {
        #requête sur la table de la base de données en fonction du status et de l'utilisateur
        $table_a_afficher = $manager->get_fields('article', 'status', 'user', 'name_status', $status, 'name_user', $user);
    }
    else
    {
        #requête sur la table de la base de données en fonction du status
        $table_a_afficher = $manager->get_fields_join('article', 'status', 'user', 'name_status', $status);
    }
    $list_pmid_selon_status = [];#création d'une liste artificiel des statut initial de chaque ligne.
    
    #création du tableau à afficher ligne par ligne en fonction du statut demandés et de l'utilisateur
    echo "<h1>Table " . str_replace("_", " ",$status)."</h1>";
    if ($status == 'to_treat')
    {
        echo "<table class='table table-responsive table-hover table-bordered'><tr class='table-info'><th width=12.5%>PMID</th><th onclick = alphaSort(this)>Title</th><th width=20%>Authors</th><th width=12.5%>Status</th><th width=12.5%>User</th><th width=12.5%>Notes</th></tr>";
    }
    else
    {
        echo "<table class='table table-responsive table-hover table-bordered'><tr class='table-info'><th width=12.5%>PMID</th><th width=30% onclick =alphaSort(this)>Title</th><th width=20%>Authors</th><th width=12.5%>Status</th><th width=12.5%>User</th></tr>";
    }
    foreach($table_a_afficher as $line_table)
    {
        $origin = $line_table["origin"];
        $num_access = $line_table["num_access"];
        $name_id_status = 'status_' . $num_access;
        $name_id_user = 'user_'. $num_access;
        $user_name = $line_table['name_user'];
        $notes = $line_table['general_note'];
        if (empty($notes))
        {
            $notes = 'No notes available';
        }
        $list_status = gestion_select($name_id_status, $status, $num_access, $enum_status);//création du menu déroulant des status
        $list_user = gestion_select($name_id_user, $user_name, $num_access, $enum_user);//création du menu déraoulant des users
        $abstract =  str_replace('"', "'", $line_table['abstract']);
        $title = str_replace('"', "'", $line_table['title']);
        $lien_pubmed  = "<a href ='https://pubmed.ncbi.nlm.nih.gov/$num_access/' target='_blank'>";
        $toolLink = ($status == 'to_treat') ? 'target="_BLANK" href="../readArticle.php?NUMACCESS='.$num_access.'&ORIGIN='.$origin.'"' : '';
        $survol_title = '<a '.$toolLink.' style = "color: #000; font-weight: bold;" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="' . $abstract . '">';
        if ($status == 'to_treat')
        {
            echo "<tr id = 'line_$num_access'><td width=12.5%>" . $lien_pubmed .  $num_access . "</a></td><td width=30%>" . $survol_title . $title . "</a></td><td width= 20%>premier et dernier auteur</td><td width=12.5%>" . $list_status . "</td><td width=12.5%>" . $list_user . "</td><td width=12.5%>" . $notes . "</td></tr>" ;
        }
        else
        {
            echo "<tr id = 'line_$num_access'><td width=12.5%>" . $lien_pubmed .  $num_access . "</a></td><td width=30%>" . $survol_title . $title . "</a></td><td width= 20%>premier et dernier auteur</td><td width=12.5%>" . $list_status . "</td><td width=12.5%>" . $list_user . "</td></tr>" ; 
        }
        $list_pmid_selon_status[$name_id_status] = $status;       
    }
    echo "</table>";
    //echo "<p><input type='submit' value='Enregistrer' id='submit'></p>";
    return $list_pmid_selon_status;
}



?>