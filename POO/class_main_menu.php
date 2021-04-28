<?php

/**
 * MainMenu
 * 
 * Created on Tue Apr 22 2021
 * Latest update on Mon Apr 26 2021
 * Info - PHP Class for the main menu
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

class MainMenu {

    protected $title;
    protected $position; 
    //boolean to activate some menu parts
    protected $My_Tasks;
    protected $Open_Tasks;
    protected $Processed_Tasks;
    protected $Rejected_Tasks;
    protected $Insertion;
  
    /**
     * __construct
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $position
     *            position refers to which part of the menu is active, in which part of the menu we are actually.
     * @return void
     */
    public function __construct($position) {
        $this->title = "Outil Biblio";
        $this->position = $position;
        $this->setMyTasks(true);
        $this->setOpenTasks(true);
        $this->setProcessedTasks(true);
        $this->setRejectedTasks(true);
        $this->setInsertion(true);
    }

    
    /**
     * write function will echo the menu's html for each active sections
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @return void
     */
    public function write() {
        $html = '<div class="menu d-flex flex-column bg-light p-3 sticky-top" style="width: 16em; height: 100vh;">
                    <div class="col-md-auto">
                        <img src="/pictures/logo_small-top.png" width="30">
                        <span class="fs-5">'.$this->title.'</span></div><hr>
                        <ul class="nav nav-pills flex-column mb-auto">';

        if($this->My_Tasks) {
            if ($this->position == "to_treat") { $this->position = "My_Tasks"; }
            $html = $this->writeOne($html, 'My_Tasks', '/Projet_stage/trie_table_statut/page_table.php', "?status=to_treat");
        }
        if($this->Open_Tasks) {
            if ($this->position == "undefined") { $this->position = "Open_Tasks"; }
            $html = $this->writeOne($html, 'Open_Tasks', '/Projet_stage/trie_table_statut/page_table.php', "?status=undefined");
        }
        if($this->Processed_Tasks) {
            if ($this->position == "treat") { $this->position = "Processed_Tasks"; }
            $html = $this->writeOne($html, 'Processed_Tasks', '/Projet_stage/trie_table_statut/page_table.php', "?status=treat");
        }
        if($this->Rejected_Tasks) {
            if ($this->position == "reject") { $this->position = "Rejected_Tasks"; }
            $html = $this->writeOne($html, 'Rejected_Tasks', '/Projet_stage/trie_table_statut/page_table.php', "?status=reject");
        }
        if($this->Insertion) {
            $html = $this->writeOne($html, 'Insertion', '/Projet_stage/insertion/form.php', "");
        }

        $html = $html . '</ul>
                          <div class="row justify-content-center">
                            <div class="col col-md-auto">
                              <a href="http://www.afmb.univ-mrs.fr" target="_blank">
                                <img src="/pictures/logo_afmb.png" width="50" height="50">
                              </a>
                            </div>
                            <div class="col col-md-auto">
                              <a href="https://www.cea.fr/Pages/le-cea/les-centres-cea/cadarache.aspx" target="_blank">
                                <img src="/pictures/logo_cea.png" width="50" height="50">
                              </a>
                            </div>
                          </div>
                          <hr>
                          <div>
                            <div class="row justify-content-start">
                              <div class="col-md-auto">
                                <!-- Disconenct Button -->
                                <form action="/disconnect.php" method="post">
                                  <button class="btn btn-outline-danger" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                      <path d="M7.5 1v7h1V1h-1z"></path>
                                      <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"></path>
                                    </svg>
                                  </button>
                                </form>
                              </div>
                              <div class="col-md-auto mt-1">
                                <strong>'.$_SESSION['connexion'].'</strong>
                              </div>
                            </div>
                          </div>
                        </div>';
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
     * @param  mixed $file
     *            $file refers to the file or the html/php/etc item to go as href when we click on this menu section.
     * @param  mixed $parameters
     *            $parameters refers to the possibly given parameters of $file (can be blank).
     * @return void
     */
    private function writeOne($html, $value, $file, $parameters) {
        $valueSpace = str_replace('_', ' ', $value);
        $html = $html . '<li class="nav-item">
                            <a href="'.$file.$parameters.'" class="nav-link link-dark ';
        if($this->position == $value) { $html = $html . 'active text-dark'; }
        $html = $html . '">'.$valueSpace.'</a></li>';
        return $html;
    }

        
    /**
     * setMyTasks is the setter to activate or not the section of the same name.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $value
     *            boolean value.
     * @return void
     */
    public function setMyTasks($value) {
        if (is_bool($value)) { $this->My_Tasks = $value; }
    }

    /**
     * setOpenTasks is the setter to activate or not the section of the same name.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $value
     *            boolean value.
     * @return void
     */
    public function setOpenTasks($value) {
        if (is_bool($value)) { $this->Open_Tasks = $value; }
    }

    /**
     * setProcessedTasks is the setter to activate or not the section of the same name.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $value
     *            boolean value.
     * @return void
     */
    public function setProcessedTasks($value) {
        if (is_bool($value)) { $this->Processed_Tasks = $value; }
    }

    /**
     * setRejectedTasks is the setter to activate or not the section of the same name.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $value
     *            boolean value.
     * @return void
     */
    public function setRejectedtasks($value) {
        if (is_bool($value)) { $this->Rejected_Tasks = $value; }
    }
    /**
     * setInsertion is the setter to activate or not the section of the same name.
     * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
     * @param  mixed $value
     *            boolean value.
     * @return void
     */
    public function setInsertion($value) {
        if (is_bool($value)) { $this->Insertion = $value; }
    }
}
?>