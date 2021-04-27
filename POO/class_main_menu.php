<?php
class mainMenu {
    //Add field for each menu part
    protected $title; //Menu title
    protected $position; //Menu title
    //boolean to activate some menu parts
    protected $My_Tasks;
    protected $Open_Tasks;
    protected $Processed_Tasks;
    protected $Rejected_Tasks;
    protected $Insertion;

    //Constructor
    public function __construct($position) {
        $this->title = "Outil Biblio";
        $this->position = $position;
        $this->setMyTasks(true);
        $this->setOpenTasks(true);
        $this->setProcessedTasks(true);
        $this->setRejectedTasks(true);
        $this->setInsertion(true);
    }

    //Write function, to write the menu with what we activated or not.
    public function write() {
        //beginning
        $html = '<div class="menu d-flex flex-column bg-light p-3 sticky-top" style="width: 16em; height: 100vh;">
                    <div class="col-md-auto">
                        <img src="../pictures/logo_small-top.png" width="30">
                        <span class="fs-5">'.$this->title.'</span></div><hr>
                        <ul class="nav nav-pills flex-column mb-auto">';
        //check every menu variables:
        if($this->My_Tasks) {
            if ($this->position == "to_treat") { $this->position = "My_Tasks"; }
            $html = $this->writeOne($html, 'My_Tasks', '../trie_table_statut/page_table.php', "?status=2");
        }
        if($this->Open_Tasks) {
            if ($this->position == "undefined") { $this->position = "Open_Tasks"; }
            $html = $this->writeOne($html, 'Open_Tasks', '../trie_table_statut/page_table.php', "?status=1");
        }
        if($this->Processed_Tasks) {
            if ($this->position == "treat") { $this->position = "Processed_Tasks"; }
            $html = $this->writeOne($html, 'Processed_Tasks', '../trie_table_statut/page_table.php', "?status=3");
        }
        if($this->Rejected_Tasks) {
            if ($this->position == "reject") { $this->position = "Rejected_Tasks"; }
            $html = $this->writeOne($html, 'Rejected_Tasks', '../trie_table_statut/page_table.php', "?status=4");
        }
        if($this->Insertion) {
            $html = $this->writeOne($html, 'Insertion', '../insertion/form.php', "");
        }
        //end
        $html = $html . '</ul>
                          <div class="row justify-content-center">
                            <div class="col col-md-auto">
                              <a href="http://www.afmb.univ-mrs.fr" target="_blank">
                                <img src="../pictures/logo_afmb.png" width="50" height="50">
                              </a>
                            </div>
                            <div class="col col-md-auto">
                              <a href="https://www.cea.fr/Pages/le-cea/les-centres-cea/cadarache.aspx" target="_blank">
                                <img src="../pictures/logo_cea.png" width="50" height="50">
                              </a>
                            </div>
                          </div>
                          <hr>
                          <div>
                            <div class="row justify-content-start">
                              <div class="col-md-auto">
                                <!-- Disconenct Button -->
                                <form action="disconnect.php" method="post">
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
        //echo
        echo $html;
    }

    //Write a menu category
    private function writeOne($html, $value, $file, $parameters) {
        $valueSpace = str_replace('_', ' ', $value);
        $html = $html . '<li class="nav-item">
                            <a href="'.$file.$parameters.'" class="nav-link link-dark ';
        if($this->position == $value) { $html = $html . 'active text-dark'; }
        $html = $html . '">'.$valueSpace.'</a></li>';
        return $html;
    }

    //Setters, change the menu booleans
    public function setMyTasks($value) {
        if (is_bool($value)) { $this->My_Tasks = $value; }
    }
    public function setOpenTasks($value) {
        if (is_bool($value)) { $this->Open_Tasks = $value; }
    }
    public function setProcessedTasks($value) {
        if (is_bool($value)) { $this->Processed_Tasks = $value; }
    }
    public function setRejectedtasks($value) {
        if (is_bool($value)) { $this->Rejected_Tasks = $value; }
    }
    public function setInsertion($value) {
        if (is_bool($value)) { $this->Insertion = $value; }
    }
}
?>