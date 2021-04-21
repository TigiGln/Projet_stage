<link href="./modules/edit_article_menu/Annotate/comment.css" rel="stylesheet"/>
<div id="subMenu">
	<div id="commentEditor" class="commentEditor d-flex flex-column" style="pointer-events: none; user-select: none;">
	  <div class="commentToolbar">
	  	<div class="alert alert-secondary mt-0 mb-0">Selection:</div>
		<div class="selected overflow-auto alert-light mt-0 mb-0">
			<div id="selection"></div>
	  	</div>
	  	<div class="alert alert-secondary mt-0 mb-0 p-1">
		<button id="commentSave" type="button" onclick="commentSend([ID])" class="btn btn-success">S</button>
    	<button id="commentAbort" type="button" onclick="commentClose()" class="btn btn-danger">X</button>
	  	Write a comment:
	  </div>
	    <div class="line bg-light">
	      <!-- Actions -->
	    <div class="commentBox row text-center">
	        <span class="commentAction col-md-auto" data-action="bold" title="Bold">
	          <img src="https://image.flaticon.com/icons/svg/25/25432.svg">
	        </span>
	        <span class="commentAction col-md-auto" data-action="italic" title="Italic">
	          <img src="https://image.flaticon.com/icons/svg/25/25392.svg">
	        </span>
	        <span class="commentAction col-md-auto" data-action="underline" title="Underline">
	          <img src="https://image.flaticon.com/icons/svg/25/25433.svg">
	        </span>
	        <span class="commentAction col-md-auto" data-action="createLink" title="Insert Link">
	          <img src="https://image.flaticon.com/icons/svg/25/25385.svg">
	        </span>
	        <span class="commentAction col-md-auto" data-action="unlink" title="Unlink">
	          <img src="https://image.flaticon.com/icons/svg/25/25341.svg">
	        </span>
	        <span class="commentAction col-md-auto" data-action="undo" title="Undo">
	          <img src="https://image.flaticon.com/icons/svg/25/25249.svg">
	        </span>
	        <span class="commentAction col-md-auto" data-action="removeFormat" title="Remove format">
	          <img src="https://image.flaticon.com/icons/svg/25/25454.svg">  
	        </span>
	        <input id="commentColorPicker" type="color" class="align-middle" value="#ffff00">
	        <span id="commentCode" class="commentAction" data-action="code" title="Show HTML-Code" hidden></span>
	    </div>
	  	</div>
	  <div id="commentArea">
	     <div id="commentVisualView" contenteditable="true"></div>
	    <textarea id="commentHtmlView"></textarea>
	  </div>
	</div>
	<div class="alert alert-secondary mt-0 mb-0 p-1">Comments Thread:</div>
	<div id="comments" class="thread overflow-auto alert alert-light mt-0 mb-0">
		<!---->
  	</div>
	<script src="./modules/edit_article_menu/Annotate/comment-INTERACTIONS.js"></script>
	<script src="./modules/edit_article_menu/Annotate/comment-WYSIWYG.js"></script>
</div>
</div>