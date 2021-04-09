<!DOCTYPE html>
<html lang="fr">
	<head>
	
	</head>
	<body>
	<!--	<?php
			/*$perl = "/var/www/html/Projet_stage/Code_perl/outils_recherche_pmid.pl ";
			$PMID = "test.txt";
			$var = exec("perl $perl $PMID", $output, $status);
			echo $output[1] . "\n";
			foreach($output as $key => $value)
			{
				echo '<br>[' . $key . '] = ' . $value;
			}*/
			
		?> -->
		<?php
			$base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=1&usehistory=y&term=';
			$pmid = '31198441';
 			$search = file_get_contents($base.$pmid);
 			$search = new SimpleXMLElement($search);
 			#var_dump($search);
 			echo "\n";
 			$web_env = $search->WebEnv;
 			#echo $web_env . "\n";
 			
 			
 			$base1 = "http://www.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?rettype=abstract&retmode=xml&db=Pubmed&query_key=1&WebEnv=" . $web_env;
 			$url = $base1 . "&usehistory=y&term=" . $pmid;
 			$output = file_get_contents($url);
 			$output1 = new SimpleXMLElement($output);
 			#var_dump($output1);
 			$pmid1 = $output1->PubmedArticle->MedlineCitation->PMID;
 			echo $pmid1;
 			
		?>
	</body>
</html>
