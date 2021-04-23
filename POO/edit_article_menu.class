<?php
class editArticleMenu {
    protected $ArtID;
    //boolean to activate some menu parts
    protected $Notes;
    protected $Annotate;
    protected $Cazy;
    protected $Send;
    protected $Conclude;

    //Constructor
    public function __construct($ArtID) {
        $this->ArtID = $ArtID;
        $this->setNotes(true);
        $this->setAnnotate(true);
        $this->setCazy(true);
        $this->setSend(true);
        $this->setConclude(true);
    }

    //Write function, to write the menu with what we activated or not.
    public function write() {
        //beginning
        $html = '<div class="bg-light overflow-auto" style="width: 25em; height: 100vh;">
                    <div class="accordion accordion-flush bg-light" id="menu-article">';
        //check every menu variables:
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
        //end
        $html = $html . '</div></div>';
        //echo
        echo $html;
    }

    //Write a menu category
    private function writeOne($html, $value) {
        $name = str_replace('_', ' ', $value);
        $file = str_replace('_', '', $value);
        $data = file_get_contents('./modules/edit_article_menu/'.$file.'/'.$file.'.php');
        $data = str_replace('[ID]', $this->ArtID, $data);
        $html = $html . '<div class="accordion-item">
                            <h2 class="accordion-header">
                            <button id="'.$file.'Btn" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#article-'.$file.'">'.$name.'</button>
                            </h2>
                            <div id="article-'.$file.'" class="accordion-collapse collapse">
                                <div class="accordion-body p-0 m-0">'.$data.'</div></div></div>';
        return $html;
    }

    //Setters, change the menu booleans
    public function setNotes($value) {
        if (is_bool($value)) { $this->Notes = $value; }
    }
    public function setAnnotate($value) {
        if (is_bool($value)) { $this->Annotate = $value; }
    }
    public function setCazy($value) {
        if (is_bool($value)) { $this->Cazy = $value; }
    }
    public function setSend($value) {
        if (is_bool($value)) { $this->Send = $value; }
    }
    public function setConclude($value) {
        if (is_bool($value)) { $this->Conclude = $value; }
    }
}
?>