<?php
class Article 
{
    protected $Xref_id; //keep primary key
    protected $pmid;
    protected $doi;
    protected $pmcid;
    protected $title;
    protected $years;
    protected $abstract;
    protected $authors; //1, 2, 3 (set); 1-N
    //Links to another sql table, save xref_id from authors
    //AUTHORS: ID:  - name etc
    protected $journal; //1-1;
    protected $statut;

    public function __construct($list_info)
    {
        echo "<p>Création d'un objet Article</p>";
        $this->setPmid($list_info["pmid"]);
        $this->setDoi($list_info["doi"]);
        $this->setPmcid($list_info["pmcid"]);
        $this->setTitle($list_info["title"]);
        $this->setYears($list_info["years"]);
        $this->setAbstract($list_info["abstract"]);
        $this->setAuthors($list_info["authors"]);
        $this->setJournal($list_info["journal"]);
        #$this->setStatut($list_info["statut"]);
    }

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
    public function years()
    {
        return $this->years;
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
    public function setYears($years)
    {
        if (is_string($years))
        {
            $this->years = $years;
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

    public function __destruct()
    {
        echo "<p>Destruction de votre objet " . $this->pmid . "</p>";
    }


}



?>