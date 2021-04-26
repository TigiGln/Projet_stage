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
 			$output = new SimpleXMLElement($output);
 			#var_dump($output);
 			//Recuperation structurer des elements de l'article:
 			$pmid = $output->PubmedArticle->MedlineCitation->PMID;
 			$date = $output->PubmedArticle->MedlineCitation->DateRevised->Year . "/" . $output->PubmedArticle->MedlineCitation->DateRevised->Month . "/" . $output->PubmedArticle->MedlineCitation->DateRevised->Day;
			$title = $output->PubmedArticle->MedlineCitation->Article->Journal->Title;
			//Boucle for sur les abstractText
			$abstract = "";
			foreach ($output->PubmedArticle->MedlineCitation->Article->Abstract->AbstractText as $abstractText) {
				$abstract = $abstract . "<br><b>" . $abstractText["Label"] . ":</b> " . $abstractText;
			}
			//Boucle for sur les author
			$authors = "";
			foreach ($output->PubmedArticle->MedlineCitation->Article->AuthorList->Author as $author) {
				$authors = $authors . $author->LastName . " " . $author->ForeName . ", ";
			}
			//Affichage des données sale
			echo $pmid . "<br>" . $date . "<br>" . $title . "<br><br>" . 
				$abstract . "<br><br>" . $authors;
		?>
	</body>
</html>
