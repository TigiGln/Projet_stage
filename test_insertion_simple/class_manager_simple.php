<?php
    class Manager
    {
        protected $db; // Instance de PDO. 

        public function __construct($db)
        {
            $this->setDb($db);
        }

        public function add(ArticleSimple $article)
        {
            // Préparation de la requête d'insertion.
            // Assignation des valeurs.
            // Exécution de la requête.
            $requete = $this->db->prepare("INSERT INTO document(statut, pub_db_acc, doi, title, `year`,  abstract) VALUES(:statut, :pmid, :doi, :title, :years, :abstract)");
            #$requete = $this->db->prepare("INSERT INTO Articles(statut, pmid, doi, pmcid, title, years, abstract, authors, journal) VALUES(:statut, :pmid, :doi, :pmcid, :title, :years, :abstract, :authors, :journal)");
            $requete->bindValue(":statut", strval($article->statut()));
            $requete->bindValue(":pmid", strval($article->pmid()));
            $requete->bindValue(":doi", $article->doi());
            #$requete->bindValue(":pmcid", $article->pmcid());
            $requete->bindValue(":title", strval($article->title()));
            $requete->bindValue(":years", $article->year());
            $requete->bindValue(":abstract", $article->abstract());
            #$requete->bindValue(":authors", $article->authors());
            #$requete->bindValue(":journal", $article->journal());
            $requete->execute();
            if (!$requete) 
            {
                echo "\nPDO::errorInfo():\n";
                print_r($dbh->errorInfo());
            }
            
        }
        public function get_exist($key, $id)
        {
            // Exécute une requête de type SELECT avec une clause WHERE.
            $requete = $this->db->query("SELECT * FROM document WHERE " .  $key . " = " . $id);
            #$requete = $this->db->query("SELECT pmid, doi, pmcid, title, years, abstract, authors, journal, statut FROM Articles WHERE " .  $key . " = " . $id);
            $donnees = $requete->fetch();
            if (empty($donnees))
            {
                return False;
            }
            else
            {
                return True;
            }
            
        }
        public function get_statut($value)
        {
            $requete = $this->db->prepare("SELECT * FROM document WHERE statut = :valeur");
            $requete->bindValue(':valeur', $value);
            $requete->execute();
            $article_list = $requete->fetchAll(PDO::FETCH_ASSOC);

            return $article_list;
        }
        public function update($pub_db_acc, $statut)
        {
            // Prépare une requête de type UPDATE.
            // Assignation des valeurs à la requête.
            // Exécution de la requête.
            $requete = $this->db->prepare("UPDATE document SET statut = :statut WHERE pmid = " . $pub_db_acc);
            
            $requete->bindValue(":statut", $statut, PDO::PARAM_STR);

            $requete->execute();
            
        }
        public function setDb(PDO $db)
        {
            $this->db = $db;
        }
    }
?>