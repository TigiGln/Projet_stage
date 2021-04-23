<?php
    class Manager
    {
        protected $db; // Instance de PDO. 

        public function __construct($db)
        {
            $this->setDb($db);
        }

        public function add(ArticleSimple $article)//insertion grâce à un objet
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
                print_r($db->errorInfo());
            }
            
        }

        public function add_form($protocol, $liste, $table) //insertion grâce au information d'un formulaire
        {
            $requete = $this->db->prepare("INSERT INTO " . $table ."(" . implode(', ', $liste) . ") VALUES(:" . implode(', :', $liste) . ")");

            for($i=0 ; $i < count($liste) ; $i++)
            {
                $requete->bindValue(":" . $liste[$i], htmlspecialchars($protocol[$liste[$i]]));
            }

            $requete->execute();
            if (!$requete) 
            {
                echo "\nPDO::errorInfo():\n";
                print_r($db->errorInfo());
            }

        }
        public function get_exist($champs, $valeur, $table)//Savoir si une valeur existe dans la table à un champ donnée
        {
            // Exécute une requête de type SELECT avec une clause WHERE.
            $requete = $this->db->prepare("SELECT * FROM " . $table . " WHERE " .  $champs . " = ?");
            $requete->execute(array(htmlspecialchars($valeur)));
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
        public function get($champs, $value, $table)//Récupérer les éléments correspondant à la requête
        {
            $requete = $this->db->prepare("SELECT * FROM $table WHERE " . $champs . " = ?");
            $requete->execute(array(htmlspecialchars($value)));
            $donnees = $requete->fetch(PDO::FETCH_ASSOC);

            return $donnees;

        }
        public function get_fields($fields ,$value)//Récupération des lignes filtré par la valeur du champs
        {
            $requete = $this->db->prepare("SELECT * FROM document WHERE $fields = :valeur");
            $requete->bindValue(':valeur', $value);
            $requete->execute();
            $article_list = $requete->fetchAll(PDO::FETCH_ASSOC);

            return $article_list;
        }
        public function update($pub_db_acc, $champs, $statut)//permet de mettre à jour certaine colonnes de la table
        {
            // Prépare une requête de type UPDATE.
            // Assignation des valeurs à la requête.
            // Exécution de la requête.
            $requete = $this->db->prepare("UPDATE document SET $champs = :statut WHERE pub_db_acc = " . $pub_db_acc);
            
            $requete->bindValue(":statut", $statut);

            $requete->execute();

        }
        public function search_enum_fields($table, $fields)
        {
            $requete = $this->db->prepare("SELECT DISTINCT $fields FROM $table");
            $requete->execute();
            $list_statut_present = [];
            while($requete_enum = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $list_statut_present[] = $requete_enum['statut'];
            }
            
            return $list_statut_present;
        }

        public function setDb(PDO $db)
        {
            $this->db = $db;
        }
        public function __sleep()
        {
            return ['db'];
        }
        public function __wakeup($db)
        {
            $this->setDb($db);
        }
       
    }

?>