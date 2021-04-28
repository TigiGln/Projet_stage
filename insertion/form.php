<?php
    
    require "../POO/class_main_menu.php";
    require "../POO/class_connexion.php";
    require "../POO/class_manager_bd.php";
    require "requete.php";
?>
<?php
    include('../views/header.php');
    $_SESSION['connexion'] = 'John Doe';
    $menu = new mainMenu('My Tasks');
    $menu->write();
?>
        <form method="get" action="result.php" enctype="multipart/form-data">
            <select name="list_query" id="list_query">
                <option value="">--Please choose an option--</option>
                <option value="PMID">PMID</option>
                <option value="ELocationID">DOI</option>
                <option value="Author">Author</option>
                <option value="Title">Title</option>
                <option value="dp">Year</option>
            </select>
            <p>
                <textarea name="textarea" id="textarea" cols="50" rows="4"></textarea>
            </p>
            <!--<p>
                <label for="file">My file</label>
                <input type="file" name="myfile" id="file" accept=".txt">
            </p>-->
            <p>
                <input type="submit" value="Start search" id="submit">
            </p>
        </form>
        <script src="../insertion/gestion_form.js"></script>
<?php
          
    include('../views/footer.html');
?>