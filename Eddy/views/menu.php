<div class="menu d-flex flex-column bg-light p-3 sticky-top" style="width: 200px; height: 100vh;">
  <div class="col-md-auto">
    <img src="../pictures/logo_small-top.png" width="30">
    <span class="fs-5">Outil Biblio</span>
  </div>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
      <a href="myTasks.php" class="nav-link link-dark <?php if($menu == 'myTasks') echo 'active text-dark'; ?>">
        My Tasks
      </a>
    </li>
    <li>
      <a href="#" class="nav-link link-dark <?php if($menu == 'openTasks') echo 'active text-dark'; ?>">
        Open Tasks
      </a>
    </li>
    <li>
      <a href="#" class="nav-link link-dark <?php if($menu == 'undefinedTasks') echo 'active text-dark'; ?>">
        Undefined Tasks
      </a>
    </li>
    <hr>
    <li>
      <a href="#" class="nav-link link-dark <?php if($menu == 'processedTasks') echo 'active text-dark'; ?>">
         Processed Tasks
      </a>
    </li>
    <li>
      <a href="#" class="nav-link link-dark <?php if($menu == 'rejectedtasks') echo 'active text-dark'; ?>">
        Rejected Tasks
      </a>
    </li>
    <hr>
    <li>
      <a href="insertion.php" class="nav-link link-dark <?php if($menu == 'insert') echo 'active text-dark'; ?>">
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
        <strong><?php #echo $_SESSION["connexion"] ?></strong>
      </div>
    </div>
  </div>
</div>