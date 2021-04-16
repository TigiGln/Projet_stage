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
            $requete = $this->db->prepare("INSERT INTO document(statut, pub_db_acc, title, abstract) VALUES(:statut, :pmid, :title, :abstract)");
           
            $requete->bindValue(":statut", $article->statut());
            $requete->bindValue(":pmid", $article->pmid());
            $requete->bindValue(":title", $article->title());
            $requete->bindValue(":abstract", $article->abstract());
            
            $requete->execute();
            
        }
        public function get($pmid)
        {
            // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Article.
            $requete = $this->db->query("SELECT pmid, title FROM Articlesimple WHERE pmid = " . $pmid);
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
        public function setDb(PDO $db)
        {
            $this->db = $db;
        }
    }
?>