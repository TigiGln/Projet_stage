<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Page d'insertion</title>
    </head>
    <body>
		<form method="post" action="insertion.php">
			<p>
				<legend>Votre insertion</legend> <!-- Titre du fieldset -->
					<p>
						<input type="radio" name="insertion" value="PMID" id="Pmid"/> <label for="Pmid">PMID</label><br>
						<textarea name="insertion_pmid" id="insertion" cols="40" rows="4"></textarea><br>
						<label for="file"></label><br>
						<input type="file" name="insertion_file" value="insertion_file" id="file" /><br>
					</p>
					<p>
						<input type="radio" name="insertion" value="Requete" id="Requete" /><label for="Requete">Requête</label><br>
						<label for="requete"></label><br>
						<input type="text" name="insertion_requete" id="requete" /><br>
					</p>
				</fieldset>
			
			</p>
			<p>
				<input type="submit" value="Lancer la recherche" />
			</p>
			<?php
				if (isset($_POST['insertion']) AND $_POST['insertion'] == "PMID") #test si on a bien coché PMID
				{ 
					if (isset($_POST["insertion_pmid"]) OR isset($_FILES["insertion_file"]))#test si l'un des champs existe pour continuer
					{
						if ($_POST["insertion_pmid"] == "" AND $_FILES["insertion_file"]["size"] == 0)#test si le champs textarea ou le fichier est vide
						{
							echo "Merci d'écrire des PMIDs ou de charger un fichier en contenant!";
						}
						else
						{
							$listpmid = explode("\n", $_POST["insertion_pmid"]); 
							var_dump($listpmid);
						}
					}
				}
				else #Si Requete est coché
				{
					if(isset($_POST["insertion_requete"])) #test si input text existe 
					{
					
					}
				}
			?>
	</body>
</html>

