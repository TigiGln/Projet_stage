<?php

/**
 * SaveLoadStrategies
 * 
 * Created on Fri Apr 30 2021
 * Latest update on Fri Apr 30 2021
 * Info - PHP Class for different saves strategies
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */
class SaveLoadStrategies {

    protected $file;
    protected $connexionbd;
    protected $manager;
    
    /**
     * __construct
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return void
     */
    public function __construct($path) {
        require($path."/class_connexion.php");
        require($path."/class_manager_bd.php");
    }

        
    /**
     * saveAsXML
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $file
     *            the path to file to save.
     * @param  mixed $datas
     *            an array of arrays of ... where we save datas.
     *            usage: array(ID, array(array(primarytag, name, value), array(array(tag, value), array(tag, value), ...)))
     *            For now only allow to save one primarytag at a time
     * @param  mixed $overwrite
     *            overwrite if a similar PRIMARY TAG exist
     * @return http response code
     */
    public function saveAsXML($file, $datas, $overwrite) {
        $ID = $datas[0];
        $PRIMARYTAGDATA = $datas[1][0][0];
        $PRIMARYTAGVALUE = $datas[1][0][1];
        $PRIMARYTAGNAME = $datas[1][0][2];
        $values = $datas[1][1];

        if(file_exists($file)) {
            $xml = simplexml_load_file($file);
            if(!isset($xml->$ID)) { $xml->addChild($ID, " "); }
            $didExist = false;
            if($overwrite) {
                foreach ($xml->$ID->{$PRIMARYTAGDATA} as $primaryTag) {
                    $atr = $primaryTag->attributes();
                    if($atr == $PRIMARYTAGVALUE) {
                        $didExist = true;
                        for ($i = 0; $i < sizeof($values); $i++) {
                            $tag = strval($values[$i][0]);
                            $primaryTag->$tag = strval($values[$i][1]); 
                        }
                    }
                }
            }
            if(!$didExist) {
                $primaryTag = $xml->$ID->addChild($PRIMARYTAGDATA,'');
                $primaryTag->addAttribute($PRIMARYTAGVALUE, $PRIMARYTAGNAME);
                for ($i = 0; $i < sizeof($values); $i++) {
                    $primaryTag->addChild($values[$i][0], strval($values[$i][1]));
                }
            } 
            $save = $xml->saveXML($file);
            return ($save != false) ?  200 : 424;
        } else { return 404; }
    }

    public function loadAsXML($file, $ID) {
    }
}
?>