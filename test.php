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
			
			$listpmid = array(31198441, 32308737, 33281068);
			$i = 0;
			while ($i < count($listpmid))
			{
				$base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=1&usehistory=y&term=';
				$pmid = $listpmid[$i];
				$search = file_get_contents($base.$pmid);
				$search = new SimpleXMLElement($search);
				#var_dump($search);
				$web_env = $search->WebEnv;
				echo $web_env;
				$base1 = "http://www.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?rettype=abstract&retmode=xml&db=Pubmed&query_key=1&WebEnv=" . $web_env;
				$url = $base1 . "&usehistory=y&term=" . $pmid;
				$output = file_get_contents($url);
				$output1 = new SimpleXMLElement($output);
				#var_dump($output1);
				$pmid1 = $output1->PubmedArticle->MedlineCitation->PMID;
				echo "<p> PMID: " . $pmid1 . "</p>";
				$journal = $output1->PubmedArticle->MedlineCitation->Article->Journal->Title;
				echo "<p> Journal: " . $journal . "</p>";
				$title = $output1->PubmedArticle->MedlineCitation->Article->ArticleTitle;
				echo "<p> Titre: " . $title . "</p>";
				$doi = $output1->PubmedArticle->MedlineCitation->Article->ELocationID;
				echo "<p> DOI: " . $doi . "</p>"; 
				$abstract = "";
				foreach ($output1->PubmedArticle->MedlineCitation->Article->{'Abstract'}->AbstractText as $charac)
					{
						$abstract .= $charac;
					}
				echo "<p> Résumé: " . $abstract . "</p>";
				$authorslist = array();
				foreach ($output1->PubmedArticle->MedlineCitation->Article->AuthorList->Author as $name)
					{
						$authorslist[] = "'" . $name->LastName . " " . $name->ForeName . "'";
					}
				echo "<p> Auteurs: ";
				var_dump($authorslist);
				echo "</p>";
				$year = $output1->PubmedArticle->MedlineCitation->Article->Journal->JournalIssue->PubDate->Year;
				echo "<p> Année de Publication: " . $year . "</p>";
				$i = $i + 1;
 			}
		?>
	</body>
</html>
