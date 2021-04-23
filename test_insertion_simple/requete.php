<?php
function search($listpmid, $i)
{
    $id = trim($listpmid[$i]);
    $base = 'http://www.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=Pubmed&usehistory=y&term=';
    $search = file_get_contents($base.$id);
    $search = new SimpleXMLElement($search);
    $web_env = $search->WebEnv;
    $base1 = "http://www.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?rettype=abstract&retmode=xml&db=Pubmed&query_key=1&WebEnv=" . $web_env;
    $url = $base1 . "&usehistory=y&term=" . $id;
    $output = file_get_contents($url);
    
    return $output;
}

function recovery($output)
{
    $output1 = new SimpleXMLElement($output);
    if (!empty($output1->PubmedArticle->MedlineCitation->Article->{'Abstract'}->AbstractText) AND !empty($output1->PubmedArticle->MedlineCitation->Article->AuthorList->Author))
    {
        $pmid1 = strval($output1->PubmedArticle->PubmedData->ArticleIdList->ArticleId[0]);
        $doi = strval($output1->PubmedArticle->PubmedData->ArticleIdList->ArticleId[1]);
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
        $authors = "";
        $authors_no_empty = $output1->PubmedArticle->MedlineCitation->Article->AuthorList->Author;
        if (!empty($authors_no_empty))
        {
            foreach ($authors_no_empty as $name)
                {
                    $authors .= "'" . strval($name->LastName) . " " . strval($name->ForeName) . "',";
                }
        }
        else
        {
            $authors = "No authors available";
        }
        $journal = strval($output1->PubmedArticle->MedlineCitation->Article->Journal->Title);
        $liste_info = [$pmid1, $doi, $pmcid, $title, $year, $abstract, $authors, $journal];
        return $liste_info;
    }
    
}
 
?>