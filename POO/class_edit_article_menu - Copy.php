<?php

/**
 * EditArticleMenu
 * 
 * Created on Tue Apr 22 2021
 * Latest update on Mon Apr 26 2021
 * Info - PHP Class for the article editing tools' menu
 * The functionning differ from mainMenu, here we include php but never do a href link. 
 * If you require a module in this section asking for parameters, use super variables to store and throw.
 * Example: the page parameters is ?ID=1234, hence it should already live in a super variable, if not add it in $_GET, $_POST or $_GLOBAL to use it in the module.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

class EditArticleMenu {

    protected $ArtID;
    protected $Folder;
    //boolean to activate some menu parts
    protected $Notes;
    protected $Annotate;
    protected $Cazy;
    protected $Send;
    protected $Conclude;

    
    /**
     * __construct
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $ArtID
     *            The ID of the article in the database.
     * @return void
     */
    public function __construct($ArtID) {
        $this->ArtID = $ArtID;
        $this->Folder = "edit_article_menu";
        $this->setNotes(true);
        $this->setAnnotate(true);
        $this->setCazy(true);
        $this->setSend(true);
        $this->setConclude(true);
    }

    /**
     * write function will echo the menu's html for each active sections
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return void
     */
    public function write() {
        $html = '<div class="bg-light overflow-auto" style="width: 25em; height: 100vh;">
                    <div class="accordion accordion-flush bg-light" id="menu-article">';

        if($this->Notes) {
            $html = $this->writeOne($html, 'Notes');
        }
        if($this->Annotate) {
            $html = $this->writeOne($html, 'Annotate');
        }
        if($this->Cazy) {
            $html = $this->writeOne($html, 'Cazy');
        }
        if($this->Send) {
            $html = $this->writeOne($html, 'Send');
        }
        if($this->Conclude) {
            $html = $this->writeOne($html, 'Conclude');
        }

        $html = $html . '</div></div>';

        //echo final html string
        echo $html;
    }

    /**
     * writeOne function will write in the given $html string a menu section.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $html
     *            the given $html string that contains the html code of the menu.
     * @param  mixed $value
     *            $value refers to the variable name of the section, or the section name with underscore instead of spaces.
     * @return void
     */
    private function writeOne($html, $value) {
        $name = str_replace('_', ' ', $value);
        $file = str_replace('_', '', $value);
        $data = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/modules/'.$this->Folder.'/'.$file.'/'.$file.'.php');
        $data = str_replace('[ID]', $this->ArtID, $data);
        $html = $html . '<div class="accordion-item">
                            <h2 class="accordion-header">
                            <button id="'.$file.'Btn" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#article-'.$file.'">'.$name.'</button>
                            </h2>
                            <div id="article-'.$file.'" class="accordion-collapse collapse">
                                <div class="accordion-body p-0 m-0">'.$data.'</div></div></div>';
        return $html;
    }

    /**
     * setNotes is the setter to activate or not the section of the same name.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $value
     *            boolean value.
     * @return void
     */
    public function setNotes($value) {
        if (is_bool($value)) { $this->Notes = $value; }
    }

    /**
     * setAnnotate is the setter to activate or not the section of the same name.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $value
     *            boolean value.
     * @return void
     */
    public function setAnnotate($value) {
        if (is_bool($value)) { $this->Annotate = $value; }
    }

    /**
     * setCazy is the setter to activate or not the section of the same name.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $value
     *            boolean value.
     * @return void
     */
    public function setCazy($value) {
        if (is_bool($value)) { $this->Cazy = $value; }
    }

    /**
     * setSend is the setter to activate or not the section of the same name.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $value
     *            boolean value.
     * @return void
     */
    public function setSend($value) {
        if (is_bool($value)) { $this->Send = $value; }
    }

    /**
     * setConclude is the setter to activate or not the section of the same name.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $value
     *            boolean value.
     * @return void
     */
    public function setConclude($value) {
        if (is_bool($value)) { $this->Conclude = $value; }
    }
}
?>