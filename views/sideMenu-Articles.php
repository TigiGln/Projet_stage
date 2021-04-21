<div class="bg-light overflow-auto" style="width: 25em; height: 100vh;">
  <div class="accordion accordion-flush bg-light overflow-auto" id="menu-article" >
    <!-- Notes -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button id="notesBtn" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#article-note">
          Notes
        </button>
      </h2>
      <!-- add data-bs-parent="#menu-article" to auto hide-->
      <div id="article-note" class="accordion-collapse collapse">
        <div class="accordion-body p-0 m-0">
        <?php include('./utils/notes/notes.php'); ?>
        </div>
      </div>
    </div>
    <!-- Annotate -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button id="annotateBtn" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#article-comment">
          Annotate
        </button>
      </h2>
      <div id="article-comment" class="accordion-collapse collapse">
        <div class="accordion-body p-0 m-0">
          <?php include('./utils/comment/comment.php'); ?>
        </div>
      </div>
    </div>
    <!-- CAZy -->
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button id="cazyBtn" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#article-cazy">
          CAZy Tab
        </button>
      </h2>
      <div id="article-cazy" class="accordion-collapse collapse">
        <div class="accordion-body p-0 m-0">
        </div>
      </div>
    </div>
  </div>
</div>