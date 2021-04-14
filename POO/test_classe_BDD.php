<?php
	require "class_article.php";
	require "class_manager.php";
	include("../../../Projet_stage/connexion.php");
	$liste_objet = [];
	// On admet que $db est un objet PDO.
	$request = $bdd->query('SELECT pmid, doi, pmcid, title, years, abstract, authors, journal FROM Articles');
	
	while ($donnees = $request->fetch(PDO::FETCH_ASSOC)) // Chaque entrée sera récupérée et placée dans un array.
	{
	  // On passe les données (stockées dans un tableau) concernant le personnage au constructeur de la classe.
	  // On admet que le constructeur de la classe appelle chaque setter pour assigner les valeurs qu'on lui a données aux attributs correspondants.
	  $article = new Article($donnees);
	  $liste_objet[] = $article;

	  echo "<p>L'artcle avec le PMID N° " . $article->pmid() . ' et le DOI N° ' . $article->doi() . ' ainsi que le PCMID N° ' . $article->pmcid() . ' a pour titre  ' . $article->title() . ' publié en ' . $article->years() . " dans " . $article->journal() . ".";
	  echo " <br>Son résumé: " . $article->abstract() . " et il est écrit par: " . $article->authors()  . ". </p>"; 
	}
	$liste_info = [
		"pmid" => "32308737",
		"doi" => "10.1186/s13068-020-01709-9",
		"pmcid" => "PMC7151638",
		"title" => "Investigation of a thermostable multi-domain xylanase-glucuronoyl esterase enzyme from incorporating multiple carbohydrate-binding modules",
		"years" => "2020",
		"abstract" => "Efficient degradation of lignocellulosic biomass has become a major bottleneck in industrial processes which attempt to use biomass as a carbon source for the production of biofuels and materials. To make the most effective use of the source material, both the hemicellulosic as well as cellulosic parts of the biomass should be targeted, and as such both hemicellulases and cellulases are important enzymes in biorefinery processes.",
		"authors" => "'Krska Daniel','Larsbrink Johan'",
		"journal" => "Biotechnology for biofuels"
		];
	

	$requete = $bdd->query("SELECT pmid FROM Articles WHERE pmid = " . $liste_info["pmid"]);
	$pmid_exist = $requete->fetch();
	if (empty($pmid_exist))
	{
		$article3 = new Article($liste_info);
		$liste_objet[] = $article3;
		echo "<p>L'artcle avec le PMID N° " . $article3->pmid() . ' et le DOI N° ' . $article3->doi() . ' ainsi que le PCMID N° ' . $article3->pmcid() . ' a pour titre  ' . $article3->title() . ' publié en ' . $article3->years() . " dans " . $article3->journal() . ".";
    	echo " <br>Son résumé: " . $article3->abstract() . " et il est écrit par: " . $article3->authors()  . ". </p>";
		$manager = new Manager($bdd);
		$manager->add($article3);
	}
	$str = serialize($liste_objet);
	echo ">p>" . $str . "</p>";
	var_dump(unserialize($str));
	#var_dump($liste_objet);
?>