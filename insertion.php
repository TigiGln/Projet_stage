<!DOCTYPE html >
<html lang="fr">
	<head>
        	<meta charset="utf-8" />
        	<title>Page de recherche d'article</title>
    	</head>
    	<body>
		<form method="post" action="insertion2.php">
			<p>
				<fieldset><legend>Votre recherche pour insertion</legend> <!-- Titre du fieldset -->
					<p>
						<input type="radio" name="insertion" value="PMID" id="Pmid" checked/> <label for="Pmid">PMID</label><br>
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
		</form>
			
	</body>
</html>

