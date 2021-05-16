<?php
//Création du menu déroulant avec le selected au bon endroit et les options souhaités.
function gestion_select($name, $value_a_tester, $id, $list_value_listbox, $tags)
{
    if(strpos(".".$value_a_tester, "members_tasks")) { $value_a_tester = "tasks"; } 
    else if(strpos(".".$value_a_tester, "members_undefined")) {$value_a_tester = "undefined"; } 
    
    $listbox = "";
    $listbox .= "<select class='form-select' name= '$name' id = '$id' onchange='changeStatus(this)' ".$tags.">";
    foreach($list_value_listbox as $value)
    {
        if (strtolower($value) == strtolower($value_a_tester))
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
    if($status == 'undefined' OR $status =='tasks')
    {
        #requête sur la table de la base de données en fonction du status et de l'utilisateur
        $table_a_afficher = $manager->get_fields('article', 'status', 'user', 'name_status', $status, 'name_user', $user);
    }
    else if($status == 'members_tasks')
    {
        $table_a_afficher = $manager->get_fields_join('article', 'status', 'user', 'name_status', "tasks");
    } 
    else if($status == 'members_undefined')
    {
        $table_a_afficher = $manager->get_fields_join('article', 'status', 'user', 'name_status', "undefined");
    } 
    else
    {
        #requête sur la table de la base de données en fonction du status
        $table_a_afficher = $manager->get_fields_join('article', 'status', 'user', 'name_status', $status);
    }
    $list_pmid_selon_status = [];#création d'une liste artificiel des statut initial de chaque ligne.
    
    #création du tableau à afficher ligne par ligne en fonction du statut demandés et de l'utilisateur
    echo "<h1>" . str_replace("_", " ",$status)." articles</h1>";
    if ($status == 'tasks')
    {
        echo "<table class='table table-responsive table-hover table-bordered'><thead><tr class='table-info'><th class='sortable' width=12.5%>PMID</th><th class='sort_column'>Title <i class='bi bi-archive'></i></th><th class='sort_column' width=20%>Authors</th><th width=12.5%>Status</th><th width=12.5%>User</th><th width=12.5%>Notes</th></tr></thead><tbody>";
    }
    else
    {
        echo "<table class='table table-responsive table-hover table-bordered'><thead><tr class='table-info'><th class='sortable' width=12.5%>PMID</th><th class='sort_column'>Title</th><th class='sort_column' width=20%>Authors</th><th width=12.5%>Status</th><th width=12.5%>User</th></tr></thead><tbody>";
    }
    foreach($table_a_afficher as $line_table)
    {
        if(($status == "members_tasks" || $status == "members_undefined") && $line_table['name_user'] == $_SESSION['username']) continue;
        $origin = $line_table["origin"];
        $num_access = $line_table["num_access"];
        $name_id_status = 'status_' . $num_access;
        $name_id_user = 'user_'. $num_access;
        $user_name = $line_table['name_user'];

        $tagsStatut = (strpos(".".$status, "members_") || $line_table["name_user"] != $_SESSION["username"]) ? "disabled" : "";
        $tagsUser = ((strpos(".".$status, "members_") || strpos(".".$status, "processed") || strpos(".".$status, "rejected")) && $line_table["name_user"] != $_SESSION["username"]) ? "disabled" : "";

        $list_status = gestion_select($name_id_status, $status, $num_access, $enum_status, $tagsStatut);//création du menu déroulant des status
        $list_user = gestion_select($name_id_user, $user_name, $num_access, $enum_user, $tagsUser);//création du menu déraoulant des users
        $abstract =  str_replace('"', "'", $line_table['abstract']);
        $title = str_replace('"', "'", $line_table['title']);
        $lien_pubmed  = "<a href ='https://pubmed.ncbi.nlm.nih.gov/$num_access/' target='_blank'>";
        $toolLink = ($status == 'tasks' || $status == 'rejected' || $status == 'processed') ? 'target="_BLANK" href="../tools/readArticle.php?NUMACCESS='.$num_access.'&ORIGIN='.$origin.'"' : '';
        $survol_title = '<a '.$toolLink.' style = "color: #000; font-weight: bold;" class="note" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-trigger="hover focus" data-bs-content="' . $abstract . '">';
        if ($status == 'tasks')
        {   
            if(!class_exists("SaveLoadStrategies")) { require('../POO/class_saveload_strategies.php'); }
            $load = new SaveLoadStrategies("..", $manager);
            $res = json_decode($load->loadAsXML("../modules/edit_article_menu/notes/notes.xml", $line_table["origin"]."_".$line_table["num_access"], "author", $_SESSION['username']), true);
            $notes = ($res == 400) ? $notes = "" : urldecode($res[0]['content']);
            echo "<tr id = 'line_$num_access'><td width=12.5%>" . $lien_pubmed .  $num_access . "</a></td><td width=30%>" . $survol_title . $title . "</a></td><td width= 20%>premier et dernier auteur</td><td width=12.5%>" . $list_status . "</td><td width=12.5%>" . $list_user . "</td><td width=12.5%>" . $notes . "</td></tr>" ;
        }
        else
        {
            echo "<tr id = 'line_$num_access'><td width=12.5%>" . $lien_pubmed .  $num_access . "</a></td><td width=30%>" . $survol_title . $title . "</a></td><td width= 20%>premier et dernier auteur</td><td width=12.5%>" . $list_status . "</td><td width=12.5%>" . $list_user . "</td></tr>" ; 
        }
        $list_pmid_selon_status[$name_id_status] = $status;       
    }
    echo "</tbody></table>";
    //echo "<p><input type='submit' value='Enregistrer' id='submit'></p>";
    return $list_pmid_selon_status;
}



?>