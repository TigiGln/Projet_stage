<?php
    class ArticleSimple
    {
        protected $pmid;
        protected $doi;
        protected $pmcid;
        protected $title;
        protected $year;
        protected $abstract;
        protected $authors;
        protected $journal;
        protected $statut;

        public function __construct($pmid, $doi, $pmcid, $title, $year, $abstract, $authors, $journal, $statut = "undefined")
        {
            #echo "<p>Création d'un objet Article</p>";
            $this->setPmid($pmid);
            $this->setDoi($doi);
            $this->setPmcid($pmcid);
            $this->setTitle($title);
            $this->setYear($year);
            $this->setAbstract($abstract);
            $this->setAuthors($authors);
            $this->setJournal($journal);
            $this->setStatut($statut);
        }
        //Les fonctions getters
        public function pmid()
        {
            return $this->pmid;
        }
        public function doi()
        {
            return $this->doi;
        }
        public function pmcid()
        {
            return $this->pmcid;
        }
        public function title()
        {
            return $this->title;
        }
        public function year()
        {
            return $this->year;
        }
        public function abstract()
        {
            return $this->abstract;
        }
        public function authors()
        {
            return $this->authors;
        }
        public function journal()
        {
            return $this->journal;
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
        public function setDoi($doi)
        {
            if (is_string($doi))
            {
                $this->doi = $doi;
            }
        }
        public function setPmcid($pmcid)
        {
            if (is_string($pmcid))
            {
                $this->pmcid = $pmcid;
            }
        }
        public function setTitle($title)
        {
            if (is_string($title))
            {
                $this->title = $title;
            }
        }
        public function setYear($year)
        {
            if (is_string($year))
            {
                $this->year = $year;
            }
        }
        public function setAbstract($abstract)
        {
            if (is_string($abstract))
            {
                $this->abstract = $abstract;
            }
        }
        public function setAuthors($authors)
        {
            if (is_string($authors))
            {
                $this->authors = $authors;
            }
        }
        public function setJournal($journal)
        {
            if (is_string($journal))
            {
                $this->journal = $journal;
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