<?php
    class Article
    {
        protected $origin;
        protected $num_access;
        protected $title;
        protected $abstract;
        protected $year;
        protected $journal;
        protected $pmcid;
        protected $status;
        protected $authors;
        
        

        public function __construct($num_access, $title, $abstract, $year, $journal, $pmcid, $authors, $origin = "pubmed", $status = '1')
        {
            #echo "<p>Création d'un objet Article</p>";
            $this->setOrigin($origin);
            $this->setNum_access($num_access);
            $this->setTitle($title);
            $this->setAbstract($abstract);
            $this->setYear($year);
            $this->setJournal($journal);
            $this->setPmcid($pmcid);
            $this->setStatus($status);
            $this->setAuthors($authors);
        }
        //Les fonctions getters
        public function origin()
        {
            return $this->origin;
        }
        public function num_access()
        {
            return $this->num_access;
        }
        public function title()
        {
            return $this->title;
        }
        public function abstract()
        {
            return $this->abstract;
        }        
        public function year()
        {
            return $this->year;
        }
        
        public function journal()
        {
            return $this->journal;
        }
        public function pmcid()
        {
            return $this->pmcid;
        }
        public function status()
        {
            return $this->status;
        }
        public function authors()
        {
            return $this->authors;
        }

        //Les fonctions setters
        public function setOrigin($origin)
        {
            if (is_string($origin))
            {
                $this->origin = $origin;
            }
        }
        public function setNum_access($num_access)
        {
            if (is_string($num_access))
            {
                $this->num_access = $num_access;
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
        public function setYear($year)
        {
            if (is_string($year))
            {
                $this->year = $year;
            }
        }
        public function setJournal($journal)
        {
            if (is_string($journal))
            {
                $this->journal = $journal;
            }
        }
        public function setPmcid($pmcid)
        {
            if (is_string($pmcid))
            {
                $this->pmcid = $pmcid;
            }
        }
        public function setStatus($status)
        {
            if (is_string($status))
            {
                $this->status = $status;
            }
        }
        public function setAuthors($authors)
        {
            if (is_string($authors))
            {
                $this->authors = $authors;
            }
        }
        public function __toString()
        {
            return $this->num_access;
        }
  
}





?>