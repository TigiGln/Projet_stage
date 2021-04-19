<?php
    /**
    * RAW HTML GETTER + Clean up datas
    * author: Eddy IKHLEF
    * CLASSES AND IDS OF PMID ARTICLES
    * ---------------------------------
    * Depending of versions (dates) of the article, often the name changed, as for classes or ids of articles.
    * Hence article section can be named sX, secX or even __secX. Same goes for other parts as following:
    * (The list may change and upgrade, please keep it up to date with latest version, as well as editing the corresponding lines). X is a number.
    * Article Title: content-title
    * List of authors: contrib-group (contrib-group fm-author)
    * Associated data: ass-data
    * Abstract: absX, (first) idmXXXXXX [We will use idm]
    * Artile sections: sX, secX, __secX, [We will use secX]
    * Supplementary materials: sd
    * References: (ref-list-sec sec, id: reference-list) [no need to change, since it is common everywhere]
    */

    //Prepare Curl request
    //Later the ID will be called
    $ID = "7934857"; //"7531976"; "7934857"; 7857568
    $url = 'https://www.ncbi.nlm.nih.gov/pmc/articles/PMC'.$ID.'/';
    //Get Curl data
    $req = curl_init($url);
    //Todo, get other setopt to allows faster results
    curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($req, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($req, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($req, CURLOPT_ENCODING, '');
    $res = curl_exec($req);
    //Close Curl request
    curl_close($req); 
    //Step 1: Fix links issues
    $res = str_replace('src="/pmc/articles', 'src="https://www.ncbi.nlm.nih.gov/pmc/articles', $res);
    $res = str_replace('href="/pmc/articles', 'target="_BLANK" href="https://www.ncbi.nlm.nih.gov/pmc/articles', $res); 
    //$res = str_replace('<a class="figpopup" href="/pmc/articles', '<a class="figpopup" hidden target="_BLANK" href="https://www.ncbi.nlm.nih.gov/pmc/articles', $res); //hide other figure ref 
    $res = str_replace('href="/pubmed/', 'target="_BLANK" href="https://pubmed.ncbi.nlm.nih.gov/', $res);
    $res = str_replace('href="/core/', 'target="_BLANK" href="https://www.ncbi.nlm.nih.gov/core/', $res);
    $res = str_replace('href="/nuccore/', 'target="_BLANK" href="https://www.ncbi.nlm.nih.gov/nuccore/', $res);
    $res = str_replace('src="/corehtml/pmc/pmcgifs/corrauth.gif"', 'src="https://www.ncbi.nlm.nih.gov/corehtml/pmc/pmcgifs/corrauth.gif"', $res); 
    $res = str_replace('<hr>', '', $res);
    $res = str_replace('<a href="#" rid="data-suppmats" data-ga-action="click_feat_toggler" data-ga-label="Supplementary Materials" class="pmctoggle">Supplementary Materials</a>', '', $res);
    $res = str_replace('style="display: none;"', '', $res);
    //Step 2: Homogenize Data
    //Abstract
    $res = str_replace('id="Abs', 'id="idm', $res);
    //Sections
    $res = str_replace('id="s', 'id="sec', $res);
    $res = str_replace('id="__sec', 'id="sec', $res);
    //Step 3: Find content
    /*
        * Match the correct portion thanks to id and classes reffered in the taxonomy
        * Replace the superior part of the match if needed
        * Repalce some content if needed
        * get the string content
    */
    //Title
    preg_match('/(<h1 class="content-title).*?(<\/h1>)/s', $res, $title, PREG_OFFSET_CAPTURE);
    $title = $title[0][0];

    //Authors
    preg_match('/(<div class="contrib-group fm-author).*?(<div class="togglers)/s', $res, $authors, PREG_OFFSET_CAPTURE); //Work when disclaimer is here. if not need to update
    $authors = str_replace('<div class="togglers"', '', $authors);
    $authors = $authors[0][0];

    //Content
    preg_match('/(<div id="idm).*(<\/div><div id="idm)/s', $res, $content, PREG_OFFSET_CAPTURE);
    $content = $content[0][0];
    
    //Article
 /*   preg_match('/(<div id="idm).*?(<div class="ref-list-sec")/s', $res, $text, PREG_OFFSET_CAPTURE);
    str_replace('<div class="ref-list-sec', '', $text);
    $text = $text[0][0]; */

    //Keywords
/*    preg_match('/(<span class="kwd-text">).*?(<\/span>)/s', $res, $keywords, PREG_OFFSET_CAPTURE);
    $toString = '';
    print_r($keywords);
    foreach ($keywords[0] as &$key) {
        $toString = $toString . $key[0];
    }
    $keywords = $toString; */

    //References 
    preg_match('/(<div class="ref-list-sec).*?(<\/div><\/div>)/s', $res, $references, PREG_OFFSET_CAPTURE);
    $references = $references[0][0];

    //Courtesy
    preg_match('/(<div class="half_rhythm">Articles from <span).*(<\/div>)/', $res, $courtesy, PREG_OFFSET_CAPTURE);
    $courtesy = $courtesy[0][0];
    
    //Echos
    echo $title;
    echo $authors;
    //echo $keywords
    echo $content;
    echo $references;
    echo $courtesy;
?>