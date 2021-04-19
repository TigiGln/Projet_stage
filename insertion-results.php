<?php
include('./views/header.html');

//Security for now: if the cookie isn't set
$menu = 'insert'; //To save where we are so the menu can add the active tag
//Menu
include('./views/menu.php');
?>

<div class="p-4 w-100">
	<?php include("connexion.php"); ?>
	echo 'aaa';
	<form method="post" action="#" enctype="multipart/form-data">
		<?php
			$dico_articles = array();
			if (isset($_POST["insert_text"]) OR isset($_FILES["myfile"]))#test si l'un des champs existe pour continuer
			{
				if ($_POST["insert_text"] == "" AND $_FILES["myfile"]["error"] != 0)
				{
					header('Location: insertion.php');
					echo "Please fill in one of the fields correctly";
				}
				else
				{
					echo '<a href="insertion.php">Back to insert page</a>';
					echo "<h1>Table of our research</h1>";
					?>
						<input type="submit" value="Insertion" id ="insertion"/>
					<?php
					$liste_check = array();
					$global_check = "<input type='checkbox' name = 'global_check' onclick = 'check(this)'>";
					echo "<p><table><tr><th>PMID/DOI/Year/Scientific Journal</th><th>Title</th><th>" . $global_check . "</th></tr>";
					$listpmid = array();
					if ($_POST['list_query'] == "PMID" OR $_POST['list_query'] == "ELocationID")
					{
						if ($_POST["insert_text"] != "")
						{
							$ID = rtrim($_POST["insert_text"]);
							$listpmid = explode("\n", $ID);
							#var_dump($listpmid);
							#$listpmid = array(31198441, 32308737, 33281068);
						}
						else
						{	

							$size = $_FILES["myfile"]["size"];
							$name = $_FILES["myfile"]["tmp_name"];
							$file = fopen($name, "r");
							$lines = rtrim(fread($file, $size));
							$listpmid = explode("\n", $lines);

						}
					}
					else
					{
						$base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&usehistory=y&term=';
						$text = urlencode(rtrim($_POST["insert_text"]));
						$search_pmid = file_get_contents($base . $text . "[" . $_POST['list_query'] . "]");
						$search_pmid = new SimpleXMLElement($search_pmid);
						foreach ($search_pmid->IdList->Id as $id)
						{
							$listpmid[] = $id;
						}
					}
					$i = 0;
					while ($i < count($listpmid))
					{
						$base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&usehistory=y&term=';
						$id = trim($listpmid[$i]);
						$search = file_get_contents($base.$id);
						$search = new SimpleXMLElement($search);
						$web_env = $search->WebEnv;
						$base1 = "http://www.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?rettype=abstract&retmode=xml&db=Pubmed&query_key=1&WebEnv=" . $web_env;
						$url = $base1 . "&usehistory=y&term=" . $id;
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
						$authors = "";
						foreach ($output1->PubmedArticle->MedlineCitation->Article->AuthorList->Author as $name)
							{
								$authorslist[] = "'" . $name->LastName . " " . $name->ForeName . "'";
								$authors .= "'" . $name->LastName . " " . $name->ForeName . "',";
							}
						$year = $output1->PubmedArticle->MedlineCitation->Article->Journal->JournalIssue->PubDate->Year;
						echo "<p>";
						$check = "<input type='checkbox' name='check_insertion[]' value= '" . $pmid1 . "'>";
						$liste_check[] = $check;
						$survol = '<a style="border-style: double;" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content= "' . $abstract . '">';
						echo "<tr><td>" .  $pmid1 . "<br>" . $doi . "<br>" . $year . "<br>" . $journal . "</td><td>" . $survol . $title . "</a></td><td>" . $check . "</td></tr>" ;
						echo "</p>";
						$list_info = array($doi, $year, $title, $abstract, $journal);
						$dico_articles[$id] = $list_info;

						$i++;
					}
					echo "</table> </p>";
					#var_dump($listpmid);
					foreach ($dico_articles as $key => $value)
					{
						echo "<p>" . $key . " => [";
						foreach ($value as $id => $elem)
						{
							echo $elem . ", ";
						}

						echo "]</p>";
					}
				}
			}
		#var_dump($dico_article);
		if (isset($_POST["check_insertion"]))
		{
			echo "insertion dans la base de données de: <br>";
			foreach ($_POST["check_insertion"] as $valeur)
			{
				if (!empty($valeur))
				{
					//$insertion_articles = $bdd->query("INSERT INTO articles(pmid, doi, title, year)VALUES($valeur, $dico_article[$valeur][0], $dico_article[$valeur][2], $dico_article[$valeur][1])");
					echo $valeur . "<br>";

				}
			}
		
		}	
		?>
	</form>
</div>

<?php
include('./views/footer.html');
?>