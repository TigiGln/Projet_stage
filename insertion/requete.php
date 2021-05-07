<?php
//fonction pour récupérer le fichier xml de l'article
function search($listpmid, $i)
{
    $id = trim($listpmid[$i]);
    $base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&usehistory=y&term=';
    $search = file_get_contents($base.$id);
    $search = new SimpleXMLElement($search);//création de l'objet de parsing xml
    $web_env = $search->WebEnv;//récupération de la valeur du web Env pour la requête suivante
    $base1 = "http://www.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?rettype=abstract&retmode=xml&db=Pubmed&query_key=1&WebEnv=" . $web_env;
    $url = $base1 . "&usehistory=y&term=" . $id;
    $output = file_get_contents($url);//requête pour récupérer le xml des données importantes de l'article
    
    return $output;
}
//récupération des éléments importants de l'article si l'abstract et les authors sont mentionnés
function recovery($output)
{
    $output1 = new SimpleXMLElement($output);//création de l'objet de parsing
    //Vérification de l'article pour savoir si il y a un auteur et un abstract disponible.
    if (!empty($output1->PubmedArticle->MedlineCitation->Article->{'Abstract'}->AbstractText) AND !empty($output1->PubmedArticle->MedlineCitation->Article->AuthorList->Author))
    {
        //si c'est le cas récupération des éléments importants 
        $pmid1 = strval($output1->PubmedArticle->PubmedData->ArticleIdList->ArticleId[0]);
        $doi = '';
        foreach($output1->PubmedArticle->PubmedData->ArticleIdList->ArticleId as $elem)
        {
            $regex = preg_match('/^10\.[0-9]{4}\//', $elem);
            if ($regex == 1)
            {
                $doi = $elem;
            }
        }
        $pmcid = strval($output1->PubmedArticle->PubmedData->ArticleIdList->ArticleId[3]);
        $title = strval($output1->PubmedArticle->MedlineCitation->Article->ArticleTitle);
        $year = strval($output1->PubmedArticle->MedlineCitation->Article->Journal->JournalIssue->PubDate->Year);
        $abstract = "";
        $abstract_no_empty= $output1->PubmedArticle->MedlineCitation->Article->{'Abstract'}->AbstractText;
        if (!empty($abstract_no_empty))
        {
            foreach ($abstract_no_empty as $charac)
                {
                    $abstract .= strval($charac);
                }
        }
        else
        {
            $abstract = "No abstract available";
        }
        $authors = [];
        $authorsList = [];
        $authors_no_empty = $output1->PubmedArticle->MedlineCitation->Article->AuthorList->Author;
        if (!empty($authors_no_empty))
        {
            $i = 0;
            foreach ($authors_no_empty as $name)
            {
                $authors[] = strval($name->LastName) . " " . strval($name->Initials);
                $authorsList[] = strval($name->LastName) . " " . strval($name->ForeName);
                $i++;
            }
            
            
        }
        
        else
        {
            $authors = "No authors available";
        }
        $journal = strval($output1->PubmedArticle->MedlineCitation->Article->Journal->Title);
        $liste_info = [$pmid1, $doi, $pmcid, $title, $year, $abstract, $authors, $journal, $authorsList];
        return $liste_info;
    }
    
}
 
?>