<?php
class Manager
{
	protected $db; // Instance de PDO.

	public function __construct($db)
	{
		$this->setDb($db);
	}

	public function add(Article $article)
	{
		// Préparation de la requête d'insertion.
		// Assignation des valeurs.
		// Exécution de la requête.
		$requete = $this->db->prepare("INSERT INTO Articles(pmid, doi, pmcid, title, years, abstract, authors, journal) VALUES(:pmid, :doi, :pmcid, :title, :years, :abstract, :authors, :journal)");
		
		$requete->bindValue(":pmid", $article->pmid());
		$requete->bindValue(":doi", $article->doi());
		$requete->bindValue(":pmcid", $article->pmcid());
		$requete->bindValue(":title", $article->title());
		$requete->bindValue(":years", $article->years());
		$requete->bindValue(":abstract", $article->abstract());
		$requete->bindValue(":authors", $article->authors());
		$requete->bindValue(":journal", $article->journal());
		
		$requete->execute();
	}

	public function delete(Article $article)
	{
		// Exécute une requête de type DELETE.
		$this->db->exec("DELETE FROM Articles WHERE $pmid = " . $article->pmid());
	}

	public function get($pmid)
	{
		// Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Article.
		$requete = $this->db->query("SELECT pmid, doi, pmcid, title, years, abstract, authors, journal FROM Articles WHERE pmid = " . $pmid);
		$donnees = $requete->fetch(PDO::FETCH_ASSOC);
		return new Articles($donnees);
		
	}

	public function getList($sort)
	{
		// Retourne la liste de tous les articles trié selon le paramètre donné.
		$article = [];
		$requete = $this->db->query("SELECT pmid, doi, pmcid, title, years, abstract, authors, journal FROM Articles ORDER BY " . $sort);
		
		while($donnees = $requete->fetch(PDO::FETCH_ASSOC))
		{
			$article[] = new Article($donnees);
		}
		
		return $article;
	}

	public function update(Article $article)
	{
		// Prépare une requête de type UPDATE.
		// Assignation des valeurs à la requête.
		// Exécution de la requête.
		$requete = $this->db->prepare("UPDATE Articles SET doi = :doi, pmcid = :pcmid, title = :title, years = :years, abstract = :abstract, authors = :authors, journal = :journal WHERE pmid = :pmid");
		
		$requete->bindValue(":doi", $article->doi(), PDO::PARAM_STR);
		$requete->bindValue(":pmcid", $article->pmcid(), PDO::PARAM_STR);
		$requete->bindValue(":title", $article->title(), PDO::PARAM_STR);
		$requete->bindValue(":years", $article->years(), PDO::PARAM_INT);
		$requete->bindValue(":abstract", $article->abstract(), PDO::PARAM_STR);
		$requete->bindValue(":authors", $article->authors(), PDO::PARAM_STR);
		$requete->bindValue(":journal", $article->journal(), PDO::PARAM_STR);
		
		$requete->execute();
		
	}

	public function setDb(PDO $db)
	{
		$this->db = $db;
	}
}
?>