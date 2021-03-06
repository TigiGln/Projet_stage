<?php
    class Manager
    {
        public $db; // Instance de PDO. 

        public function __construct($db)
        {
            $this->setDb($db);
        }
        //méthodes pour l'ajout dans la base de données des attribut d'un objet article
        public function add(Article $article)
        {
            // Préparation de la requête d'insertion.
            // Assignation des valeurs.
            // Exécution de la requête.
            $requete = $this->db->prepare("INSERT INTO article(origin, num_access, title, abstract, year, journal, pmcid, status, user) VALUES(:origin, :num_access, :title, :abstract, :year, :journal, :pmcid, :status, :user)");
            
            #$requete = $this->db->prepare("INSERT INTO Articles(statut, pmid, doi, pmcid, title, years, abstract, authors, journal) VALUES(:statut, :pmid, :doi, :pmcid, :title, :years, :abstract, :authors, :journal)");
            $requete->bindValue(":origin", $article->getorigin());
            $requete->bindValue(":num_access", $article->getnum_access());
            $requete->bindValue(":title", $article->gettitle());
            $requete->bindValue(":abstract", $article->getabstract());
            $requete->bindValue(":year", $article->getyear());
            $requete->bindValue(":journal", $article->getjournal());
            $requete->bindValue(":pmcid", $article->getpmcid());
            $requete->bindValue(":status", $article->getstatus());
            $requete->bindValue(":status", $article->getstatus());
            $requete->bindValue(":user", $article->getuser());
            #$requete->bindValue(":pmid", strval($article->pmid()));
            #$requete->bindValue(":doi", $article->doi());
            #$requete->bindValue(":authors", $article->authors());

            $requete->execute();
            if (!$requete) 
            {
                echo "\n PDO::errorInfo():\n";
                print_r($db->errorInfo());
            }
            else
            {
                header("Location:../trie_table_statut/page_table.php?status=undefined&user=" . $_SESSION['user']);
            }
            
        }
        //insertion pour le formulaire d'enregistrement des utilisateurs
        public function add_form($protocol, $list, $table) 
        {
            $requete = $this->db->prepare("INSERT INTO " . $table ."(" . implode(', ', $list) . ") VALUES(:" . implode(', :', $list) . ")");
            for($i=0 ; $i < count($list) ; $i++)
            {
                if ($list[$i] == 'password')
                {
                    $requete->bindValue(":" . $list[$i], password_hash(htmlspecialchars($protocol[$list[$i]]), PASSWORD_DEFAULT));
                }
                else
                {
                    $requete->bindValue(":" . $list[$i], htmlspecialchars($protocol[$list[$i]]));
                }
            }
            $requete->execute();
            if (!$requete) 
            {
                echo "\nPDO::errorInfo():\n";
                print_r($db->errorInfo());
            }
        }
        //Savoir si une valeur existe dans la table à un champ donnée
        public function get_exist($table, $fields, $value)
        {
            // Exécute une requête de type SELECT avec une clause WHERE.
            $requete = $this->db->prepare("SELECT * FROM  $table  WHERE  $fields = ?");
            //$requete->bindValue(':value', $value);
            $requete->execute(array(htmlspecialchars($value)));
            #$requete = $this->db->query("SELECT pmid, doi, pmcid, title, years, abstract, authors, journal, statut FROM Articles WHERE " .  $key . " = " . $id);
            $donnees = $requete->fetch();
            return !empty($donnees);
            
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
        public function get_fields($table1, $table2, $table3, $champs_status ,$status, $champs_user, $user)//Récupération des lignes filtré par la valeur du champs
        {
            //$requete = $this->db->prepare("SELECT * FROM article WHERE $fields = :valeur");
            $requete = $this->db->prepare("SELECT * FROM $table1 INNER JOIN $table2 ON $table1.status = $table2.id_status INNER JOIN $table3 ON $table1.user = $table3.id_user WHERE $table2.$champs_status = :status AND $table3.$champs_user = :user");
            $requete->bindValue(':status', $status);
            $requete->bindValue(':user', $user);
            $requete->execute();
            $article_list = $requete->fetchAll(PDO::FETCH_ASSOC);
            //var_dump($article_list[0]["abstract"]);

            return $article_list;
            
        }
        public function get_fields_join($table1, $table2, $table3, $champs_status, $status)
        {
            $requete = $this->db->prepare("SELECT *, $table3.name_user FROM $table1 INNER JOIN $table2 ON $table1.status = $table2.id_status INNER JOIN $table3 ON $table1.user = $table3.id_user WHERE $table2.$champs_status = :status");
            $requete->bindValue(':status', $status);
            $requete->execute();
            $article_list = $requete->fetchAll(PDO::FETCH_ASSOC);
            
            return $article_list;
        }
        //fonction de mise à jour des données par le num_access
        public function update($num_access, $fields, $modif, $table1, $table2)
        {
            
            // Prépare une requête de type UPDATE.
            // Assignation des valeurs à la requête.
            // Exécution de la requête.
            $requete = $this->db->prepare("UPDATE $table1 SET $table1.$fields = (SELECT id_$table2 FROM $table2  WHERE $table2.name_$table2 = '$modif') WHERE $table1.num_access = $num_access");
            var_dump($requete);
            $requete->bindValue(":status", $modif);
            $requete->execute();

        }
        //fonction pour récupérer les différents statuts
        public function search_enum_fields($table1, $table2, $fields, $champs_statut)
        {
            
            /*$requete1 = $this->db->prepare("SHOW COLUMNS FROM article LIKE 'status'");
            $requete1->execute();
            $donnees = $requete1->fetchAll();
            $type = substr($donnees[0]['Type'], 6, -2);
            $liste_type = explode( "','", $type );
            $list_statut_present = array_values($liste_type);*/

            //$requete = $this->db->prepare("SELECT DISTINCT $fields FROM $table");
            $requete = $this->db->prepare("SELECT DISTINCT $fields FROM $table1 INNER JOIN $table2 ON $table1.id_$table1 = $table2.$champs_statut;");
            $requete->execute();
            $list_statut_present = [];
            while($requete_enum = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $list_statut_present[] = $requete_enum['name_' . $table1];
            }
        
            return $list_statut_present;
        }
        //permet de récupérer la connexion à la base de données
        public function setDb($db)
        {
            $this->db = $db;
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