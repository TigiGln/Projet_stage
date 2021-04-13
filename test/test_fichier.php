<!DOCTYPE html >
<html lang="fr">
	<head>
        	<meta charset="utf-8" />
        	<title>Page de recherche d'article</title>
    	</head>
    	<body>
		<form method="POST" action="test_fichier.php" enctype="multipart/form-data">
			<p>
				<input type="file" name="monfichier" /><br />
			</p>
			<p>
				<input type="submit" value="Lancer la recherche" />
			</p>
		</form>
		<?php
		if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error'] == 0)
		{
			echo "Le fichier existe <br>";
			$taille = $_FILES["monfichier"]["size"];
			$name = $_FILES["monfichier"]["tmp_name"];
			echo $name . "<br>";
			$file = fopen($name, "r");
			$lines = rtrim(fread($file, $taille));
			$listpmid = explode("\n", $lines);
			var_dump($listpmid);
		}
		
		?>
	</body>
</html>
