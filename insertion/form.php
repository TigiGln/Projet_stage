<?php
    
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "request.php";
?>
<?php
    include('../views/header.php');
    $menu = new MainMenu('Insertion', $manager);
    $menu->write();
?>
<div class="flex p-4 w-100 overflow-auto" style="height: 100vh;">
    <h1>Insertion</h1>
    <div>
        <!-- Création du formulaire de requête sur Pubmed -->
        <form method="get" action="result.php" enctype="multipart/form-data">
            <!-- Menu select pour sélectionner notre sujet de requête -->
            <div class="form-group pb-4">
                <select name="list_query" id="list_query" class="form-select w-25" > 
                    <option value="">--Please choose an option--</option>
                    <option value="PMID">PMID</option>
                    <option value="ELocationID">DOI</option>
                    <option value="Author">Author</option>
                    <option value="Title">Title</option>
                    <option value="dp">Year</option>
                </select>
            </div>
            <div class="form-group pb-4">
                <!-- zone de saisi des éléments de requête -->
                <textarea name="textarea" id="textarea" rows="4" class="form-control w-25" ></textarea>
            </div>
            <!--<p>
                <label for="file">My file</label>
                <input type="file" name="myfile" id="file" accept=".txt">
            </p>-->
            <div class="form-group pb-4">
                <input class="btn btn-outline-success" type="submit" value="Start search" id="submit">
            </div> 
            <br>
        </form>
    </div>
    <script src="./gestion_form.js"></script><!-- import du script javascript pour la gestion des arguments donnée par l'utilisateur selon le critère choisi -->
</div>
<?php
          
    include('../views/footer.php');
?>