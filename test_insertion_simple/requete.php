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
    $pmid1 = strval($output1->PubmedArticle->MedlineCitation->PMID);
    $title = strval($output1->PubmedArticle->MedlineCitation->Article->ArticleTitle);
    $abstract = "";
    foreach ($output1->PubmedArticle->MedlineCitation->Article->{'Abstract'}->AbstractText as $charac)
        {
            $abstract .= strval($charac);
        }
    $liste_info = [$pmid1, $title, $abstract];

    return $liste_info;
}
   
?>