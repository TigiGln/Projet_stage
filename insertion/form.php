<?php
    
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "requete.php";
?>
<?php
    include('../views/header.php');
    $menu = new mainMenu('Insertion');
    $menu->write();
?>
<div class="flex p-4 w-100 overflow-auto" style="height: 100vh;">
        <h1>Insertion</h1>
        <!-- Création du formulaire de requête sur Pubmed -->
        <form method="get" action="result.php" enctype="multipart/form-data">
            <!-- Menu select pour sélectionner notre sujet de requête -->
            <select name="list_query" id="list_query">
                <option value="">--Please choose an option--</option>
                <option value="PMID">PMID</option>
                <option value="ELocationID">DOI</option>
                <option value="Author">Author</option>
                <option value="Title">Title</option>
                <option value="dp">Year</option>
            </select>
            <br><br>
            <p>
                <!-- zone de saisi des éléments de requête -->
                <textarea name="textarea" id="textarea" cols="50" rows="4"></textarea>
            </p>
            <br>
            <!--<p>
                <label for="file">My file</label>
                <input type="file" name="myfile" id="file" accept=".txt">
            </p>-->
            <p>
                <input type="submit" value="Start search" id="submit">
            </p>
            <br>
        </form>
        <script src="../insertion/gestion_form.js"></script><!-- import du script javascript pour la gestion des arguments donnée par l'utilisateur selon le critère choisi -->
</div>
<?php
          
    include('../views/footer.php');
?>