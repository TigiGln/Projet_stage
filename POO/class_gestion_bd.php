<?php
    class ManagerDb
    {
        public $pdo;
        public $serveur;
        public $db;
        public $name;
        public $password;
        public $tables;

        //se lance à l'instanciation de l'objet de cette classe en appelant la fonction de connexion à la base de données
        public function __construct($serveur, $db, $name, $password)
        {
            $this->serveur = $serveur;
            $this->db = $db;
            $this->name = $name;
            $this->password = $password;
        
            $this->connexionDb();
            
        }
        //Permet de se connecter à la base de données
        protected function connexionDb()
        {
            try
            {
                $this->pdo = new PDO("mysql:host=" . $this->serveur . ";dbname=" . $this->db, $this->name , $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                //echo "Connexion réussi !";
                $this->loadTables();
            }
            catch (PDOException $e) // On attrape les exceptions PDOException.
            {
            echo 'La connexion a échoué.<br />';
            //echo 'Informations : [', $e->getCode(), '] ', $e->getMessage(); // On affiche le n° de l'erreur ainsi que le message.
            }
        }
        //méthodes sleep permet lors de la linéairisation de l'objet dans les variable de session de stocker l'information pour la délinéarisation
        public function __sleep()
        {
            // Ici sont à placer des instructions à exécuter juste avant la linéarisation.
            // On retourne ensuite la liste des attributs qu'on veut sauver.
            return ['serveur', 'db', 'name', 'password'];
        }
        //méthode wakup lors de la délinéarisation pour recréer la connexion à la bdd
        public function __wakeup()
        {
            $this->connexionBDD();
        }
        //charge l'ensemble des tables de la base comme attribut de l'objet
        protected function loadTables()
        {
            $request = $this->pdo->query("SHOW TABLES");
            $request->execute();
            $list_tables = [];
            while($data = $request->fetch())
            {
                $list_tables[$data["Tables_in_biblio"]] = $data["Tables_in_biblio"];
            }
            
            $this->tables = $list_tables;
            //echo $this->tables['article'] . "<br>";
        }
        //Check si la table existe dans la base de données
        protected function checkTable($table)
        {
           
            if(in_array($table, $this->tables))
            {
                $table = $this->tables[$table];
            }
            else
            {
                exit("Une table n'existe pas");
            }
            return $table;
        }
        //Récupère les différents champs de la table
        public function fields_table($table)
        {
            $this->checkTable($table);
            $request = $this->pdo->prepare("DESCRIBE $table");
            $request->execute();
            $list_fields = [];
            while($data = $request->fetch())//boucle sur les lignes de la table répondant à la requête
            {
                $list_fields[$data['Field']] = $data['Field'];
            }
            array_splice($list_fields, 0, 1);//permet d'enlever le 1er champs correspondant à l'id auto_incrémente
            //var_dump($list_fields);
            return $list_fields;
        }
        //Récupère les attributs de l'objet et les transforme en liste
        public function object_attributes($object)
        {
            $list_attributes = $object->iter();//récupère l'ensemble des attributs de l'objet possédant une méthode iter(l'objet article dans notre cas)
            $list_attributes = array_keys($list_attributes);

            return $list_attributes;
        }
        //test si un élément existe dans une table
        public function is_exist($table, $fields, $field_value) 
        {
            $this->checkTable($table);
            $request = $this->pdo->prepare("SELECT * FROM $table WHERE $fields = :champs");
            $request->bindValue(":champs", $field_value);
            //var_dump($request);
            $request->execute();
            $data = $request->fetch();
            return !empty($data);//renvoie true si l'élément recherché existe dans la table
        }
        //permet de checker un ensemble de table passé en argument et d'assigner des variables pour chaque table
        /*protected function manage_table_multiple($array_table)
        {
            $count = 1;
            for($j=0; $j<count($array_table); $j++)
            {
                $this->checkTable($array_table[$j]);
                ${ 'table' . $count } = $array_table[$j];
                $count++;
            }

        }*/
        //insertion grâce à un objet
        public function addDb(Article $article, $array_table)
        {
            // Préparation de la requête d'insertion.
            // Assignation des valeurs.
            // Exécution de la requête.
            
            $count = 1;
            for($j=0; $j<count($array_table); $j++)
            {
                $this->checkTable($array_table[$j]);
                ${ 'table' . $count } = $array_table[$j];
                $count++;
            }
            $list_fields = $this->fields_table($table1);
            $list_attributes = $this->object_attributes($article);
            $list_intersect = array_values(array_intersect($list_attributes, $list_fields));
            $list_fields_value = implode(', ', $list_intersect);
            $list_fields_value1 = implode(', :', $list_intersect);
            $list_fields_value1 = ":" . $list_fields_value1;
            if (count($array_table == 1))
            {
                $request = $this->pdo->prepare("INSERT INTO $table1($list_fields_value) VALUES($list_fields_value1)");
                for($i=0; $i<count($list_intersect); $i++)
                {
                    $method = $list_intersect[$i];
                    $request->bindValue(':' . $list_intersect[$i], $article->getter($method));
                }
            }
            $request->execute();
            if (!$request) 
            {
                echo "\n PDO::errorInfo():\n";
                print_r($db->errorInfo());
            }
            
        }



    }

?>