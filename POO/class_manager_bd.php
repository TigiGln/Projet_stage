<?php
    class Manager
    {
        protected $db; // Instance de PDO. 

        public function __construct($db)
        {
            $this->setDb($db);
        }

        public function add(Article $article)//insertion grâce à un objet
        {
            // Préparation de la requête d'insertion.
            // Assignation des valeurs.
            // Exécution de la requête.
            $requete = $this->db->prepare("INSERT INTO article(origin, num_access, title, abstract, year, journal, pmcid, status) VALUES(:origin, :num_access, :title, :abstract, :year, :journal, :pmcid, :status)");
            
            #$requete = $this->db->prepare("INSERT INTO Articles(statut, pmid, doi, pmcid, title, years, abstract, authors, journal) VALUES(:statut, :pmid, :doi, :pmcid, :title, :years, :abstract, :authors, :journal)");
            $requete->bindValue(":origin", $article->origin());
            $requete->bindValue(":num_access", $article->num_access());
            $requete->bindValue(":title", $article->title());
            $requete->bindValue(":abstract", $article->abstract());
            $requete->bindValue(":year", $article->year());
            $requete->bindValue(":journal", $article->journal());
            $requete->bindValue(":pmcid", $article->pmcid());
            $requete->bindValue(":status", $article->status());
            #$requete->bindValue(":pmid", strval($article->pmid()));
            #$requete->bindValue(":doi", $article->doi());
            #$requete->bindValue(":authors", $article->authors());

            $requete->execute();
            if (!$requete) 
            {
                echo "\nPDO::errorInfo():\n";
                print_r($db->errorInfo());
            }
            
        }

        public function add_form($protocol, $list, $table) //insertion grâce au information d'un formulaire
        {
            $requete = $this->db->prepare("INSERT INTO " . $table ."(" . implode(', ', $list) . ") VALUES(:" . implode(', :', $list) . ")");

            for($i=0 ; $i < count($list) ; $i++)
            {
                $requete->bindValue(":" . $list[$i], htmlspecialchars($protocol[$list[$i]]));
            }

            $requete->execute();
            if (!$requete) 
            {
                echo "\nPDO::errorInfo():\n";
                print_r($db->errorInfo());
            }

        }
        public function get_exist($fields, $value, $table)//Savoir si une valeur existe dans la table à un champ donnée
        {
            // Exécute une requête de type SELECT avec une clause WHERE.
            $requete = $this->db->prepare("SELECT * FROM " . $table . " WHERE " .  $fields . " = ?");
            $requete->execute(array(htmlspecialchars($value)));
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
        public function get($fields, $value, $table)//Récupérer les éléments correspondant à la requête
        {
            $requete = $this->db->prepare("SELECT * FROM $table WHERE " . $fields . " = ?");
            $requete->execute(array(htmlspecialchars($value)));
            $donnees = $requete->fetch(PDO::FETCH_ASSOC);

            return $donnees;

        }
        public function get_fields($fields ,$value)//Récupération des lignes filtré par la valeur du champs
        {
            $requete = $this->db->prepare("SELECT * FROM article WHERE $fields = :valeur");
            $requete->bindValue(':valeur', $value);
            $requete->execute();
            $article_list = $requete->fetchAll(PDO::FETCH_ASSOC);

            return $article_list;
        }
        public function update($num_access, $fields, $status, $table)//permet de mettre à jour certaine colonnes de la table
        {
            // Prépare une requête de type UPDATE.
            // Assignation des valeurs à la requête.
            // Exécution de la requête.
            $requete = $this->db->prepare("UPDATE $table SET $fields = :status WHERE num_access = $num_access");
            
            $requete->bindValue(":status", $status);
            $requete->execute();

        }
        public function search_enum_fields($table, $fields)
        {
            $requete = $this->db->prepare("SELECT DISTINCT $fields FROM $table");
            $requete->execute();
            $list_statut_present = [];
            while($requete_enum = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $list_statut_present[] = $requete_enum['status'];
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

        /**
         * updateArticleStatus
	     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
         * @param  mixed $id
         *            the id of the article in the database.
         * @param  mixed $status
         *            the status value to give to the article.
         * @return void
         */
        public function updateArticleStatus($id, $status) {
            $req = $this->db->prepare("UPDATE article SET status = ? WHERE id_article = ?");
            $res  = $req->execute(array(htmlspecialchars($status, $id)));
            return empty($res->fetch(PDO::FETCH_ASSOC));
        }
        
        /**
         * updateArticleUser
         * From the idea that we save userID and newUserID somewhere and that we can get them.
	     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
         * @param  mixed $id
         *            the id of the article in the database.
         * @param  mixed $userID
         *            the id of the user (not used, may be deleted).
         * @param  mixed $newUserID
         *            the id of the new user.
         * @return void
         */
        public function updateArticleUser($id, $userID, $newUserID) {
            $req = $this->db->prepare("UPDATE article SET id_user = ? WHERE id_article = ? AND id_user = ?");
            $res  = $req->execute(array(htmlspecialchars($newUserID, $id, $userID)));
            return empty($res->fetch(PDO::FETCH_ASSOC));
        }
        
        /**
         * getUsersList
	     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
         * @return void
         */
        public function getUsersList() {
            $req = $this->db->prepare("SELECT id_user, username, email FROM user");
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>