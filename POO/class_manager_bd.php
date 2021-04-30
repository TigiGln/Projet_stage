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
        public function get_test($columns, $table)
        {
            $list_elements = [];
            $requete = $this->db->prepare("SELECT $columns FROM $table");
            $requete->execute();
            while($data = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $list_elements[] = $data ["num_access"];
            }
            return $list_elements;
        }
        public function get($fields, $value, $table)//Récupérer l'élément correspondant à la requête
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
        //fonction de mise à jour des données par le num_access
        public function update($num_access, $fields, $status, $table)
        {
            // Prépare une requête de type UPDATE.
            // Assignation des valeurs à la requête.
            // Exécution de la requête.
            $requete = $this->db->prepare("UPDATE $table SET $fields = :status WHERE num_access = $num_access");
            
            $requete->bindValue(":status", $status);
            $requete->execute();
            

        }
        //fonction pour récupérer les différents statuts
        public function search_enum_fields($table, $fields)
        {
            /*$requete1 = $this->db->prepare("SHOW COLUMNS FROM article LIKE 'status'");
            $requete1->execute();
            $donnees = $requete1->fetchAll();
            $type = substr($donnees[0]['Type'], 6, -2);
            $liste_type = explode( "','", $type );
            $list_statut_present = array_values($liste_type);*/

            $requete = $this->db->prepare("SELECT DISTINCT $fields FROM $table");
            $requete->execute();
            $list_statut_present = [];
            while($requete_enum = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $list_statut_present[] = $requete_enum['status'];
            }
            
            return $list_statut_present;
        }
        //permet de récupérer la connexion à la base de données
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
         * getUsersList
	     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
         * @return void
         */
        public function getUsers() {
            $req = $this->db->prepare("SELECT id_user, username, email FROM user");
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }
    }

?>