<div class="menu d-flex flex-column bg-light p-3 sticky-top" style="width: 200px; height: 100vh;">
  <div class="col-md-auto">
    <img src="../pictures/logo_small-top.png" width="30">
    <span class="fs-5">Outil Biblio</span>
  </div>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
      <a href="http://localhost/Projet_stage/test_insertion_simple/test_fenetre_indefini.php?statut=to_treat" class="nav-link link-dark <?php if($menu == 'myTasks') echo 'active text-dark'; ?>">
        My Tasks
      </a>
    </li>
    <li>
      <a href="http://localhost/Projet_stage/test_insertion_simple/test_fenetre_indefini.php?statut=undefined" class="nav-link link-dark <?php if($menu == 'openTasks') echo 'active text-dark'; ?>">
        Tasks Undefined
      </a>
    </li>
    <hr>
    <li>
      <a href="http://localhost/Projet_stage/test_insertion_simple/test_fenetre_indefini.php?statut=treat" class="nav-link link-dark <?php if($menu == 'processedTasks') echo 'active text-dark'; ?>">
         Processed Tasks
      </a>
    </li>
    <li>
      <a href="http://localhost/Projet_stage/test_insertion_simple/test_fenetre_indefini.php?statut=reject" class="nav-link link-dark <?php if($menu == 'rejectedtasks') echo 'active text-dark'; ?>">
        Rejected Tasks
      </a>
    </li>
    <hr>
    <li>
      <a href="http://localhost/Projet_stage/test_insertion_simple/form.php" class="nav-link link-dark <?php if($menu == 'insert') echo 'active text-dark'; ?>">
        Insert
      </a>
    </li>
  </ul>
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
</div>
