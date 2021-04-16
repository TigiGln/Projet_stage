<?php
    class ArticleSimple
    {
        protected $pmid;
        protected $title;
        protected $abstract;
        protected $statut;

        public function __construct($pmid, $title, $abstract, $statut = "Undefined")
        {
            #echo "<p>Création d'un objet Article</p>";
            $this->setPmid($pmid);
            $this->setTitle($title);
            $this->setAbstract($abstract);
            $this->setStatut($statut);
        }
        //Les fonctions getters
        public function pmid()
        {
            return $this->pmid;
        }
        public function title()
        {
            return $this->title;
        }
        public function abstract()
        {
            return $this->abstract;
        }
        public function statut()
        {
            return $this->statut;
        }

        //Les fonctions setters
        public function setPmid($pmid)
        {
            if (is_string($pmid))
            {
                $this->pmid = $pmid;
            }
        }
        public function setTitle($title)
        {
            if (is_string($title))
            {
                $this->title = $title;
            }
        }
        public function setAbstract($abstract)
        {
            if (is_string($abstract))
            {
                $this->abstract = $abstract;
            }
        }
        public function setStatut($statut)
        {
            if (is_string($statut))
            {
                $this->statut = $statut;
            }
        }
        public function __toString()
        {
            return $this->pmid;
        }
  
}





?>