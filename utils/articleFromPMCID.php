<?php
    /**
    * RAW HTML GETTER + Clean up datas
    * author: Eddy IKHLEF
    * TAXONOMY OF PMID ARTICLES
    (Version 1)
    * classes:
        content-title: title of the article
        contrib-group fm-author: list of author (inside a links)
    * ids:
        ass-data: associated datas of the article
        AbsX: abstract number X
            class head: Abstract
            ids __secX: section number X of the abstract
            class sec: section of keywords (inside kwd-text class span)
        SecX: section number X
            inside is similar as absX one:
            class head: title of the section
            ParX: paragraph X of the section
        __secX: Acknowledgements, text content inside a sec class
        idmXXXXXX: others ressources.
        Bib1 (BibX): bibliography
            CRX for references Ids

        Note: paragraph and section values are globals, if a section has 10 paragraphs, then the following section will start with paragraphs 11.

        (Version 2)
    * classes:
        content-title: title of the article
        contrib-group fm-author: list of author (inside a links)
    * ids:
        ass-data: associated datas of the article
        (first) idmXXXXXX: abstract
        __secX: section number X
        sd: supplementary materials
        Bib1 (BibX): bibliography
            CRX for references Ids
        (others) idmXXXXXX: others ressources. (including references)

        Note: idmXXXXXX reffering the same items aren't the same between articles.

    */
    //Prepare Curl request
    //Later the ID will be called
    $ID = "7531976";
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
    $res = preg_replace('/(^<img loading="lazy" alt="An external file that holds a picture, illustration, etc).*(jpg">)/s', '', $res);
    $res = str_replace('<img loading="lazy"', '<img hidden loading="lazy" ', $res);
    $res = str_replace('href="/pmc/articles', 'target="_BLANK" href="https://www.ncbi.nlm.nih.gov/pmc/articles', $res); 
    $res = str_replace('<a class="figpopup" href="/pmc/articles', '<a class="figpopup" hidden target="_BLANK" href="https://www.ncbi.nlm.nih.gov/pmc/articles', $res); //hide other figure ref 
    $res = str_replace('href="/pubmed/', 'target="_BLANK" href="https://pubmed.ncbi.nlm.nih.gov/', $res);
    $res = str_replace('href="/nuccore/', 'target="_BLANK" href="https://www.ncbi.nlm.nih.gov/nuccore/', $res);
    $res = str_replace('src="/corehtml/pmc/pmcgifs/corrauth.gif"', 'src="https://www.ncbi.nlm.nih.gov/corehtml/pmc/pmcgifs/corrauth.gif"', $res); 
    //Step 2: Find content
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
    preg_match('/(<div class="contrib-group fm-author).*?(<div class="fm-panel half_rhythm">)/s', $res, $authors, PREG_OFFSET_CAPTURE); //Work when disclaimer is here. if not need to update
    str_replace('<div class="fm-panel half_rhythm">', '', $authors);
    $authors = $authors[0][0];
    
    //Abstract
    preg_match('/(<div id="Abs1).*?(class="kwd-title")/s', $res, $abstract, PREG_OFFSET_CAPTURE);
    str_replace('class="kwd-title"', '', $abstract);
    $abstract = $abstract[0][0];

    //Keywords
    preg_match('/(<strong class="kwd-title">).*?(<div id="Sec1)/s', $res, $keywords, PREG_OFFSET_CAPTURE);
    str_replace('<div id="Sec1', '', $keywords);
    //str_replace('Keywords', '', $keywords);
    $keywords = $keywords[0][0];

    //Sections (need to goes from abstract then remove it, I didn't found other possibilities)
    preg_match('/(<div id="Abs1).*?(<div id="Bib)/s', $res, $sections, PREG_OFFSET_CAPTURE);
    $sections = $sections[0][0];
    $sections = preg_replace('/(<div id="Abs1).*?(<\/em><\/span><\/div>)/s', '', $sections);

    //References
    preg_match('/(<div id="Bib).*?(<\/div><\/div><\/div>)/s', $res, $references, PREG_OFFSET_CAPTURE);
    $references = $references[0][0];

    //Courtesy
    preg_match('/(<div class="half_rhythm">Articles from <span).*(<\/div>)/', $res, $courtesy, PREG_OFFSET_CAPTURE);
    str_replace('<hr>', '', $courtesy);
    $courtesy = $courtesy[0][0];
    

    //Echos
    //echo $title;
    //echo $authors;
    //echo $abstract;
    //echo $keywords;
    //echo $sections;
    //echo $references;
    //echo $courtesy;
?>
<?php
#Using previous version
/*
    //Title
    preg_match('/(<h1 class="content-title).*?(<\/h1>)/s', $res, $title, PREG_OFFSET_CAPTURE);
    $title = $title[0][0];

    //Authors
    preg_match('/(<div class="contrib-group fm-author).*?(<div class="fm-panel half_rhythm">)/s', $res, $authors, PREG_OFFSET_CAPTURE); //Work when disclaimer is here. if not need to update
    str_replace('<div class="fm-panel half_rhythm">', '', $authors);
    $authors = $authors[0][0];
    
    //Abstract
    preg_match('/(<div id="Abs1).*?(class="kwd-title")/s', $res, $abstract, PREG_OFFSET_CAPTURE);
    str_replace('class="kwd-title"', '', $abstract);
    $abstract = $abstract[0][0];

    //Keywords
    preg_match('/(<strong class="kwd-title">).*?(<div id="Sec1)/s', $res, $keywords, PREG_OFFSET_CAPTURE);
    str_replace('<div id="Sec1', '', $keywords);
    //str_replace('Keywords', '', $keywords);
    $keywords = $keywords[0][0];

    //Sections (need to goes from abstract then remove it, I didn't found other possibilities)
    preg_match('/(<div id="Abs1).*?(<div id="Bib)/s', $res, $sections, PREG_OFFSET_CAPTURE);
    $sections = $sections[0][0];
    $sections = preg_replace('/(<div id="Abs1).*?(<\/em><\/span><\/div>)/s', '', $sections);

    //References
    preg_match('/(<div id="Bib).*?(<\/div><\/div><\/div>)/s', $res, $references, PREG_OFFSET_CAPTURE);
    $references = $references[0][0];

    //Courtesy
    preg_match('/(<div class="half_rhythm">Articles from <span).*(<\/div>)/', $res, $courtesy, PREG_OFFSET_CAPTURE);
    str_replace('<hr>', '', $courtesy);
    $courtesy = $courtesy[0][0];
    

    //Echos
    //echo $title;
    //echo $authors;
    //echo $abstract;
    //echo $keywords;
    //echo $sections;
    //echo $references;
    //echo $courtesy;
    */
?>