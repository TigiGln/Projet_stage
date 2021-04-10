<!DOCTYPE html >
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Page de résultat de recherche</title>
		<style>
		th
		{
			border: 1px black solid;
			background-color: cyan;
		}
		th:first-child
		{
			border-radius: 10px 0px 0px 0px;
			
		}
		th:last-child
		{
			border-radius: 0px 10px 0px 0px;
		}
		td
		{
			border: 1px black solid;
			padding:0px 50px;
			text-align: center;
		}
		table
		{
			border-collapse: separate;
			border-spacing: 0px ;
			margin-top: 50px;
			
		}
		</style>
    </head>
	<body>
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
						echo "<h1>Tableau de nos Articles recherchés</h1>";
						echo "<table><tr><th>PMID</th><th>DOI</th><th>Année</th><th>Titre</th><th>Journal</th><th>Check</th></tr>";
						$listpmid = explode("\n", $_POST["insertion_pmid"]);
						#var_dump($listpmid);
						#$listpmid = array(31198441, 32308737, 33281068);
						$i = 0;
						while ($i < count($listpmid))
						{
							$base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&retmax=1&usehistory=y&term=';
							$pmid = trim($listpmid[$i]);
							$search = file_get_contents($base.$pmid);
							$search = new SimpleXMLElement($search);
							#var_dump($search);
							$web_env = $search->WebEnv;
							$base1 = "http://www.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?rettype=abstract&retmode=xml&db=Pubmed&query_key=1&WebEnv=" . $web_env;
							$url = $base1 . "&usehistory=y&term=" . $pmid;
							$output = file_get_contents($url);
							$output1 = new SimpleXMLElement($output);
							#var_dump($output1);
							$pmid1 = $output1->PubmedArticle->MedlineCitation->PMID;
							#echo "<p> PMID: " . $pmid1 . "</p>";
							$journal = $output1->PubmedArticle->MedlineCitation->Article->Journal->Title;
							#echo "<p> Journal: " . $journal . "</p>";
							$title = $output1->PubmedArticle->MedlineCitation->Article->ArticleTitle;
							#echo "<p> Titre: " . $title . "</p>";
							$doi = $output1->PubmedArticle->MedlineCitation->Article->ELocationID;
							#echo "<p> DOI: " . $doi . "</p>"; 
							$abstract = "";
							foreach ($output1->PubmedArticle->MedlineCitation->Article->{'Abstract'}->AbstractText as $charac)
								{
									$abstract .= $charac;
								}
							#echo "<p> Résumé: " . $abstract . "</p>";
							$authorslist = array();
							foreach ($output1->PubmedArticle->MedlineCitation->Article->AuthorList->Author as $name)
								{
									$authorslist[] = "'" . $name->LastName . " " . $name->ForeName . "'";
								}
							#echo "<p> Auteurs: ";
							#var_dump($authorslist);
							$year = $output1->PubmedArticle->MedlineCitation->Article->Journal->JournalIssue->PubDate->Year;
							#echo "<p> Année de Publication: " . $year . "</p>";
							
							echo "<p>";
							$check = "<input type='checkbox' name='check' value= " . $pmid1 . "/>";
							echo "<tr><td>" .  $pmid1 . "</td><td>" . $doi . "</td><td>" . $year . "</td><td>" . $title . "</td><td>" . $journal . "</td><td>" . $check . "</td></tr>" ;
							echo "</p>";
							$i = $i + 1;
						}
						echo "</table>";
						#var_dump($listpmid);
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