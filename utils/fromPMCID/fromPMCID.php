<?php
    /**
     * 
     * fromPMCID 
     * 
     * Created on Fri Apr 16 2021
     * Latest update on Mon May 10 2021
     * Info - PHP script to retrieve and echo using articles from PMCID using CURL
     * Usage example specific: http://localhost/projet_stage/utils/fromPMCID?PMCID=6439307&title&authors&content&references
     * Usage example return whole content: http://localhost/projet_stage/utils/fromPMCID?PMCID=6439307
     * Usage example echo whole content: http://localhost/projet_stage/utils/fromPMCID?PMCID=6439307?print
     * ---------------------------------
     * CLASSES AND IDS OF PMID ARTICLES
     * Depending of versions (dates) of the article, often the name changed, as for classes or ids of articles.
     * Hence article section can be named sX, secX or even __secX. Same goes for other parts as following:
     * (The list may change and upgrade, please keep it up to date with latest version, as well as editing the corresponding lines). X is a number.
     * Article Title: content-title
     * List of authors: contrib-group (contrib-group fm-author)
     * Associated data: ass-data
     * Abstract: absX, (first) idmXXXXXX [We will use idm]
     * Artile sections: sX, secX, __secX, SecX, __SecX [We will use sX]
     * Supplementary materials: sd
     * References: (ref-list-sec sec, id: reference-list) [no need to change, since it is common everywhere]
     * ---------------------------------
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     */

    //Prepare Curl request
    //Later the ID will be called
    if(!isset($_GET['PMCID'])) {
        echo '<div class="alert alert-danger" role="alert">
            This page need an argument: ?PMCID=NUM
        </div>';
        exit(10);
    }
    //Parsing
    $PMCID = $_GET['PMCID'];
    $isTitle = false;
    $isAuthors = false;
    $isContent = false;
    $isReferences = false;
    $isEcho = false;
    if(!isset($_GET['title']) && !isset($_GET['authors']) && !isset($_GET['content']) && !isset($_GET['references'])) {
        $isTitle = true; $isAuthors = true; $isContent = true; $isReferences = true;
    } else {
        if(isset($_GET['title'])) { $isTitle = true;}
        if(isset($_GET['authors'])) { $isAuthors = true;}
        if(isset($_GET['content'])) { $isContent = true;}
        if(isset($_GET['references'])) { $isReferences = true;}
    }
    if(isset($_GET['print'])) { $isEcho = true;}

    $url = 'https://www.ncbi.nlm.nih.gov/pmc/articles/PMC'.$PMCID.'/';
    //Get Curl data
    $req = curl_init($url);
    curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($req, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($req, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($req, CURLOPT_ENCODING, '');
    $res = curl_exec($req);
    //Close Curl request
    curl_close($req); 
    //Fix Links Issues and Homogenize Data
    $handle = (file_exists("../utils/fromPMCID/parser.config")) ? fopen("../utils/fromPMCID/parser.config", "r") : fopen("../../utils/fromPMCID/parser.config", "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            if(substr($line, 0, 2) === '/*') continue;
            $line = explode("<_>", $line);
            $res = str_replace($line[0], $line[1], $res);
        }
        fclose($handle);
    }
    //Find content
    //Title
    preg_match('/(<h1 class="content-title).*?(<\/h1>)/s', $res, $title, PREG_OFFSET_CAPTURE);
    $title = $title[0][0];

    //Authors
    preg_match('/(<div class="contrib-group).*?(<div class="togglers)/s', $res, $authors, PREG_OFFSET_CAPTURE); //Work when disclaimer is here. if not need to update
    $authors = str_replace('<div class="togglers"', '', $authors);
    $authors = $authors[0][0];

    //Content
    preg_match('/(<div id="idm).*(<\/div><div id="idm)/s', $res, $content, PREG_OFFSET_CAPTURE);
    $content = $content[0][0];
    $content = substr($content, 0, strlen($content)-12);

    //References 
    preg_match('/(<div class="ref-list-sec).*?(<\/div><\/div>)/s', $res, $references, PREG_OFFSET_CAPTURE);
    $references = $references[0][0];

    //Remove all divs for flex
    $title = str_replace('<div', '<span', $title); $title = str_replace('div>', 'span>', $title);
    $authors = str_replace('<div', '<span', $authors); $authors = str_replace('div>', 'span>', $authors);
    $content = str_replace('<div', '<span', $content); $content = str_replace('div>', 'span>', $content);

    //Echos content
    $echo = "";
    if($isTitle) { $echo = $echo . $title . '<br>'; }
    if($isAuthors) { $echo = $echo . $authors . '<br>'; }
    if($isContent) { $echo = $echo . $content . '<br>'; }
    if($isReferences) { $echo = $echo . $references . '<br>'; }
    if($isEcho) { echo $echo; }
    else { return $echo; }
?>