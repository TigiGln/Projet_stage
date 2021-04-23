<?php
class Connexion
{
    public $pdo;
    public $serveur;
    public $user;
    public $mdp;
    public $db;
    
    public function __construct($serveur,$db, $user, $mdp)
    {
    
        $this->serveur = $serveur;
        $this->user = $user;
        $this->mdp = $mdp;
        $this->db = $db;

        $this->connexionBDD();
    }

    protected function connexionBDD()
    {
        $this->pdo = new PDO("mysql:host=" . $this->serveur . ";dbname=" . $this->db, $this->user , $this->mdp);
    }
    public function __sleep()
    {
        // Ici sont à placer des instructions à exécuter juste avant la linéarisation.
        // On retourne ensuite la liste des attributs qu'on veut sauver.
        return ['serveur', 'user', 'mdp', 'db'];
    }
    public function __wakeup()
    {
        $this->connexionBDD();
    }
}

?>