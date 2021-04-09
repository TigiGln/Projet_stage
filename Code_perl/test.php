<!DOCTYPE html>
<html lang="fr">
	<head>
	
	</head>
	<body>
		<?php
			$perl = "/var/www/html/Projet_stage/Code_perl/outils_recherche_pmid.pl ";
			$PMID = "test.txt";
			$var = exec("perl $perl $PMID", $output, $status);
			var_dump($output);
			
			echo 
			
		?>
	</body>
</html>
