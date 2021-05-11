<?php
//IMPORT CLASSES
require("../POO/class_saveload_strategies.php");

/**
 * ArticleFetcher
 * 
 * Created on Fri Apr 30 2021
 * Latest update on Tue May 11 2021
 * Info - PHP Class to fetch the xml content of the articles.
 * Usage: refers to the readArticle.php file: Do the followings
 * Instantiate object, call doExist(NUMACCESS), is true call hasRights(), if true call fetch(), fetch() will return true if could fetch, false else with an error message.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */
class ArticleFetcher {

    protected $origin;
    protected $numaccess;
    protected $article;
    protected $saveload;
    
    /**
     * __construct
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $numaccess
     *            the NUM_ACCESS of the article to whom we will fetch the xml content in the database or download it.
     * @return void
     */
    public function __construct($origin, $numaccess) {
        $this->origin = $origin;
        $this->numaccess = $numaccess;
        $this->saveload = new SaveLoadStrategies("../");
    }
    
    /**
     * doExist function will check if an article with this num_access do exist in the database.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return true if an article of num_access exist, false if not (with an error message).
     */
    public function doExist() {
        $cols = array(); array_push($cols, "origin", "num_access");
        $conditions = array(); array_push($conditions, array("num_access", $this->numaccess),  array("origin", $this->origin));
        if($this->saveload->checkAsDB("article", $cols, $conditions)) { 
            $this->article = $this->saveload->loadAsDB("article", array("*"), $conditions, null)[0];
            return true;
        } else {
            $errorCode = 404;
            $this->printError("danger", 'Couldn\'t find article with NUMACCESS='.$this->numaccess.' from '.$this->origin.' in the database.', $errorCode);
            http_response_code($errorCode); 
            return false;
        }
    }

    /**
     * getter on the article item
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return the stored article item
     */
    public function getArticle() {
        return $this->article;
    }
    
    /**
     * hasRights function will check if an userID have the rights to work on an article, given previously with doExist().
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $userID
     * @return true if the given userID do have the right to work on this article of num_access, false if not (with an error message).
     */
    public function hasRights($userID) {
        if($this->article['user'] == $userID) {
            return true;
        } else {
            $errorCode = 403;
            $this->printError("danger", 'You don\'t have the right to work on this article. If you think you had the rights, please refer this issue to your administrator or your team.', $errorCode);
            http_response_code($errorCode); 
            return false;
        }
    }

    /**
     * fetch function will fetch the article depending of if it have a PMCID or not. If it does, will return fetchByPMCID to get the xml of the article and the success boolean.
     * For now no other version are available, hence if the article don't have a pmcid, will return an error.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return true if the fetch was sucessful, false if not.
     */
    public function fetch() {
        //todo fetch if a pmcid was added
        switch($this->article['origin']) {
            case "pubmed":
                if(!empty($this->article['pmcid'])) { return $this->fetchByPMCID(); }
                return true;
                break;
            case "default":
                $errorCode = 400;
                $this->printError("warning", 'Couldn\'t fetch article with NUMACCESS='.$this->numaccess.' from '.$this->origin.'. It is either because an error occured, either because we can\'t yet download this kind of article 
                (it depends of the database and/or the journal of this publication). Please refer this issue to your administrator or your team.', $errorCode);
                http_response_code($errorCode); 
                return false; 
        }
    }

     /**
     * fetchByPMCID function will fetch the article in two ways: if the xml isn't stored yet, call the fetchPMC() function to get it. 
     * Then if the xml isn't empty (or its an error), echo the xml content.
     * For now no other version are available, hence if the article don't have a pmcid, will return an error.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return true if the fetch of xml content was sucessfull, false if not or empty
     */
    public function fetchByPMCID() {
        if(empty($this->article['html_xml'])) { $this->fetchPMC(); }
        if(!empty($this->article['html_xml'])) {
            //echo $this->article['html_xml'];
            return true;
        } else {
            $errorCode = 400;
            $this->printError("warning", "Couldn't fetch article with NUMACCESS=".$this->numaccess.' from '.$this->origin.". Please refer this issue to your administrator or your team.", $errorCode);
            http_response_code($errorCode); 
            return false; 
        }
        
    }

     /**
     * fetchPMCID function will download the content of the PMC page using the fromPMCID.php script and store it in database (called with addHTMLXMLByPMCID).
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return true if the fetch and download of xml content was sucessfull, false if not or if an error occured
     */
    public function fetchPMC() {
        $this->saveload->DB()->addHTMLXMLByPMCID($this->article['num_access'], $this->article['pmcid']);
        $this->article = $this->saveload->loadAsDB("article", array("*"), array(array("num_access", $this->article['num_access'])), null)[0];
        if(!empty($this->article['html_xml'])) { return true; }
        else { return false; }
    }

    /**
     * fetchHTML will, depending of the article characteristic, be able to link the corresponding pdf.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return true the fetch of html content was sucessfull, false if not or if an error occured
     */
    public function fetchHTML($tags) {
        if($this->article['origin'] == "pubmed") {
            if(!empty($this->article['pmcid']) && !empty($this->getArticle()['html_xml'])) {                
                return '<div id="html" class="switchDisplay"'.$tags.'>'.$this->getArticle()['html_xml'].'</div>';
            }
        }
        return false;
    }

     /**
     * fetchPDF will, depending of the article characteristic, be able to link the corresponding pdf.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return true the fetch of pdf content was sucessfull, false if not or if an error occured
     */
    public function fetchPDF($tags) {
        if($this->article['origin'] == "pubmed") {
            if(!empty($this->article['pmcid'])) {               
                return '<div id="pdf" class="switchDisplay"'.$tags.'><iframe class="w-100" style="height: 90vh;" src="'.'https://www.ncbi.nlm.nih.gov/pmc/articles/'.$this->article['pmcid'].'/pdf/'.'"></iframe></div>';
            }
            else {
                $search = new SimpleXMLElement(file_get_contents('https://www.ncbi.nlm.nih.gov/pmc/utils/idconv/v1.0/?ids='.$this->article['num_access']));
                $doi = array($search->record->attributes()->doi)[0]; 
                return '<div id="pdf" class="switchDisplay"'.$tags.'><iframe class="w-100" style="height: 90vh;" src="'.'https://www.doi.org/'.$doi.'"></iframe></div>';
            }
        }
        return false;
    }

    /**
     * fetchXML will, depending of the article characteristic, be able to link the corresponding xml.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return true the fetch of xml content was sucessfull, false if not or if an error occured
     */
    public function fetchXML($tags) {
        if($this->article['origin'] == "pubmed") {
            if(!empty($this->article['pmcid'])) {
                $_GET['PMCID'] = $this->article['pmcid'];
                $_GET['xml'] = "";
                $xml = include('../utils/fromPMCID/fromPMCID.php');    
                return '<div id="xml" class="switchDisplay w-100" '.$tags.'>'.$xml.'</div>';
            }
        }
        return false;
    }

    public function printError($type, $content, $errorCode) {
        echo '<div class="alert alert-'.$type.'" role="alert">'.$content.'<br>[ERROR CODE: '.$errorCode.']</div>';
    }
}
?>