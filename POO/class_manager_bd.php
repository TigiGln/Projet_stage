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
            return !empty($donnees);
            
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
        public function search_enum_fields($table, $fields)
        {
            /*$requete1 = $this->db->prepare("SHOW COLUMNS FROM article LIKE 'status'");
            $requete1->execute();
            $type = substr($donnees[0]['Type'], 6, -2);
            $liste_type = explode( "','", $type);
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
        
        /**
         * getSpecific is a method to request more specifics data where we select the columns, the conditions and the table.
         * return the array of fetched elements.
	     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
         * @param  mixed $cols
         *            Array with columns name to get.
         * @param  mixed $conditions
         *            Array of arrays to get the conditions WHERE. in each subArrays position 0 is the left member, position 1 is the right member.
         * @param  mixed $table
         *            Table where we perform the request.
         * @return void
         */
        public function getSpecific($cols, $conditions, $table) {
            $values = array();
            $prepReq = "SELECT";
            foreach ($cols as $col) { $prepReq = $prepReq." ".$col.","; }
            $prepReq = substr_replace($prepReq ,"",-1) . " FROM ".$table; //remove last coma and add contents

            if(sizeof($conditions) != 0) {
                $prepReq = $prepReq . " WHERE";
                foreach ($conditions as $condition) { 
                    $prepReq = $prepReq." ".$condition[0]." = ? and"; 
                    array_push($values, $condition[1]);
                }
                $prepReq = substr_replace($prepReq ,"",-4); //remove last " AND"
            } 

            $req = $this->db->prepare($prepReq);
            $req->execute($values);
            $res = $req->fetchAll(PDO::FETCH_ASSOC);
            return $res;

        }

        /**
         * updateSpecific is a method to update more specifics data where we select the columns, the conditions and the table.
         * return true if insertion was a success, false if not.
	     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
         * @param  mixed $cols
         *            Array of arrays to get the conditions SET. in each subArrays position 0 is the left member, position 1 is the right member.
         * @param  mixed $conditions
         *            Array of arrays to get the conditions WHERE. in each subArrays position 0 is the left member, position 1 is the right member.
         * @param  mixed $table
         *            Table where we perform the request.
         * @return void
         */
        public function updateSpecific($cols, $conditions, $table) {
            $values = array();
            $prepReq = "UPDATE ".$table." SET";
            foreach ($cols as $col) { 
                $prepReq = $prepReq." ".$col[0]." = ?,"; 
                array_push($values, $col[1]);
            }
            $prepReq = substr_replace($prepReq ,"",-1); //remove last coma

            if(sizeof($conditions) != 0) {
                $prepReq = $prepReq . " WHERE";
                foreach ($conditions as $condition) { 
                    $prepReq = $prepReq." ".$condition[0]." = ? and"; 
                    array_push($values, $condition[1]);
                }
                $prepReq = substr_replace($prepReq ,"",-4); //remove last " AND"
            } else {  $prepReq = $prepReq . " WHERE 1"; }

            $req = $this->db->prepare($prepReq);
            $res = $req->execute($values);
            return $res;

        }

        /**
         * insertSpecific is a method to update more specifics data where we select the columns, the conditions and the table.
         * return true if insertion was a success, false if not.
	     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
         * @param  mixed $cols
         *            Array with columns name to set.
         * @param  mixed $conditions
         *            Array with values of the columns.
         * @param  mixed $table
         *            Table where we perform the request.
         * @return void
         */
        public function insertSpecific($cols, $datas, $table) {
            $values = array();
            $prepReq = "INSERT INTO ".$table."(";
            foreach ($cols as $col) { 
                $prepReq = $prepReq." ".$col.","; 
            }
            $prepReq = substr_replace($prepReq ,"",-1) . ")"; //remove last coma and add contents

            if(sizeof($datas) != 0) {
                $prepReq = $prepReq . " VALUES(";
                foreach ($datas as $data) { 
                    $prepReq = $prepReq." ?,"; 
                    array_push($values, $data);
                }
                $prepReq = substr_replace($prepReq ,"",-1) . ")"; //remove last coma and add contents
            } else {  $prepReq = $prepReq . " VALUES 1"; }

            $req = $this->db->prepare($prepReq);
            $res = $req->execute($values);
            return $res;

        }

        public function addHTMLXMLByPMCID($num_access, $pmcid) {
            $pmcid = str_replace("PMC", "", $pmcid);
            $_GET['PMCID'] = $pmcid;
            $url = './utils/fromPMCID.php';
            $data = include($url);
            $cols = array();
            array_push($cols, array("html_xml", $data));
            $conditions = array();
            array_push($conditions, array("num_access", $num_access));
            $this->updateSpecific($cols, $conditions, "article");
        }
    }

?>